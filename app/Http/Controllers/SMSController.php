<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;


use App\OpenApi\Responses\OkResponse;
use App\OpenApi\Responses\UnprocessableResponse;
use App\OpenApi\Responses\ServerErrorResponse;

use OpenApi\Attributes as OA;

class SMSController extends Controller
{


    #[OA\Post(
        path: '/internal/send-sms',
        summary: 'Send an SMS message via the gateway (internal, API key)',
        tags: ['SMS'],
        security: [['api_key' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['message', 'numbers'],
                properties: [
                    new OA\Property(property: 'message', type: 'string', maxLength: 918),
                    new OA\Property(property: 'numbers', type: 'array', items: new OA\Items(type: 'string')),
                    new OA\Property(property: 'lang', type: 'string', enum: ['0', '64'], description: '0 = English, 64 = Arabic'),
                    new OA\Property(property: 'schedule', type: 'string', example: 'm/d/Y H:i:s'),
                    new OA\Property(property: 'referenceIds', type: 'string'),
                ],
            ),
        ),
        responses: [
            new OkResponse('SMS sent'),
            new UnprocessableResponse(),
            new ServerErrorResponse(),
        ],
    )]
    #[OA\Post(
        path: '/send-sms',
        summary: 'Send an SMS message via the gateway',
        tags: ['SMS'],
        security: [['sanctum' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['message', 'numbers'],
                properties: [
                    new OA\Property(property: 'message', type: 'string', maxLength: 918),
                    new OA\Property(property: 'numbers', type: 'array', items: new OA\Items(type: 'string')),
                    new OA\Property(property: 'lang', type: 'string', enum: ['0', '64'], description: '0 = English, 64 = Arabic'),
                    new OA\Property(property: 'schedule', type: 'string', example: 'm/d/Y H:i:s'),
                    new OA\Property(property: 'referenceIds', type: 'string'),
                ],
            ),
        ),
        responses: [
            new OkResponse('SMS sent'),
            new UnprocessableResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function send(Request $request)
    {
        // ✅ Validate request
        $request->validate([
            'message' => 'required|string|max:918', // SMS max length
            'numbers' => 'required|array',
            'numbers.*' => 'string|regex:/^[0-9]+$/',
            'lang'    => 'nullable|in:0,64', // 0 = English, 64 = Arabic
            'schedule' => 'nullable|date_format:m/d/Y H:i:s',
            'referenceIds' => 'nullable|string'
        ]);

        // ✅ Prepare payload
        $payload = [
            'UserId'       => env('ISMARTSMS_USER'),
            'Password'     => env('ISMARTSMS_PASS'),
            'MobileNo'     => implode(',', $request->numbers), // multiple numbers allowed
            'Message'      => $request->message,
            'PushDateTime' => $request->schedule ?? '',
            'Lang'         => $request->lang ?? 0,
            'Header'       => env('ISMARTSMS_HEADER'),
            'referenceIds' => $request->referenceIds ?? ''
        ];

        try {
            // ✅ Send SMS request to API
            $response = Http::asForm()->timeout(10)->post(env('ISMARTSMS_URL'), $payload);

            return response()->json([
                'status'      => $response->successful() ? 'success' : 'failed',
                'return_code' => $response->body()
            ]);
        } catch (RequestException $e) {
            // ✅ Network/connection errors
            return response()->json([
                'status'  => 'error',
                'message' => 'Failed to connect to SMS gateway',
                'error'   => $e->getMessage()
            ], 500);
        } catch (\Exception $e) {
            // ✅ Any other errors
            return response()->json([
                'status'  => 'error',
                'message' => 'Unexpected error occurred',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
