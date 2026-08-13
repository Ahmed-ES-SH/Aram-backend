<?php

namespace App\Http\Controllers;

use App\Http\Traits\ApiResponse;
use App\Models\Transaction;
use Illuminate\Http\Request;

use App\OpenApi\Responses\PaginatedOkResponse;
use App\OpenApi\Responses\ServerErrorResponse;
use App\OpenApi\Responses\UnauthorizedResponse;
use App\OpenApi\Responses\UnprocessableResponse;
use OpenApi\Attributes as OA;

class TransactionController extends Controller
{
    use ApiResponse;

    #[OA\Get(
        path: '/user-transactions',
        summary: 'List transactions of a user or organization (paginated)',
        security: [['sanctum' => []]],
        tags: ['Wallet & Transactions'],
        parameters: [
            new OA\Parameter(name: 'user_id', in: 'query', required: true, schema: new OA\Schema(type: 'integer')),
            new OA\Parameter(name: 'type', in: 'query', required: true, schema: new OA\Schema(type: 'string', enum: ['user', 'organization'])),
        ],
        responses: [
            new PaginatedOkResponse('Transaction'),
            new UnprocessableResponse(),
            new UnauthorizedResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function getUserTransactions(Request $request)
    {
        try {
            $request->validate([
                'user_id' => 'required',
                'type' => 'required|in:user,organization'
            ]);

            $transactions = Transaction::where('user_id', $request->user_id)
                ->where('account_type', $request->type)
                ->orderBy('created_at', 'desc')
                ->paginate(15);


            if ($transactions->total() === 0) {
                return $this->noContentResponse();
            }

            return $this->paginationResponse($transactions);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
