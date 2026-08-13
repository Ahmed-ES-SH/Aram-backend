<?php

namespace App\Http\Controllers;

use App\Helpers\TextNormalizer;
use App\Http\Requests\StoreSubCategoryRequest;
use App\Http\Requests\UpdateSubCategoryRequest;
use App\Http\Services\ImageService;
use App\Http\Traits\ApiResponse;
use App\Models\SubCategory;
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

class SubCategoryController extends Controller
{

    use ApiResponse;
    protected $imageservice;

    public function __construct(ImageService $imageService)
    {
        $this->imageservice = $imageService;
    }

    #[OA\Get(
        path: '/sub-categories',
        summary: 'List all sub categories (paginated)',
        tags: ['Sub Categories'],
        responses: [
            new PaginatedOkResponse('SubCategory'),
            new NotFoundResponse('No sub categories found'),
            new ServerErrorResponse( 'Server error'),
        ],
    )]
    public function index()
    {
        try {
            $Categories = SubCategory::orderBy('created_at', 'desc')->with('parent')->paginate(30);
            if ($Categories->total() === 0) {
                return $this->noContentResponse();
            }
            return $this->paginationResponse($Categories, 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }


    #[OA\Get(
        path: '/sub-categories-by-parent',
        summary: 'List sub categories of a parent category (paginated)',
        tags: ['Sub Categories'],
        parameters: [
            new OA\Parameter(
                name: 'parent_id',
                in: 'query',
                required: true,
                schema: new OA\Schema(type: 'integer'),
            ),
            new OA\Parameter(
                name: 'query',
                in: 'query',
                required: false,
                description: 'Optional search term.',
                schema: new OA\Schema(type: 'string'),
            ),
        ],
        responses: [
            new PaginatedOkResponse('SubCategory'),
            new NotFoundResponse('No sub categories found'),
            new UnprocessableResponse('Validation failed'),
            new ServerErrorResponse( 'Server error'),
        ],
    )]
    public function getSubCategoriesByParent(Request $request)
    {
        try {
            $request->validate([
                'parent_id' => 'required|exists:categories,id',
                'query'     => 'nullable|string|max:255',
            ]);

            $categories = SubCategory::with('parent:id,image,title_en')->withCount('organizations')->where('parent_id', $request->parent_id);


            if (!empty($request->query('query'))) {
                $query = $request->query('query', ''); // default string

                // ✅ Normalize Arabic search term
                $normalizedQuery = TextNormalizer::normalizeArabic($query);

                // ✅ SQL normalize for Arabic column
                $normalizedSql = TextNormalizer::sqlNormalizeColumn('title_ar');

                // ✅ Fulltext search
                $categories->where(function ($q) use ($normalizedQuery, $normalizedSql, $query) {
                    $q->whereRaw("MATCH(title_en) AGAINST (? IN BOOLEAN MODE)", [$query])
                        ->orWhereRaw("MATCH($normalizedSql) AGAINST (? IN BOOLEAN MODE)", [$normalizedQuery]);
                });
            }

            $categories = $categories->orderBy('created_at', 'desc')->paginate(12);

            if ($categories->total() === 0) {
                return $this->noContentResponse();
            }

            return $this->paginationResponse($categories, 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }




    #[OA\Get(
        path: '/sub-categories-by-state',
        summary: 'List sub categories by activity state (admin)',
        security: [['sanctum' => []]],
        tags: ['Sub Categories'],
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
            new PaginatedOkResponse('SubCategory'),
            new NotFoundResponse('No sub categories found'),
            new UnauthorizedResponse(), new ForbiddenResponse(), new ServerErrorResponse(),
        ],
    )]
    public function activeSubCategories(Request $request)
    {
        try {

            $state = $request->state;

            $Categories = SubCategory::orderBy('created_at', 'desc')->where('is_active', $state)->paginate(30);
            if ($Categories->total() === 0) {
                return $this->noContentResponse();
            }
            return $this->paginationResponse($Categories, 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    #[OA\Get(
        path: '/public-sub-categories',
        summary: 'List active public sub categories (paginated)',
        tags: ['Sub Categories'],
        responses: [
            new PaginatedOkResponse('SubCategory'),
            new NotFoundResponse('No sub categories found'),
            new ServerErrorResponse( 'Server error'),
        ],
    )]
    public function publicSubCategories()
    {
        try {
            $Categories = SubCategory::orderBy('created_at', 'desc')->where('is_active', true)->paginate(15);
            if ($Categories->isEmpty()) {
                return $this->noContentResponse();
            }
            return $this->paginationResponse($Categories, 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }


    #[OA\Get(
        path: '/all-public-sub-categories',
        summary: 'List all sub categories',
        tags: ['Sub Categories'],
        responses: [
            new ListOkResponse('SubCategory'),
            new NotFoundResponse('No sub categories found'),
            new ServerErrorResponse( 'Server error'),
        ],
    )]
    public function AllSubCategories()
    {
        try {
            $Categories = SubCategory::orderBy('created_at', 'desc')->get();
            if ($Categories->isEmpty()) {
                return $this->noContentResponse();
            }
            return $this->successResponse($Categories, 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    #[OA\Post(
        path: '/add-sub-category',
        summary: 'Create a new sub category (admin)',
        security: [['sanctum' => []]],
        tags: ['Sub Categories'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\MediaType(
                mediaType: 'multipart/form-data',
                schema: new OA\Schema(ref: '#/components/schemas/SubCategoryStoreRequest'),
            ),
        ),
        responses: [
            new EntityOkResponse('SubCategory', 'Created'),
            new UnauthorizedResponse(), new ForbiddenResponse(), new ServerErrorResponse(),
        ],
    )]
    public function store(StoreSubCategoryRequest $request)
    {
        try {
            $data = $request->validated();
            $category = new SubCategory();
            $category->fill($data);
            if ($request->has('image')) {
                $this->imageservice->ImageUploaderwithvariable($request, $category, 'images/subcategories', 'image');
            }
            return $this->successResponse($category, 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    #[OA\Get(
        path: '/sub-category/{id}',
        summary: 'Show a single sub category (admin)',
        security: [['sanctum' => []]],
        tags: ['Sub Categories'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new EntityOkResponse('SubCategory'),
            new NotFoundResponse('Sub category not found'),
            new UnauthorizedResponse(), new ForbiddenResponse(), new ServerErrorResponse(),
        ],
    )]
    public function show($id)
    {
        $category = SubCategory::findOrFail($id);
        return $this->successResponse($category, 200);
        try {
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }



    #[OA\Post(
        path: '/update-sub-category/{id}',
        summary: 'Update a sub category (admin)',
        security: [['sanctum' => []]],
        tags: ['Sub Categories'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\MediaType(
                mediaType: 'multipart/form-data',
                schema: new OA\Schema(ref: '#/components/schemas/SubCategoryUpdateRequest'),
            ),
        ),
        responses: [
            new EntityOkResponse('SubCategory'),
            new NotFoundResponse('Sub category not found'),
            new UnauthorizedResponse(), new ForbiddenResponse(), new ServerErrorResponse(),
        ],
    )]
    public function update($id, UpdateSubCategoryRequest $request)
    {
        try {
            $category = SubCategory::findOrFail($id);
            $data = $request->validated();
            $category->update($data);
            if ($request->has('image')) {
                $this->imageservice->ImageUploaderwithvariable($request, $category, 'images/subcategories');
            }
            return $this->successResponse($category->fresh(), 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }



    #[OA\Post(
        path: '/update-sub-category-state/{id}',
        summary: 'Toggle sub category activity state (admin)',
        security: [['sanctum' => []]],
        tags: ['Sub Categories'],
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
            new EntityOkResponse('SubCategory'),
            new NotFoundResponse('Sub category not found'),
            new UnauthorizedResponse(), new ForbiddenResponse(), new ServerErrorResponse(),
        ],
    )]
    public function updateState($id, Request $request)
    {
        try {
            $category = SubCategory::findOrFail($id);

            // Get the new value of is_active from the request
            $is_active = $request->is_active;

            // Update using correct array syntax
            $category->update([
                'is_active' => $is_active
            ]);

            // Return the fresh updated model
            return $this->successResponse($category->fresh(), 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    #[OA\Delete(
        path: '/delete-sub-category/{id}',
        summary: 'Delete a sub category (admin)',
        security: [['sanctum' => []]],
        tags: ['Sub Categories'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OkResponse('Sub category deleted'),
            new NotFoundResponse('Sub category not found'),
            new UnauthorizedResponse(), new ForbiddenResponse(), new ServerErrorResponse(),
        ],
    )]
    public function destroy($id)
    {
        try {
            $Category = SubCategory::findOrFail($id);

            if ($Category->image) {
                $this->imageservice->deleteOldImage($Category, 'images/subcategories');
            }

            $Category->delete();

            return $this->successResponse($Category, 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
