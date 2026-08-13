<?php

namespace App\Http\Controllers;

use App\Helpers\TextNormalizer;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Services\ImageService;
use App\Http\Traits\ApiResponse;
use App\Models\ServiceCategory;
use App\OpenApi\Responses\CreatedResponse;
use App\OpenApi\Responses\EntityOkResponse;
use App\OpenApi\Responses\ErrorResponse;
use App\OpenApi\Responses\ForbiddenResponse;
use App\OpenApi\Responses\ListOkResponse;
use App\OpenApi\Responses\NotFoundResponse;
use App\OpenApi\Responses\OkResponse;
use App\OpenApi\Responses\PaginatedOkResponse;
use App\OpenApi\Responses\RefOkResponse;
use App\OpenApi\Responses\ServerErrorResponse;
use App\OpenApi\Responses\UnauthorizedResponse;
use App\OpenApi\Responses\UnprocessableResponse;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class ServiceCategoryController extends Controller
{
    use ApiResponse;
    protected $imageservice;

    public function __construct(ImageService $imageService)
    {
        $this->imageservice = $imageService;
    }

    #[OA\Get(
        path: '/service-categories',
        summary: 'List all service categories (paginated)',
        tags: ['Service Categories'],
        responses: [
            new PaginatedOkResponse('ServiceCategory'),
            new NotFoundResponse('No service categories found'),
            new ServerErrorResponse( 'Server error'),
        ],
    )]
    public function index()
    {
        try {
            $Categories = ServiceCategory::orderBy('created_at', 'desc')->paginate(30);
            if ($Categories->total() === 0) {
                return $this->noContentResponse();
            }
            return $this->paginationResponse($Categories, 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }




    public function activeCategories(Request $request)
    {
        try {

            $state = $request->state;

            $Categories = ServiceCategory::orderBy('created_at', 'desc')
                ->where('is_active', $state)
                ->paginate(30);

            if ($Categories->total() === 0) {
                return $this->noContentResponse();
            }
            return $this->paginationResponse($Categories, 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }





    #[OA\Post(
        path: '/service-categories/search',
        summary: 'Search service categories by title (admin)',
        security: [['sanctum' => []]],
        tags: ['Service Categories'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['query'],
                properties: [
                    new OA\Property(property: 'query', type: 'string', example: 'خدمة'),
                ],
            ),
        ),
        responses: [
            new PaginatedOkResponse('ServiceCategory'),
            new UnprocessableResponse('Search query is required'),
            new UnauthorizedResponse(), new ForbiddenResponse(), new ServerErrorResponse(),
        ],
    )]
    public function search(Request $request)
    {
        try {
            $query = $request->input('query');

            if (!$query) {
                return $this->errorResponse([
                    'message' => 'يرجى إدخال كلمة البحث.',
                ], 422);
            }

            // ✅ Normalize Arabic letters
            $normalizedQuery = TextNormalizer::normalizeArabic($query);

            // ✅ SQL replace chain to normalize Arabic columns
            $normalizedSql = TextNormalizer::sqlNormalizeColumn('title_ar');
            // ✅ Execute manual query without Scout
            $results = ServiceCategory::where(function ($q) use ($normalizedQuery, $normalizedSql) {
                $q->whereRaw("$normalizedSql LIKE ?", ["%$normalizedQuery%"])
                    ->orWhere('title_en', 'LIKE', "%$normalizedQuery%");
            })->paginate(30);

            return $this->paginationResponse($results, 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }


    #[OA\Get(
        path: '/public-service-categories',
        summary: 'List public service categories (limit 12)',
        tags: ['Service Categories'],
        responses: [
            new ListOkResponse('ServiceCategory'),
            new NotFoundResponse('No service categories found'),
            new ServerErrorResponse( 'Server error'),
        ],
    )]
    public function publicCategories()
    {
        try {
            $Categories = ServiceCategory::orderBy('created_at', 'desc')->where('is_active', true)->limit(12)->get();
            if ($Categories->isEmpty()) {
                return $this->noContentResponse();
            }
            return $this->successResponse($Categories, 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }



    #[OA\Get(
        path: '/all-service-categories',
        summary: 'List all service categories',
        tags: ['Service Categories'],
        responses: [
            new ListOkResponse('ServiceCategory'),
            new NotFoundResponse('No service categories found'),
            new ServerErrorResponse( 'Server error'),
        ],
    )]
    public function AllCategories()
    {
        try {
            $Categories = ServiceCategory::orderBy('created_at', 'desc')->get();
            if ($Categories->isEmpty()) {
                return $this->noContentResponse();
            }
            return $this->successResponse($Categories, 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }


    #[OA\Get(
        path: '/all-service-public-categories',
        summary: 'List all service categories (public)',
        tags: ['Service Categories'],
        responses: [
            new ListOkResponse('ServiceCategory'),
            new NotFoundResponse('No service categories found'),
            new ServerErrorResponse( 'Server error'),
        ],
    )]
    public function AllPublicCategories()
    {
        try {
            $Categories = ServiceCategory::orderBy('created_at', 'desc')->get();
            if ($Categories->isEmpty()) {
                return $this->noContentResponse();
            }
            return $this->successResponse($Categories, 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    #[OA\Post(
        path: '/add-service-category',
        summary: 'Create a new service category (admin)',
        security: [['sanctum' => []]],
        tags: ['Service Categories'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\MediaType(
                mediaType: 'multipart/form-data',
                schema: new OA\Schema(ref: '#/components/schemas/CategoryStoreRequest'),
            ),
        ),
        responses: [
            new EntityOkResponse('ServiceCategory', 'Created'),
            new UnauthorizedResponse(), new ForbiddenResponse(), new ServerErrorResponse(),
        ],
    )]
    public function store(StoreCategoryRequest $request)
    {
        try {
            $data = $request->validated();
            $category = new ServiceCategory();
            $category->fill($data);
            if ($request->has('image')) {
                $this->imageservice->ImageUploaderwithvariable($request, $category, 'images/cardcategories', 'image');
            }
            return $this->successResponse($category, 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    #[OA\Get(
        path: '/service-category/{id}',
        summary: 'Show a single service category (admin)',
        security: [['sanctum' => []]],
        tags: ['Service Categories'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new EntityOkResponse('ServiceCategory'),
            new NotFoundResponse('Service category not found'),
            new UnauthorizedResponse(), new ForbiddenResponse(), new ServerErrorResponse(),
        ],
    )]
    public function show($id)
    {

        try {
            $category = ServiceCategory::findOrFail($id);
            return $this->successResponse($category, 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    #[OA\Post(
        path: '/update-service-category/{id}',
        summary: 'Update a service category (admin)',
        security: [['sanctum' => []]],
        tags: ['Service Categories'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\MediaType(
                mediaType: 'multipart/form-data',
                schema: new OA\Schema(ref: '#/components/schemas/CategoryUpdateRequest'),
            ),
        ),
        responses: [
            new EntityOkResponse('ServiceCategory'),
            new NotFoundResponse('Service category not found'),
            new UnauthorizedResponse(), new ForbiddenResponse(), new ServerErrorResponse(),
        ],
    )]
    public function update($id, UpdateCategoryRequest $request)
    {
        try {
            $category = ServiceCategory::findOrFail($id);
            $data = $request->validated();
            $category->update($data);
            if ($request->has('image')) {
                $this->imageservice->ImageUploaderwithvariable($request, $category, 'images/cardcategories');
            }
            $category->fresh();

            return $this->successResponse($category, 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }



    #[OA\Post(
        path: '/update-service-category-state/{id}',
        summary: 'Toggle service category activity state (admin)',
        security: [['sanctum' => []]],
        tags: ['Service Categories'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['is_active'],
                properties: [
                    new OA\Property(property: 'is_active', type: 'boolean', example: true),
                ],
            ),
        ),
        responses: [
            new EntityOkResponse('ServiceCategory'),
            new NotFoundResponse('Service category not found'),
            new UnauthorizedResponse(), new ForbiddenResponse(), new ServerErrorResponse(),
        ],
    )]
    public function updateState($id, Request $request)
    {
        try {
            $category = ServiceCategory::findOrFail($id);

            // Get the new value of is_active from the request
            $is_active = $request->is_active;

            // Update using correct array syntax
            $category->update([
                'is_active' => $is_active
            ]);

            $category->fresh();
            $category->load('cards');

            // Return the fresh updated model
            return $this->successResponse($category, 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */


    #[OA\Delete(
        path: '/delete-service-category/{id}',
        summary: 'Delete a service category (admin)',
        security: [['sanctum' => []]],
        tags: ['Service Categories'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OkResponse('Service category deleted'),
            new NotFoundResponse('Service category not found'),
            new ErrorResponse(400, 'Category linked to cards'),
            new UnauthorizedResponse(), new ForbiddenResponse(), new ServerErrorResponse(),
        ],
    )]
    public function destroy($id)
    {
        try {
            $articleCategory = ServiceCategory::findOrFail($id);

            if ($articleCategory->image) {
                $this->imageservice->deleteOldImage($articleCategory, 'images/cardcategories');
            }

            $articleCategory->delete();

            return $this->successResponse(['name' => $articleCategory->title_en], 200);
        } catch (QueryException $e) {
            // 1451 = Cannot delete or update a parent row: a foreign key constraint fails
            if ($e->errorInfo[1] == 1451) {
                return $this->errorResponse(
                    'لا يمكن حذف القسم لأنه مرتبط ببطاقات أخرى.',
                    400
                );
            }

            return $this->errorResponse('حدث خطأ في قاعدة البيانات.', 500);
        } catch (\Exception $e) {
            return $this->errorResponse('حدث خطأ غير متوقع.', 500);
        }
    }
}
