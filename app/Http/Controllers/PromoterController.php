<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;
use App\Http\Requests\StorePromoterRequest;
use App\Http\Traits\ApiResponse;
use App\Models\Organization;
use App\Models\Promoter;
use App\Modules\User\Models\User;
use Exception;
use Illuminate\Http\Request;
use App\OpenApi\Responses\CreatedResponse;
use App\OpenApi\Responses\ErrorResponse;
use App\OpenApi\Responses\NoContentResponse;
use App\OpenApi\Responses\NotFoundResponse;
use App\OpenApi\Responses\OkResponse;
use App\OpenApi\Responses\PaginatedOkResponse;
use App\OpenApi\Responses\ServerErrorResponse;
use App\OpenApi\Responses\UnauthorizedResponse;
use App\OpenApi\Responses\UnprocessableResponse;


class PromoterController extends Controller
{

    use ApiResponse;


    #[OA\Get(
        path: '/promoters',
        summary: 'List user promoters (admin, paginated)',
        security: [['sanctum' => []]],
        tags: ['Promoters'],
        responses: [
            new PaginatedOkResponse('Promoter'),
            new NoContentResponse(),
            new UnauthorizedResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function index()
    {
        try {
            $promoters = Promoter::whereHas('promoter', function ($query) {
                $query->where('role', 'user');
            })->with('promoter:id,name,email,image,phone,role')->paginate(15);

            if ($promoters->total() === 0) {
                return $this->noContentResponse();
            }

            return $this->paginationResponse($promoters, 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }


    #[OA\Post(
        path: '/search-for-promoter',
        summary: 'Search promoters by name or referral data (admin)',
        security: [['sanctum' => []]],
        tags: ['Promoters'],
requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['query'],
                properties: [
                    new OA\Property(property: 'query', type: 'string'),
                ],
            ),
        ),
        responses: [
            new PaginatedOkResponse('Promoter'),
            new NoContentResponse(),
            new UnprocessableResponse(),
            new UnauthorizedResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function searchForPromoters(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'query' => 'required|string|max:255'
            ]);
            $query = $validatedData['query'];

            $promoters = Promoter::with('promoter:id,name,email,image,phone')
                ->searchInPromoterData($query)
                ->paginate(15);

            if ($promoters->total() === 0) {
                return $this->noContentResponse();
            }

            return $this->paginationResponse($promoters, 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }



    #[OA\Post(
        path: '/add-promoter',
        summary: 'Create a promoter profile for a user or organization (admin)',
        security: [['sanctum' => []]],
        tags: ['Promoters'],
requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['promoter_type', 'promoter_id', 'referral_code', 'discount_percentage', 'status'],
                properties: [
                    new OA\Property(property: 'promoter_type', type: 'string', enum: ['user', 'organization']),
                    new OA\Property(property: 'promoter_id', type: 'integer'),
                    new OA\Property(property: 'referral_code', type: 'string'),
                    new OA\Property(property: 'discount_percentage', type: 'number'),
                    new OA\Property(property: 'status', type: 'string', enum: ['active', 'disabled']),
                ],
            ),
        ),
        responses: [
            new CreatedResponse('Promoter added successfully'),
            new ErrorResponse(409, 'This account already has a promoter profile'),
            new UnprocessableResponse(),
            new UnauthorizedResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function addPromoter(StorePromoterRequest $request)
    {
        try {
            $data = $request->validated();

            $modelClass = $data['promoter_type'] === 'user'
                ? User::class
                : Organization::class;

            $promotable = $modelClass::findOrFail($data['promoter_id']);

            // Prevent duplicate
            if ($promotable->promoter) {
                return response()->json([
                    'message' => 'This account already has a promoter profile.'
                ], 409);
            }

            $promoter = $promotable->promoter()->create([
                'referral_code' => $data['referral_code'],
                'discount_percentage' => $data['discount_percentage'],
                'status' => $data['status'],
            ]);

            $data = [
                'message' => 'Promoter added successfully.',
                'data' => $promoter,
            ];

            return $this->successResponse($data, 201);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }


    #[OA\Get(
        path: '/get-promoter/{id}',
        summary: 'Get promoter info (optionally with paginated activities)',
        security: [['sanctum' => []]],
        tags: ['Promoters'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
            new OA\Parameter(name: 'type', in: 'query', required: true, schema: new OA\Schema(type: 'string', enum: ['user', 'organization']), description: 'Promoter account type'),
            new OA\Parameter(name: 'activities', in: 'query', required: false, schema: new OA\Schema(type: 'boolean'), description: 'Include paginated activities'),
        ],
        responses: [
            new OkResponse('Promoter info'),
            new NotFoundResponse(),
            new UnprocessableResponse(),
            new UnauthorizedResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function getPromoter($id, Request $request)
    {
        try {
            $request->validate([
                'activities' => 'nullable|boolean',
                'type' => 'required|in:user,organization'
            ]);

            // ===============================
            // Case 1: Get promoter basic info
            // ===============================
            $promoter = Promoter::with('promoter:id,name,email,image,phone')
                ->where('promoter_id', $id)
                ->where('promoter_type', $request->type)
                ->firstOrFail();

            // ======================================================
            // Case 2: Get paginated activities (data + last_page only)
            // ======================================================
            if ($request->activities) {
                $paginate = $promoter->activities()->paginate(10);

                $activities = [
                    'data' => $paginate->items(),
                    'last_page' => $paginate->lastPage(),
                    'total' => $paginate->total(),
                    'per_page' => $paginate->perPage(),
                ];

                return $this->successResponse([
                    'promoter' => $promoter,
                    'activities' => $activities
                ], 200);
            }

            return $this->successResponse([
                'promoter' => $promoter
            ], 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }



    /**
     * Disable a promoter without deleting it.
     */
    #[OA\Post(
        path: '/update-promoter/{promoter}',
        summary: 'Update a promoter profile (admin)',
        security: [['sanctum' => []]],
        tags: ['Promoters'],
        parameters: [
            new OA\Parameter(name: 'promoter', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                                properties: [
                    new OA\Property(property: 'status', type: 'string', enum: ['active', 'disabled']),
                    new OA\Property(property: 'discount_percentage', type: 'number'),
                    new OA\Property(property: 'referral_code', type: 'string'),
                ],
            ),
        ),
        responses: [
            new OkResponse('Promoter updated'),
            new UnprocessableResponse(),
            new UnauthorizedResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function updatePromoter(Promoter $promoter, Request $request)
    {
        try {

            $validatedData = $request->validate([
                'status' => 'sometimes|in:active,disabled',
                'discount_percentage' => 'sometimes|numeric',
                'referral_code' => 'sometimes|string',
            ]);

            $promoter->update($validatedData);

            return $this->successResponse([
                'message' => 'Promoter disabled successfully.',
                'data' => $promoter,
            ], 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Permanently delete a promoter.
     */
    #[OA\Delete(
        path: '/delete-promoter/{id}',
        summary: 'Delete a promoter (admin)',
        security: [['sanctum' => []]],
        tags: ['Promoters'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OkResponse('Promoter deleted successfully'),
            new NotFoundResponse(),
            new UnauthorizedResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function deletePromoter($id)
    {
        try {
            $promoter = Promoter::find($id);

            if (! $promoter) {
                return $this->errorResponse('Promoter not found.', 404);
            }

            $promoter->delete();

            return $this->successResponse('Promoter deleted successfully.', 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }


    #[OA\Post(
        path: '/check-promoter-code',
        summary: 'Validate a promoter referral code',
        security: [['sanctum' => []]],
        tags: ['Promoters'],
requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['ref_code'],
                properties: [
                    new OA\Property(property: 'ref_code', type: 'string'),
                ],
            ),
        ),
        responses: [
            new OkResponse('Promoter data'),
            new NotFoundResponse(),
            new ErrorResponse(403, 'Promoter is disabled'),
            new UnprocessableResponse(),
            new UnauthorizedResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function checkPromoterCode(Request $request)
    {
        try {
            $request->validate([
                'ref_code' => 'required|exists:promoters,referral_code'
            ]);

            $promoter = Promoter::where('referral_code', $request->ref_code)->first();

            if (!$promoter) {
                return $this->errorResponse('Promoter not found.', 404);
            }

            if ($promoter->status == 'disabled') {
                return $this->errorResponse('Promoter is disabled.', 403);
            }

            return $this->successResponse($promoter, 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
