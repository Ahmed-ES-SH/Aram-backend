<?php

namespace App\Http\Controllers;

use App\Helpers\TextNormalizer;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Services\ImageService;
use App\Http\Traits\ApiResponse;
use App\Models\ArticleCategory;
use App\Models\Category;
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
use Exception;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class ArticleCategoryController extends Controller
{

    use ApiResponse;
    protected $imageservice;

    public function __construct(ImageService $imageService)
    {
        $this->imageservice = $imageService;
    }

    #[OA\Get(
        path: '/article-categories',
        summary: 'List all article categories (paginated)',
        tags: ['Article Categories'],
        responses: [
            new PaginatedOkResponse('ArticleCategory'),
            new NotFoundResponse('No article categories found'),
            new ServerErrorResponse( 'Server error'),
        ],
    )]
    public function index()
    {
        try {
            $Categories = ArticleCategory::orderBy('created_at', 'desc')->paginate(30);
            if ($Categories->total() === 0) {
                return $this->noContentResponse();
            }
            return $this->paginationResponse($Categories, 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }


    #[OA\Get(
        path: '/all-article-categories',
        summary: 'List all article categories',
        tags: ['Article Categories'],
        responses: [
            new ListOkResponse('ArticleCategory'),
            new NotFoundResponse('No article categories found'),
            new ServerErrorResponse( 'Server error'),
        ],
    )]
    public function allCategories()
    {
        try {
            $categories = ArticleCategory::orderBy('created_at', 'desc')->get();

            if ($categories->isEmpty()) {
                return $this->noContentResponse();
            }

            return $this->successResponse($categories, 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }




    #[OA\Get(
        path: '/public-article-categories',
        summary: 'List public article categories (limit 10)',
        tags: ['Article Categories'],
        responses: [
            new ListOkResponse('ArticleCategory'),
            new NotFoundResponse('No article categories found'),
            new ServerErrorResponse( 'Server error'),
        ],
    )]
    public function publicCategories()
    {
        try {
            $categories = ArticleCategory::orderByDesc('created_at')->limit(10)->get();

            if ($categories->count() === 0) {
                return $this->noContentResponse();
            }

            return $this->successResponse($categories, 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }


    #[OA\Get(
        path: '/all-public-article-categories',
        summary: 'List all article categories (public)',
        tags: ['Article Categories'],
        responses: [
            new ListOkResponse('ArticleCategory'),
            new NotFoundResponse('No article categories found'),
            new ServerErrorResponse( 'Server error'),
        ],
    )]
    public function allpublicCategories()
    {
        try {
            $categories = ArticleCategory::orderByDesc('created_at')->get();

            if ($categories->count() === 0) {
                return $this->noContentResponse();
            }

            return $this->successResponse($categories, 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    #[OA\Post(
        path: '/article-categories/search',
        summary: 'Search article categories by title (admin)',
        security: [['sanctum' => []]],
        tags: ['Article Categories'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['query'],
                properties: [
                    new OA\Property(property: 'query', type: 'string', example: 'أخبار'),
                ],
            ),
        ),
        responses: [
            new PaginatedOkResponse('ArticleCategory'),
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
            $results = ArticleCategory::where(function ($q) use ($normalizedQuery, $normalizedSql) {
                $q->whereRaw("$normalizedSql LIKE ?", ["%$normalizedQuery%"])
                    ->orWhere('title_en', 'LIKE', "%$normalizedQuery%");
            })->paginate(30);

            return $this->paginationResponse($results, 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }



    #[OA\Post(
        path: '/add-article-category',
        summary: 'Create a new article category (admin)',
        security: [['sanctum' => []]],
        tags: ['Article Categories'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\MediaType(
                mediaType: 'multipart/form-data',
                schema: new OA\Schema(ref: '#/components/schemas/CategoryStoreRequest'),
            ),
        ),
        responses: [
            new EntityOkResponse('ArticleCategory', 'Created'),
            new UnauthorizedResponse(), new ForbiddenResponse(), new ServerErrorResponse(),
        ],
    )]
    public function store(StoreCategoryRequest $request)
    {
        try {
            $data = $request->validated();
            $category = ArticleCategory::create($data);
            if ($request->has('image')) {
                $this->imageservice->ImageUploaderwithvariable($request, $category, 'images/articleCategories', 'image');
            }
            return $this->successResponse($category, 201);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    #[OA\Get(
        path: '/article-category/{id}',
        summary: 'Show a single article category (admin)',
        security: [['sanctum' => []]],
        tags: ['Article Categories'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new EntityOkResponse('ArticleCategory'),
            new NotFoundResponse('Article category not found'),
            new UnauthorizedResponse(), new ForbiddenResponse(), new ServerErrorResponse(),
        ],
    )]
    public function show($id)
    {

        try {
            $category = ArticleCategory::findOrFail($id);
            return $this->successResponse($category, 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }



    #[OA\Post(
        path: '/update-article-category/{id}',
        summary: 'Update an article category (admin)',
        security: [['sanctum' => []]],
        tags: ['Article Categories'],
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
            new EntityOkResponse('ArticleCategory'),
            new NotFoundResponse('Article category not found'),
            new UnauthorizedResponse(), new ForbiddenResponse(), new ServerErrorResponse(),
        ],
    )]
    public function update($id, UpdateCategoryRequest $request)
    {
        try {
            $category = ArticleCategory::findOrFail($id);
            $data = $request->validated();
            $category->update($data);
            if ($request->has('image')) {
                $this->imageservice->ImageUploaderwithvariable($request, $category, 'images/articleCategories');
            }
            return $this->successResponse($category->fresh(), 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    #[OA\Delete(
        path: '/delete-article-category/{id}',
        summary: 'Delete an article category (admin)',
        security: [['sanctum' => []]],
        tags: ['Article Categories'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OkResponse('Article category deleted'),
            new NotFoundResponse('Article category not found'),
            new UnauthorizedResponse(), new ForbiddenResponse(), new ServerErrorResponse(),
        ],
    )]
    public function destroy($id)
    {
        try {
            $articleCategory = ArticleCategory::findOrFail($id);

            if ($articleCategory->image) {
                $this->imageservice->deleteOldImage($articleCategory, 'images/articleCategories');
            }

            $articleCategory->delete();

            return $this->successResponse(['name' => $articleCategory->title_en], 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
