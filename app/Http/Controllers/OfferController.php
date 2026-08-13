<?php

namespace App\Http\Controllers;

use App\Helpers\TextNormalizer;
use App\Http\Requests\StoreOfferRequest;
use App\Http\Requests\UpdateOfferRequest;
use App\Http\Services\ImageService;
use App\Http\Traits\ApiResponse;
use App\Models\Offer;
use Illuminate\Http\Request;

use App\OpenApi\Responses\CreatedResponse;
use App\OpenApi\Responses\EntityOkResponse;
use App\OpenApi\Responses\ForbiddenResponse;
use App\OpenApi\Responses\NotFoundResponse;
use App\OpenApi\Responses\OkResponse;
use App\OpenApi\Responses\PaginatedOkResponse;
use App\OpenApi\Responses\ServerErrorResponse;
use App\OpenApi\Responses\UnauthorizedResponse;
use App\OpenApi\Responses\UnprocessableResponse;
use OpenApi\Attributes as OA;

class OfferController extends Controller
{

    use ApiResponse;

    protected $imageservice;

    public function __construct(ImageService $imageService)
    {
        $this->imageservice = $imageService;
    }


    /**
     * Display a listing of the resource.
     */
    #[OA\Get(
        path: '/dashboard/offers',
        summary: 'List all offers (admin, paginated, filterable)',
        security: [['sanctum' => []]],
        tags: ['Offers'],
        parameters: [
            new OA\Parameter(name: 'query', in: 'query', required: false, schema: new OA\Schema(type: 'string'), description: 'Search in title/description'),
            new OA\Parameter(name: 'status', in: 'query', required: false, schema: new OA\Schema(type: 'string', enum: ['waiting', 'active', 'expired'])),
            new OA\Parameter(name: 'category_id', in: 'query', required: false, schema: new OA\Schema(type: 'string'), description: 'Comma separated category ids'),
            new OA\Parameter(name: 'discount_type', in: 'query', required: false, schema: new OA\Schema(type: 'string', enum: ['percentage', 'fixed'])),
            new OA\Parameter(name: 'start_date', in: 'query', required: false, schema: new OA\Schema(type: 'string', format: 'date')),
            new OA\Parameter(name: 'end_date', in: 'query', required: false, schema: new OA\Schema(type: 'string', format: 'date')),
            new OA\Parameter(name: 'per_page', in: 'query', required: false, schema: new OA\Schema(type: 'integer'), example: 12),
        ],
        responses: [
            new PaginatedOkResponse('Offer'),
            new UnauthorizedResponse(),
            new ForbiddenResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function index(Request $request)
    {
        try {
            $query = $request->get('query', '');

            // ✅ Normalize the input query
            $normalizedQuery = TextNormalizer::normalizeArabic($query);

            // ✅ SQL normalization expressions for columns
            $normalizedTitle = "LOWER(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(title, 'ة', 'ه'), 'ى', 'ي'), 'أ', 'ا'), 'إ', 'ا'), 'آ', 'ا'), 'ؤ', 'و'))";
            $normalizedDescription = "LOWER(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(description, 'ة', 'ه'), 'ى', 'ي'), 'أ', 'ا'), 'إ', 'ا'), 'آ', 'ا'), 'ؤ', 'و'))";

            // ✅ Start building the query
            $builder = Offer::with(['organization:id,title,description,image,rating', 'category', 'categories'])
                ->when($query, function ($q) use ($normalizedQuery, $normalizedTitle, $normalizedDescription) {
                    $q->where(function ($subQ) use ($normalizedQuery, $normalizedTitle, $normalizedDescription) {
                        $subQ->whereRaw("$normalizedTitle LIKE ?", ["%$normalizedQuery%"])
                            ->orWhereRaw("$normalizedDescription LIKE ?", ["%$normalizedQuery%"]);
                    });
                })
                ->when($request->filled('status'), function ($q) use ($request) {
                    $q->where('status', $request->status);
                })
                ->when($request->filled('category_id'), function ($q) use ($request) {
                    $q->filterByCategories($request->category_id);
                })
                ->when($request->filled('discount_type'), function ($q) use ($request) {
                    $q->where('discount_type',   $request->discount_type);
                })
                ->when($request->filled('start_date') || $request->filled('end_date'), function ($q) use ($request) {
                    $dateFrom = $request->get('start_date');
                    $dateTo   = $request->get('end_date');

                    // لو الاتنين موجودين
                    if ($dateFrom && $dateTo) {
                        $q->where(function ($subQ) use ($dateFrom, $dateTo) {
                            $subQ->whereBetween('start_date', [$dateFrom, $dateTo])
                                ->orWhereBetween('end_date', [$dateFrom, $dateTo]);
                        });
                    }
                    // لو بس dateFrom موجود
                    elseif ($dateFrom) {
                        $q->where(function ($subQ) use ($dateFrom) {
                            $subQ->where('start_date', '>=', $dateFrom)
                                ->orWhere('end_date', '>=', $dateFrom);
                        });
                    }
                    // لو بس dateTo موجود
                    elseif ($dateTo) {
                        $q->where(function ($subQ) use ($dateTo) {
                            $subQ->where('start_date', '<=', $dateTo)
                                ->orWhere('end_date', '<=', $dateTo);
                        });
                    }
                });


            // ✅ Apply pagination
            $perPage = $request->get('per_page', 12); // default = 10
            $offers = $builder->paginate($perPage);

            return $this->paginationResponse($offers, 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }


    #[OA\Get(
        path: '/active-offers',
        summary: 'List active offers (paginated, filterable, sortable)',
        tags: ['Offers'],
        parameters: [
            new OA\Parameter(name: 'query', in: 'query', required: false, schema: new OA\Schema(type: 'string'), description: 'Search in title/description'),
            new OA\Parameter(name: 'sort_by', in: 'query', required: false, schema: new OA\Schema(type: 'string', enum: ['newest', 'popular', 'expiring', 'discount']), example: 'newest'),
            new OA\Parameter(name: 'category', in: 'query', required: false, schema: new OA\Schema(type: 'string'), description: 'Comma separated category ids'),
            new OA\Parameter(name: 'per_page', in: 'query', required: false, schema: new OA\Schema(type: 'integer'), example: 10),
        ],
        responses: [
            new PaginatedOkResponse('Offer'),
            new ServerErrorResponse(),
        ],
    )]
    public function activeOffers(Request $request)
    {
        try {
            $query = $request->get('query', '');
            $sortBy = $request->get('sort_by', 'newest'); // Default to newest

            // ✅ Normalize the input query
            $normalizedQuery = TextNormalizer::normalizeArabic($query);

            // ✅ SQL normalization expressions for columns
            $normalizedTitle = "LOWER(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(title, 'ة', 'ه'), 'ى', 'ي'), 'أ', 'ا'), 'إ', 'ا'), 'آ', 'ا'), 'ؤ', 'و'))";
            $normalizedDescription = "LOWER(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(description, 'ة', 'ه'), 'ى', 'ي'), 'أ', 'ا'), 'إ', 'ا'), 'آ', 'ا'), 'ؤ', 'و'))";

            // ✅ Start building the query
            $builder = Offer::with(['organization:id,title,description,image,rating', 'category:id,title_en,title_ar,bg_color,icon_name', 'categories'])
                ->where('status', 'active') // ✅ تثبيت الحالة على active فقط
                ->when($query, function ($q) use ($normalizedQuery, $normalizedTitle, $normalizedDescription) {
                    $q->where(function ($subQ) use ($normalizedQuery, $normalizedTitle, $normalizedDescription) {
                        $subQ->whereRaw("$normalizedTitle LIKE ?", ["%$normalizedQuery%"])
                            ->orWhereRaw("$normalizedDescription LIKE ?", ["%$normalizedQuery%"]);
                    });
                })
                ->when($request->filled('category'), function ($q) use ($request) {
                    $q->filterByCategories($request->category);
                });

            // ✅ Apply sorting based on sort_by parameter
            switch ($sortBy) {
                case 'newest':
                    $builder->orderBy('created_at', 'desc');
                    break;

                case 'popular':
                    // Assuming you have a 'popularity' column or using number_of_uses
                    $builder->orderBy('number_of_uses', 'desc');
                    break;

                case 'expiring':
                    // Order by closest end_date (soonest to expire first)
                    $builder->orderBy('end_date', 'asc');
                    break;



                // Alternative discount sorting logic for mixed discount types
                case 'discount':
                    // For mixed discount types, we need to handle them differently
                    $builder->orderByRaw("
        CASE
            WHEN discount_type = 'percentage' THEN CAST(discount_value AS DECIMAL(10,2))
            WHEN discount_type = 'fixed' THEN CAST(discount_value AS DECIMAL(10,2)) / 10
            ELSE 0
        END DESC
    ");
                    break;

                default:
                    $builder->orderBy('created_at', 'desc');
                    break;
            }

            // ✅ Pagination
            $offers = $builder->paginate($request->get('per_page', 10));

            return $this->paginationResponse($offers, 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }


    #[OA\Get(
        path: '/active-offers/{orgId}',
        summary: 'List active offers of a single organization',
        tags: ['Offers'],
        parameters: [
            new OA\Parameter(name: 'orgId', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
            new OA\Parameter(name: 'limit', in: 'query', required: false, schema: new OA\Schema(type: 'integer'), example: 10),
            new OA\Parameter(name: 'page', in: 'query', required: false, schema: new OA\Schema(type: 'integer'), example: 1),
        ],
        responses: [
            new PaginatedOkResponse('Offer'),
            new ServerErrorResponse(),
        ],
    )]
    public function activeOffersByOrganization(Request $request, $id)
    {
        try {
            // Get pagination limit (default 10 if not provided)
            $limit = $request->input('limit', 10);

            // Get active offers for the organization
            $offers = Offer::where('organization_id', $id)
                ->where('status', 'active')
                ->whereDate('end_date', '>=', now()) // ✅ Check that offer is still active (not expired)
                ->with(['organization:id,title,description,image,rating', 'category:id,title_en,title_ar,bg_color,icon_name', 'categories'])
                ->orderByRaw("
                CASE
                    WHEN discount_type = 'percentage' THEN CAST(discount_value AS DECIMAL(10,2))
                    WHEN discount_type = 'fixed' THEN CAST(discount_value AS DECIMAL(10,2)) / 10
                    ELSE 0
                END DESC
            ") // ✅ Sort by discount logic
                ->paginate($limit);

            // If no offers found
            if ($offers->total() === 0) {
                return $this->noContentResponse();
            }

            if ($request->has('limit') && !$request->has('page')) {
                return $this->successResponse($offers->items(), 200);
            }

            // Return paginated data
            return $this->paginationResponse($offers, 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }



    #[OA\Get(
        path: '/account-offers',
        summary: 'List offers of the current organization account (paginated)',
        security: [['sanctum' => []]],
        tags: ['Offers'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'query', required: true, schema: new OA\Schema(type: 'integer'), description: 'Organization id'),
        ],
        responses: [
            new PaginatedOkResponse('Offer'),
            new UnprocessableResponse(),
            new UnauthorizedResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function accountOffers(Request $request)
    {
        try {
            $request->validate([
                'id'   => 'required|exists:organizations,id',
            ]);


            $offers = Offer::with(['category', 'categories', 'organization:id,title,description,image,rating'])
                ->where('organization_id', $request->id)
                ->orderByDesc('created_at')
                ->paginate(12);

            if ($offers->total() === 0) {
                return $this->noContentResponse();
            }

            return $this->paginationResponse($offers, 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    #[OA\Post(
        path: '/add-offer',
        summary: 'Create a new offer (protected)',
        security: [['sanctum' => []]],
        tags: ['Offers'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\MediaType(
                mediaType: 'multipart/form-data',
                schema: new OA\Schema(ref: '#/components/schemas/OfferStoreRequest'),
            ),
        ),
        responses: [
            new CreatedResponse('Offer created'),
            new UnprocessableResponse(),
            new UnauthorizedResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function store(StoreOfferRequest $request)
    {
        try {

            $data = $request->validated();

            $offer = Offer::create($data);

            // التعامل مع الصورة الرئيسية
            if ($request->hasFile('image')) {
                $this->imageservice->ImageUploaderwithvariable($request, $offer, 'images/offers', 'image');
            }

            if ($request->has('categories')) {
                $offer->categories()->sync($request->categories);
            }

            return $this->successResponse($offer->load('categories'), 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    #[OA\Get(
        path: '/get-offer/{id}',
        summary: 'Show a single offer with relations',
        security: [['sanctum' => []]],
        tags: ['Offers'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new EntityOkResponse('Offer'),
            new UnauthorizedResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function show($id)
    {
        try {
            $offer = Offer::with([
                'category',
                'categories:id',
                'organization:id,title,description,image,rating'
            ])->findOrFail($id);

            $offer->setRelation(
                'categories',
                $offer->categories->pluck('id')->values()
            );

            return $this->successResponse($offer, 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }



    /**
     * Update the specified resource in storage.
     */
    #[OA\Post(
        path: '/dashboard/update-offer/{id}',
        summary: 'Update an existing offer (admin)',
        security: [['sanctum' => []]],
        tags: ['Offers'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\MediaType(
                mediaType: 'multipart/form-data',
                schema: new OA\Schema(ref: '#/components/schemas/OfferStoreRequest'),
            ),
        ),
        responses: [
            new EntityOkResponse('Offer'),
            new UnprocessableResponse(),
            new UnauthorizedResponse(),
            new ForbiddenResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function update(UpdateOfferRequest $request, $id)
    {
        try {
            $offer = Offer::with(['category', 'categories', 'organization:id,title,description,image,rating'])->findOrFail($id);
            $data = $request->validated();

            $offer->update($data);

            // التعامل مع الصورة الرئيسية
            if ($request->hasFile('image')) {
                $this->imageservice->ImageUploaderwithvariable($request, $offer, 'images/offers', 'image');
            }

            if ($request->has('categories')) {
                $offer->categories()->sync($request->categories);
            }

            return $this->successResponse($offer->load('categories'), 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }


    #[OA\Post(
        path: '/dashboard/update-status-offer/{id}',
        summary: 'Update offer status (admin)',
        security: [['sanctum' => []]],
        tags: ['Offers'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['status'],
                properties: [
                    new OA\Property(property: 'status', type: 'string', enum: ['waiting', 'active', 'expired']),
                ],
            ),
        ),
        responses: [
            new OkResponse('Offer status updated successfully'),
            new NotFoundResponse('Offer not found'),
            new UnprocessableResponse(),
            new UnauthorizedResponse(),
            new ForbiddenResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function updateStatus(Request $request, $id)
    {
        try {
            // Validate that 'status' is present and is a valid string
            $validated = $request->validate([
                'status' => ['required', 'string', 'in:waiting,active,expired'],
            ]);

            // Retrieve the service by ID or fail
            $service = Offer::findOrFail($id);

            // Update only the status
            $service->update([
                'status' => $validated['status'],
            ]);

            // Return the updated service
            return $this->successResponse($service, 200, 'Offer status updated successfully.');
        } catch (\Illuminate\Validation\ValidationException $ve) {
            return $this->errorResponse($ve->errors(), 422);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    #[OA\Delete(
        path: '/dashboard/delete-offer/{id}',
        summary: 'Delete an offer (admin)',
        security: [['sanctum' => []]],
        tags: ['Offers'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OkResponse('Offer deleted'),
            new NotFoundResponse('Offer not found'),
            new UnauthorizedResponse(),
            new ForbiddenResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function destroy($id)
    {
        try {
            $offer = Offer::findOrFail($id);

            if (!empty($offer->image)) {
                $this->imageservice->deleteOldImage($offer, 'images/offers');
            }

            $offer->delete();
            return $this->successResponse([], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->errorResponse('Offer not found', 404);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
