<?php

namespace App\Modules\Content\Controllers;

use App\Http\Controllers\Controller;
use App\Helpers\TextNormalizer;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Services\ImageService;
use App\Http\Traits\ApiResponse;
use App\Modules\Content\Models\Category;
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
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class CategoryController extends Controller
{
    use ApiResponse;
    protected $imageservice;

    public function __construct(ImageService $imageService)
    {
        $this->imageservice = $imageService;
    }


    #[OA\Get(
        path: '/categories',
        summary: 'List all categories (paginated)',
        tags: ['Categories'],
        responses: [
            new PaginatedOkResponse('Category'),
            new NotFoundResponse('No categories found'),
            new ServerErrorResponse( 'Server error'),
        ],
    )]
    public function index()
    {
        try {
            $Categories = Category::withCount(['sub_categories', 'organizations'])->orderBy('created_at', 'desc')->paginate(30);
            if ($Categories->total() === 0) {
                return $this->noContentResponse();
            }
            return $this->paginationResponse($Categories, 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }


    #[OA\Get(
        path: '/categories-by-state',
        summary: 'List categories filtered by activity state (paginated)',
        tags: ['Categories'],
        parameters: [
            new OA\Parameter(
                name: 'state',
                in: 'query',
                required: true,
                schema: new OA\Schema(type: 'boolean'),
                example: true,
            ),
        ],
        responses: [
            new PaginatedOkResponse('Category'),
            new NotFoundResponse('No categories found'),
            new ServerErrorResponse( 'Server error'),
        ],
    )]
    public function activeCategories(Request $request)
    {
        try {

            $state = $request->state;

            $Categories = Category::withCount(['sub_categories', 'organizations'])
                ->orderBy('created_at', 'desc')
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


    #[OA\Get(
        path: '/categories-with-subcategories',
        summary: 'List all categories with their sub categories',
        tags: ['Categories'],
        responses: [
            new ListOkResponse('Category'),
            new NotFoundResponse('No categories found'),
            new ServerErrorResponse( 'Server error'),
        ],
    )]
    public function activeCategoriesWithSubCategories()
    {
        try {
            $Categories = Category::select('id', 'title_ar', 'title_en', 'image',  'icon_name')->withCount(['sub_categories', 'organizations'])
                ->with('sub_categories')
                ->orderBy('created_at', 'desc')
                ->get();

            if (!$Categories) {
                return $this->noContentResponse();
            }
            return $this->successResponse($Categories, 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }


    #[OA\Post(
        path: '/categories/search',
        summary: 'Search categories by title (admin)',
        security: [['sanctum' => []]],
        tags: ['Categories'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['query'],
                properties: [
                    new OA\Property(property: 'query', type: 'string', example: 'صح'),
                ],
            ),
        ),
        responses: [
            new PaginatedOkResponse('Category'),
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
            $results = Category::with('sub_categories')
                ->withCount(['sub_categories', 'organizations'])
                ->where(function ($q) use ($normalizedQuery, $normalizedSql) {
                    $q->whereRaw("$normalizedSql LIKE ?", ["%$normalizedQuery%"])
                        ->orWhere('title_en', 'LIKE', "%$normalizedQuery%");
                })->paginate(30);

            return $this->paginationResponse($results, 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }



    #[OA\Get(
        path: '/public-categories',
        summary: 'List public categories (paginated)',
        tags: ['Categories'],
        responses: [
            new PaginatedOkResponse('Category'),
            new NotFoundResponse('No categories found'),
            new ServerErrorResponse( 'Server error'),
        ],
    )]
    public function publicCategories()
    {
        try {

            $Categories = Category::withCount(['sub_categories', 'organizations'])
                ->with('sub_categories')
                ->orderBy('created_at', 'desc')
                ->paginate(12);
            if ($Categories->isEmpty()) {
                return $this->noContentResponse();
            }
            return $this->paginationResponse($Categories, 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }


    #[OA\Get(
        path: '/all-public-categories',
        summary: 'List all public categories',
        tags: ['Categories'],
        parameters: [
            new OA\Parameter(
                name: 'public',
                in: 'query',
                required: false,
                schema: new OA\Schema(type: 'boolean'),
            ),
        ],
        responses: [
            new ListOkResponse('Category'),
            new NotFoundResponse('No categories found'),
            new ServerErrorResponse( 'Server error'),
        ],
    )]
    public function AllPublicCategories(Request $request)
    {
        try {
            $request->validate([
                'public' => 'nullable|boolean',
            ]);

            $state = $request->boolean("public") ?? false;

            $Categories = Category::withCount(['sub_categories', 'organizations'])->orderBy('created_at', 'desc')->get();
            if ($Categories->isEmpty()) {
                return $this->noContentResponse();
            }
            return $this->successResponse($Categories, 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }




    #[OA\Post(
        path: '/add-category',
        summary: 'Create a new category (admin)',
        security: [['sanctum' => []]],
        tags: ['Categories'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\MediaType(
                mediaType: 'multipart/form-data',
                schema: new OA\Schema(ref: '#/components/schemas/CategoryStoreRequest'),
            ),
        ),
        responses: [
            new EntityOkResponse('Category', 'Created'),
            new UnauthorizedResponse(), new ForbiddenResponse(), new ServerErrorResponse(),
        ],
    )]
    public function store(StoreCategoryRequest $request)
    {
        try {
            $data = $request->validated();
            $category = new Category();
            $category->fill($data);
            if ($request->has('image')) {
                $this->imageservice->ImageUploaderwithvariable($request, $category, 'images/categories', 'image');
            }
            return $this->successResponse($category, 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    #[OA\Get(
        path: '/category/{id}',
        summary: 'Show a single category with organizations (admin)',
        security: [['sanctum' => []]],
        tags: ['Categories'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new EntityOkResponse('Category'),
            new NotFoundResponse('Category not found'),
            new UnauthorizedResponse(), new ForbiddenResponse(), new ServerErrorResponse(),
        ],
    )]
    public function show($id)
    {

        try {
            $category = Category::with('organizations:id,title,logo as image')->withCount(['sub_categories'])->findOrFail($id);
            return $this->successResponse($category, 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }



    #[OA\Post(
        path: '/update-category/{id}',
        summary: 'Update a category (admin)',
        security: [['sanctum' => []]],
        tags: ['Categories'],
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
            new EntityOkResponse('Category'),
            new NotFoundResponse('Category not found'),
            new UnauthorizedResponse(), new ForbiddenResponse(), new ServerErrorResponse(),
        ],
    )]
    public function update($id, UpdateCategoryRequest $request)
    {
        try {
            $category = Category::findOrFail($id);
            $data = $request->validated();
            $category->update($data);
            if ($request->has('image')) {
                $this->imageservice->ImageUploaderwithvariable($request, $category, 'images/categories');
            }
            $category->fresh();
            $category->load('sub_categories');

            return $this->successResponse($category, 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }



    #[OA\Post(
        path: '/update-category-state/{id}',
        summary: 'Toggle category activity state (admin)',
        security: [['sanctum' => []]],
        tags: ['Categories'],
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
            new EntityOkResponse('Category'),
            new NotFoundResponse('Category not found'),
            new UnauthorizedResponse(), new ForbiddenResponse(), new ServerErrorResponse(),
        ],
    )]
    public function updateState($id, Request $request)
    {
        try {
            $category = Category::findOrFail($id);

            // Get the new value of is_active from the request
            $is_active = $request->is_active;

            // Update using correct array syntax
            $category->update([
                'is_active' => $is_active
            ]);

            $category->fresh();
            $category->load('sub_categories');

            // Return the fresh updated model
            return $this->successResponse($category, 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    #[OA\Delete(
        path: '/delete-category/{id}',
        summary: 'Delete a category (admin)',
        security: [['sanctum' => []]],
        tags: ['Categories'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OkResponse('Category deleted'),
            new NotFoundResponse('Category not found'),
            new UnauthorizedResponse(), new ForbiddenResponse(), new ServerErrorResponse(),
        ],
    )]
    public function destroy($id)
    {
        try {
            $articleCategory = Category::findOrFail($id);

            if ($articleCategory->image) {
                $this->imageservice->deleteOldImage($articleCategory, 'images/categories');
            }

            $articleCategory->delete();

            return $this->successResponse(['name' => $articleCategory->title_en], 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }



    // public function multiDestroy(Request $request)
    // {
    //     try {
    //         $ids = $request->ids;

    //         if (is_string($ids)) {
    //             $ids = json_decode($ids, true);
    //         }

    //         Category::whereIn('id', $ids)->delete();
    //         return $this->successResponse(['message' => 'Deleted successfully'], 200);
    //     } catch (\Exception $e) {
    //         return $this->errorResponse($e->getMessage(), 500);
    //     }
    // }
}
