<?php

namespace App\Http\Controllers;

use App\Http\Traits\ApiResponse;
use App\Modules\Organization\Models\Organization;
use App\Models\Transaction;
use App\Modules\User\Models\User;
use App\Models\WithdrawRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\OpenApi\Responses\EntityOkResponse;
use App\OpenApi\Responses\ForbiddenResponse;
use App\OpenApi\Responses\OkResponse;
use App\OpenApi\Responses\PaginatedOkResponse;
use App\OpenApi\Responses\ServerErrorResponse;
use App\OpenApi\Responses\UnauthorizedResponse;
use App\OpenApi\Responses\UnprocessableResponse;
use OpenApi\Attributes as OA;

class WithdrawRequestController extends Controller
{

    use ApiResponse;

    #[OA\Get(
        path: '/withdraw-requests',
        summary: 'List all withdraw requests (admin, paginated, filterable)',
        security: [['sanctum' => []]],
        tags: ['Wallet & Transactions'],
        parameters: [
            new OA\Parameter(name: 'status', in: 'query', required: false, schema: new OA\Schema(type: 'string', enum: ['pending', 'approved', 'rejected'])),
            new OA\Parameter(name: 'user_id', in: 'query', required: false, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new PaginatedOkResponse('WithdrawRequest'),
            new UnauthorizedResponse(),
            new ForbiddenResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function index(Request $request)
    {
        $query = WithdrawRequest::query()->with('user');

        // Optional filters
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $withdrawRequests = $query->latest()->paginate(20);

        return response()->json($withdrawRequests);
    }

    // ✅ Withdraw from available balance
    #[OA\Post(
        path: '/wallet/withdraw',
        summary: 'Request a withdrawal from the available balance',
        security: [['sanctum' => []]],
        tags: ['Wallet & Transactions'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['user_id', 'type', 'amount', 'bank_number', 'method'],
                properties: [
                    new OA\Property(property: 'user_id', type: 'integer', example: 1),
                    new OA\Property(property: 'type', type: 'string', enum: ['user', 'organization'], example: 'user'),
                    new OA\Property(property: 'amount', type: 'number', format: 'float', example: 100.0),
                    new OA\Property(property: 'bank_number', type: 'string', example: 'SA4420000000000000000000'),
                    new OA\Property(property: 'method', type: 'string', example: 'bank'),
                    new OA\Property(property: 'details', type: 'object', nullable: true, additionalProperties: true),
                ],
            ),
        ),
        responses: [
            new OkResponse('Withdrawal request submitted successfully'),
            new UnprocessableResponse('Insufficient balance or missing fields'),
            new UnauthorizedResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function withdraw(Request $request)
    {
        try {
            $request->validate([
                'user_id' => 'required|integer',
                'type' => 'required|in:user,organization',
                'amount'  => 'required|numeric|min:1',
                'bank_number'  => 'required|',
                'method'  => 'required|string', // e.g., bank, paypal, etc.
                'details' => 'nullable',
            ]);

            $user = $request->type == 'user' ?  User::findOrFail($request->user_id) : Organization::findOrFail($request->user_id);


            $wallet = $user->wallet;

            if (!$wallet || $wallet->available_balance < $request->amount) {
                return response()->json(['message' => 'Insufficient balance'], 422);
            }

            $data = [];
            DB::transaction(function () use ($wallet, $request, $user, &$data) {
                // Deduct from available balance
                $wallet->decrement('available_balance', $request->amount);

                // Create withdraw request first
                $withdrawRequest = WithdrawRequest::create([
                    'user_id' => $user->id,
                    'account_type' => $user->account_type,
                    'amount'  => $request->amount,
                    'bank_number' => $request->bank_number,
                    'status'  => 'pending',
                    'meta'    => [
                        'method'  => $request->method,
                        'details' => $request->details ?? [],
                    ],
                ]);

                // Then create transaction linked to the withdraw request
                $transaction =   Transaction::create([
                    'user_id'     => $user->id,
                    'account_type'     => $user->account_type,
                    'type'        => 'withdrawal',
                    'direction'   => 'out',
                    'amount'      => $request->amount,
                    'status'      => 'pending',
                    'note'        => 'Withdrawal request',
                    'source_type' => 'withdraw_requests',
                    'source_id'   => $withdrawRequest->id,
                    'created_at' => now()
                ]);

                $data = [
                    'transaction' =>  $transaction,
                    'withdrawRequest' => $withdrawRequest
                ];
            });

            return $this->successResponse($data, 200, 'Withdrawal request submitted successfully.');
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }



    #[OA\Get(
        path: '/withdraw-requests/{id}',
        summary: 'Show a single withdraw request (admin)',
        security: [['sanctum' => []]],
        tags: ['Wallet & Transactions'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new EntityOkResponse('WithdrawRequest'),
            new UnauthorizedResponse(),
            new ForbiddenResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function show($id)
    {
        $withdrawRequest = WithdrawRequest::with('user')->findOrFail($id);

        return response()->json($withdrawRequest);
    }


    #[OA\Post(
        path: '/admin/withdraw-requests/{id}/approve',
        summary: 'Approve a pending withdraw request (admin)',
        security: [['sanctum' => []]],
        tags: ['Wallet & Transactions'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OkResponse('Withdrawal request approved successfully'),
            new UnprocessableResponse('Request already processed'),
            new UnauthorizedResponse(),
            new ForbiddenResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function approve($id)
    {
        $withdraw = WithdrawRequest::findOrFail($id);

        if ($withdraw->status !== 'pending') {
            return response()->json(['message' => 'This request has already been processed.'], 422);
        }

        DB::transaction(function () use ($withdraw) {
            $withdraw->update(['status' => 'approved']);

            $transaction = Transaction::where('source_type', 'withdraw_requests')
                ->where('source_id', $withdraw->id)
                ->first();

            if ($transaction) {
                $transaction->update(['status' => 'completed']);
            }
        });

        return response()->json(['message' => 'Withdrawal request approved successfully.']);
    }


    #[OA\Post(
        path: '/admin/withdraw-requests/{id}/reject',
        summary: 'Reject a pending withdraw request and refund the amount (admin)',
        security: [['sanctum' => []]],
        tags: ['Wallet & Transactions'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        requestBody: new OA\RequestBody(
            required: false,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'note', type: 'string', example: 'Invalid bank details'),
                ],
            ),
        ),
        responses: [
            new OkResponse('Withdrawal request rejected and amount returned'),
            new UnprocessableResponse('Request already processed'),
            new UnauthorizedResponse(),
            new ForbiddenResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function reject(Request $request, $id)
    {
        $withdraw = WithdrawRequest::findOrFail($id);

        if ($withdraw->status !== 'pending') {
            return response()->json(['message' => 'This request has already been processed.'], 422);
        }

        DB::transaction(function () use ($withdraw, $request) {
            $withdraw->update([
                'status' => 'rejected',
                'note'   => $request->note,
            ]);

            // Return money to wallet
            $wallet = $withdraw->user->wallet;
            $wallet->increment('available_balance', $withdraw->amount);

            // Update related transaction
            $transaction = Transaction::where('source_type', 'withdraw_requests')
                ->where('source_id', $withdraw->id)
                ->first();

            if ($transaction) {
                $transaction->update(['status' => 'failed']);
            }
        });

        return response()->json(['message' => 'Withdrawal request rejected and amount returned.']);
    }
}
