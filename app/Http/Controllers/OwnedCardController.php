<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;
use App\Http\Traits\ApiResponse;
use App\Modules\Organization\Models\Organization;
use App\Models\OwnedCard;
use App\Modules\User\Models\User;
use Exception;
use Illuminate\Http\Request;
use App\OpenApi\Responses\NoContentResponse;
use App\OpenApi\Responses\NotFoundResponse;
use App\OpenApi\Responses\OkResponse;
use App\OpenApi\Responses\ServerErrorResponse;
use App\OpenApi\Responses\UnauthorizedResponse;
use App\OpenApi\Responses\UnprocessableResponse;

class OwnedCardController extends Controller
{
    use ApiResponse;

    #[OA\Get(
        path: '/cards-account',
        summary: 'Get owned cards for a user or organization (paginated)',
        security: [['sanctum' => []]],
        tags: ['Cards'],
        parameters: [
            new OA\Parameter(name: 'owner_id', in: 'query', required: true, schema: new OA\Schema(type: 'integer'), description: 'Owner account id'),
            new OA\Parameter(name: 'owner_type', in: 'query', required: true, schema: new OA\Schema(type: 'string', enum: ['user', 'organization']), description: 'Owner account type'),
        ],
        responses: [
            new OkResponse('Owned cards with owner info'),
            new NoContentResponse(),
            new NotFoundResponse(),
            new UnprocessableResponse(),
            new UnauthorizedResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function getAccountCards(Request $request)
    {
        try {
            $request->validate([
                'owner_id' => 'required|integer',
                'owner_type' => 'required|in:user,organization',
            ]);

            // ✅ Load owner info properly
            $owner = $request->owner_type === 'user'
                ? User::select('id', 'name', 'image', 'email')->find($request->owner_id)
                : Organization::select('id', 'title', 'logo', 'email')->find($request->owner_id);

            if (! $owner) {
                return $this->errorResponse('Owner not found', 404);
            }

            // ✅ Load cards with pagination
            $cards = OwnedCard::where('owner_id', $request->owner_id)
                ->where('owner_type', $request->owner_type)->with('card:id,title,image')
                ->paginate(12);

            if ($cards->total() === 0) {
                return $this->noContentResponse();
            }

            $data = [
                'cards' => $cards->items(),
                'owner' => $owner
            ];

            // ✅ Include owner in the response payload
            return response()->json([
                'data' => $data,
                'pagination' => [
                    'current_page' => $cards->currentPage(),
                    'per_page' => $cards->perPage(),
                    'total' => $cards->total(),
                    'last_page' => $cards->lastPage(),
                ],
            ], 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
