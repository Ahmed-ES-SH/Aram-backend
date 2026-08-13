<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;
use App\Models\Invoice;
use App\Http\Services\PaymentService;
use App\Http\Services\ProcessBookPaymentService;
use App\Http\Services\ProcessCardsPaymentService;
use App\Http\Services\ProcessServiceDealPayment;
use App\Http\Services\ProcessServicePayment;
use App\Http\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Jobs\ProcessPaymentJob;
use Exception;
use App\OpenApi\Responses\ErrorResponse;
use App\OpenApi\Responses\OkResponse;
use App\OpenApi\Responses\ServerErrorResponse;
use App\OpenApi\Responses\UnauthorizedResponse;
use App\OpenApi\Responses\UnprocessableResponse;

class PaymentController extends Controller
{

    use ApiResponse;

    protected $paymentService;
    protected $proccessCardsPaymentService;
    protected $proccessBookPaymentService;
    protected $processServicePayment;

    protected $processServiceDealPayment;

    public function __construct(
        PaymentService $paymentService,
        ProcessCardsPaymentService $proccessCardsPaymentService,
        ProcessBookPaymentService $proccessBookPaymentService,
        ProcessServicePayment $processServicePayment,
        ProcessServiceDealPayment $processServiceDealPayment
    ) {
        $this->paymentService = $paymentService;
        $this->proccessCardsPaymentService = $proccessCardsPaymentService;
        $this->proccessBookPaymentService = $proccessBookPaymentService;
        $this->processServicePayment = $processServicePayment;
        $this->processServiceDealPayment = $processServiceDealPayment;
    }

    #[OA\Post(
        path: '/payment/create-session',
        summary: 'Create a Thawani payment session',
        security: [['sanctum' => []]],
        tags: ['Payments'],
        responses: [
            new OkResponse('Payment session'),
            new UnauthorizedResponse(),
            new ErrorResponse(500, 'Session creation failed'),
        ],
    )]
    public function createSession(Request $request)
    {
        try {
            $response = $this->paymentService->createSession($request);
            return response()->json($response);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'فشلت عملية إنشاء الجلسة',
                'error' => $e->getMessage(),
            ], 500);
        }
    }



    #[OA\Post(
        path: '/payment/callback',
        summary: 'Handle a payment callback after the Thawani checkout',
        security: [['sanctum' => []]],
        tags: ['Payments'],
requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['provisionalData_id', 'invoice_number', 'payment_type'],
                properties: [
                    new OA\Property(property: 'provisionalData_id', type: 'string'),
                    new OA\Property(property: 'invoice_number', type: 'string'),
                    new OA\Property(property: 'payment_type', type: 'string', enum: ['cards', 'book', 'service', 'deal_service']),
                    new OA\Property(property: 'payment_id', type: 'string', nullable: true),
                    new OA\Property(property: 'session_id', type: 'string', nullable: true),
                ],
            ),
        ),
        responses: [
            new OkResponse('Payment processed'),
            new UnprocessableResponse(),
            new UnauthorizedResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function callback(Request $request)
    {
        $validated = $request->validate([
            'provisionalData_id' => 'required|exists:provisional_data,uniqueId',
            'invoice_number' => 'required',
            'payment_type' => 'required|in:cards,book,service,deal_service',
            'payment_id' => 'nullable',
            'session_id' => 'nullable',
        ]);

        $type = $validated['payment_type'];

        try {
            $response = match ($type) {
                'cards' => $this->proccessCardsPaymentService->processCardsPayment($request),
                'book' => $this->proccessBookPaymentService->processBookPayment($request),
                'service' => $this->processServicePayment->processServicePayment($request),
                'deal_service' => $this->processServiceDealPayment->processServiceDealPayment($request),
                default => throw new Exception('Invalid payment type provided.', 422),
            };

            return response()->json($response, 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode() ?? 500);
        }
    }


    #[OA\Post(
        path: '/payment/webhook',
        summary: 'Handle the Thawani webhook (signature verified)',
        security: [['sanctum' => []]],
        tags: ['Payments'],
        parameters: [
            new OA\Parameter(name: 'thawani-signature', in: 'header', required: true, schema: new OA\Schema(type: 'string'), description: 'HMAC signature header'),
            new OA\Parameter(name: 'thawani-timestamp', in: 'header', required: true, schema: new OA\Schema(type: 'string'), description: 'Timestamp header'),
        ],
        responses: [
            new OkResponse('Webhook accepted'),
            new ErrorResponse(401, 'Invalid signature'),
            new ErrorResponse(500, 'Failed to dispatch payment job'),
        ],
    )]
    public function webhook(Request $request)
    {
        // 1. Verify Signature
        if (!$this->verifyThawaniSignature($request)) {
            Log::error('Invalid Thawani Signature');
            return response()->json(['status' => 'error', 'message' => 'Invalid Signature'], 401);
        }

        $payload = $request->all();

        // 2. Verify Payment Status
        if (!isset($payload['data']['payment_status']) || $payload['data']['payment_status'] !== 'paid') {
            return response()->json(['status' => 'ignored']);
        }

        $metadata = $payload['data']['metadata'] ?? [];
        $paymentType = $metadata['payment_type'] ?? null;
        $invoiceNumber = $metadata['invoice_id'] ?? null;

        // 3. Idempotency Check
        if ($invoiceNumber) {
            $invoice = Invoice::where('invoice_number', $invoiceNumber)->first();
            if ($invoice && $invoice->status === 'paid') {
                return response()->json(['status' => 'success', 'message' => 'Already processed']);
            }
        }

        // 4. Prepare data for Queue
        $data = [
            'provisionalData_id' => $metadata['provisional_data_id'] ?? null,
            'invoice_number' => $invoiceNumber,
            // 'activity_id' is now retrieved from ProvisionalData inside the Job/Service
        ];

        // 5. Dispatch Job
        try {
            if ($paymentType) {
                ProcessPaymentJob::dispatch($paymentType, $data);
            } else {
                Log::warning('Payment type missing in webhook metadata');
            }
        } catch (\Throwable $e) {
            Log::error('Failed to dispatch payment job', ['error' => $e->getMessage()]);
            return response()->json(['status' => 'error'], 500);
        }

        return response()->json(['status' => 'success']);
    }

    private function verifyThawaniSignature(Request $request): bool
    {
        $signature = $request->header('thawani-signature');
        $timestamp = $request->header('thawani-timestamp');
        $secret = env('THAWANI_WEBHOOK_SECRET_KEY');

        if (!$signature || !$timestamp || !$secret) {
            return false;
        }

        $payload = $request->getContent();
        $stringToSign = $payload . '-' . $timestamp;

        // 1️⃣ تحقق من hex
        $computedHex = hash_hmac('sha256', $stringToSign, $secret);
        if (hash_equals($signature, $computedHex)) {
            return true;
        }

        // 2️⃣ إذا لم ينجح، تحقق من base64
        $computedBase64 = base64_encode(hash_hmac('sha256', $stringToSign, $secret, true));
        if (hash_equals($signature, $computedBase64)) {
            return true;
        }

        // لا شيء تطابق → فشل
        Log::warning('Invalid Thawani Signature', [
            'signature' => $signature,
            'computedHex' => $computedHex,
            'computedBase64' => $computedBase64,
        ]);

        return false;
    }
}
