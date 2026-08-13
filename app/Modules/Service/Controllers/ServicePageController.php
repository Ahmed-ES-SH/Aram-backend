<?php

namespace App\Modules\Service\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Service\Requests\StoreServicePageRequest;
use App\Modules\Service\Requests\UpdateServicePageRequest;
use App\Modules\Service\Resources\ServicePageResource;
use App\Modules\Service\Services\ServicePageService;
use App\Http\Traits\ApiResponse;
use App\Modules\Service\Models\ServicePage;
use App\Modules\Service\Models\ServiceForm;
use App\Models\WebsiteVideo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Exception;

use App\OpenApi\Responses\OkResponse;
use App\OpenApi\Responses\ListOkResponse;
use App\OpenApi\Responses\PaginatedOkResponse;
use App\OpenApi\Responses\CreatedResponse;
use App\OpenApi\Responses\EntityOkResponse;
use App\OpenApi\Responses\NotFoundResponse;
use App\OpenApi\Responses\UnauthorizedResponse;
use App\OpenApi\Responses\ForbiddenResponse;
use App\OpenApi\Responses\ServerErrorResponse;
use App\OpenApi\Responses\ErrorResponse;
use App\OpenApi\Responses\UnprocessableResponse;

use OpenApi\Attributes as OA;

class ServicePageController extends Controller
{
    use ApiResponse;

    protected ServicePageService $servicePageService;

    public function __construct(ServicePageService $servicePageService)
    {
        $this->servicePageService = $servicePageService;
    }

    // =========================================================================
    // PUBLIC ENDPOINTS
    // =========================================================================

    #[OA\Get(
        path: '/service-pages',
        summary: 'List active service pages (filterable)',
        tags: ['Service Pages'],
        parameters: [
            new OA\Parameter(name: 'category_id', in: 'query', required: false, schema: new OA\Schema(type: 'integer')),
            new OA\Parameter(name: 'type', in: 'query', required: false, schema: new OA\Schema(type: 'string')),
            new OA\Parameter(name: 'min_price', in: 'query', required: false, schema: new OA\Schema(type: 'number')),
            new OA\Parameter(name: 'max_price', in: 'query', required: false, schema: new OA\Schema(type: 'number')),
            new OA\Parameter(name: 'is_active', in: 'query', required: false, schema: new OA\Schema(type: 'boolean')),
            new OA\Parameter(name: 'search', in: 'query', required: false, schema: new OA\Schema(type: 'string'), description: 'Search in slug'),
        ],
        responses: [
            new ListOkResponse('ServicePage'),
            new ServerErrorResponse(),
        ],
    )]
    public function index(Request $request): JsonResponse
    {
        try {
            $locale = $this->getLocale($request);

            $query = ServicePage::query()
                ->where('status', 'active')
                ->with(['heroSection', 'galleryImages', 'category:id,title_en,title_ar,icon_name']);

            // Filter by category
            if ($request->has('category_id')) {
                $query->where('category_id', $request->category_id);
            }

            // Filter by type
            if ($request->has('type')) {
                $query->where('type', $request->type);
            }

            // Filter by price range
            if ($request->has('min_price')) {
                $query->where('price', '>=', $request->min_price);
            }
            if ($request->has('max_price')) {
                $query->where('price', '<=', $request->max_price);
            }

            // Filter by is_active
            if ($request->has('is_active')) {
                $query->where('is_active', filter_var($request->is_active, FILTER_VALIDATE_BOOLEAN));
            }

            // Search in slug
            if ($request->has('search')) {
                $query->searchNormalized($request->search);
            }

            // Order by
            $query->Sort($query);

            $servicePages = $query->get()
                ->map(fn($page) => $this->formatCardData($page, $locale));

            return $this->successResponse($servicePages);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Get a single service page by slug (full data)
     */
    #[OA\Get(
        path: '/service-pages/{id}',
        summary: 'Show a single active service page with full data',
        tags: ['Service Pages'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new EntityOkResponse('ServicePage'),
            new NotFoundResponse('Service page not found'),
            new ServerErrorResponse(),
        ],
    )]
    public function show(int $id): JsonResponse|ServicePageResource
    {
        $servicePage = ServicePage::where('id', $id)
            ->where('status', 'active')
            ->with($this->servicePageService->getEagerLoadRelations())
            ->first();

        if (!$servicePage) {
            return $this->notFoundResponse('Service page not found');
        }

        $form = ServiceForm::where('service_page_id', $servicePage->id)->with('fields')->first();

        $service_video = WebsiteVideo::where('video_id', $this->formatTitle($servicePage->slug))->first();

        // Use setRelation to ensure the resource can access it via $this->video or $this->whenLoaded('video')
        $servicePage->setRelation('video', $service_video);

        $servicePage->setRelation('form', $form);

        return new ServicePageResource($servicePage);
    }

    // =========================================================================
    // ADMIN ENDPOINTS
    // =========================================================================

    #[OA\Get(
        path: '/dashboard/service-pages',
        summary: 'List all service pages (admin, paginated, filterable)',
        security: [['sanctum' => []]],
        tags: ['Service Pages'],
        parameters: [
            new OA\Parameter(name: 'per_page', in: 'query', required: false, schema: new OA\Schema(type: 'integer'), example: 15),
            new OA\Parameter(name: 'category_id', in: 'query', required: false, schema: new OA\Schema(type: 'integer')),
            new OA\Parameter(name: 'type', in: 'query', required: false, schema: new OA\Schema(type: 'string')),
            new OA\Parameter(name: 'status', in: 'query', required: false, schema: new OA\Schema(type: 'string')),
            new OA\Parameter(name: 'is_active', in: 'query', required: false, schema: new OA\Schema(type: 'boolean')),
            new OA\Parameter(name: 'min_price', in: 'query', required: false, schema: new OA\Schema(type: 'number')),
            new OA\Parameter(name: 'max_price', in: 'query', required: false, schema: new OA\Schema(type: 'number')),
            new OA\Parameter(name: 'search', in: 'query', required: false, schema: new OA\Schema(type: 'string')),
            new OA\Parameter(name: 'from_date', in: 'query', required: false, schema: new OA\Schema(type: 'string', format: 'date')),
            new OA\Parameter(name: 'to_date', in: 'query', required: false, schema: new OA\Schema(type: 'string', format: 'date')),
            new OA\Parameter(name: 'sort_by', in: 'query', required: false, schema: new OA\Schema(type: 'string', enum: ['created_at', 'price', 'order', 'slug', 'updated_at']), example: 'order'),
            new OA\Parameter(name: 'sort_order', in: 'query', required: false, schema: new OA\Schema(type: 'string', enum: ['asc', 'desc']), example: 'asc'),
        ],
        responses: [
            new PaginatedOkResponse('ServicePage'),
            new UnauthorizedResponse(),
            new ForbiddenResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function adminIndex(Request $request): JsonResponse
    {
        try {
            $perPage = $request->input('per_page', 15);
            $locale = $this->getLocale($request);

            $query = ServicePage::query()
                ->with(['heroSection', 'category:id,title_en,title_ar,icon_name,image']);

            // Filter by category
            if ($request->has('category_id')) {
                $query->where('category_id', $request->category_id);
            }

            // Filter by type
            if ($request->has('type')) {
                $query->where('type', $request->type);
            }

            // Filter by status
            if ($request->has('status')) {
                $query->where('status', $request->status);
            }

            // Filter by is_active
            if ($request->has('is_active')) {
                $query->where('is_active', filter_var($request->is_active, FILTER_VALIDATE_BOOLEAN));
            }

            // Filter by price range
            if ($request->has('min_price')) {
                $query->where('price', '>=', $request->min_price);
            }
            if ($request->has('max_price')) {
                $query->where('price', '<=', $request->max_price);
            }

            // Search in slug
            if ($request->has('search')) {
                $query->searchNormalized($request->search);
            }

            // Filter by date range
            if ($request->has('from_date')) {
                $query->whereDate('created_at', '>=', $request->from_date);
            }
            if ($request->has('to_date')) {
                $query->whereDate('created_at', '<=', $request->to_date);
            }

            // Sorting
            $sortBy = $request->input('sort_by', 'order');
            $sortOrder = $request->input('sort_order', 'asc');

            // Validate sort column
            $allowedSortColumns = ['created_at', 'price', 'order', 'slug', 'updated_at'];
            if (in_array($sortBy, $allowedSortColumns)) {
                $query->orderBy($sortBy, $sortOrder === 'desc' ? 'desc' : 'asc');
            } else {
                $query->Sort($query);
            }

            $servicePages = $query->paginate($perPage);

            $formattedData = $servicePages->getCollection()->map(
                fn($page) => $this->formatAdminListData($page, $locale)
            );

            $servicePages->setCollection($formattedData);

            return $this->paginationResponse($servicePages);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Get a single service page for admin editing
     */
    #[OA\Get(
        path: '/dashboard/service-pages/{id}',
        summary: 'Show a single service page for admin editing',
        security: [['sanctum' => []]],
        tags: ['Service Pages'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new EntityOkResponse('ServicePage'),
            new UnauthorizedResponse(),
            new ForbiddenResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function adminShow(int $id): JsonResponse
    {
        try {
            $servicePage = ServicePage::with($this->servicePageService->getEagerLoadRelations())
                ->findOrFail($id);

            $service_video = WebsiteVideo::where('video_id', $this->formatTitle($servicePage->slug))->first();

            // Use setRelation to ensure the resource can access it via $this->video or $this->whenLoaded('video')
            $servicePage->setRelation('video', $service_video);

            $form = ServiceForm::where('service_page_id', $servicePage->id)->with('fields')->first();

            $servicePage->setRelation('form', $form);

            return $this->successResponse($servicePage);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Store a new service page
     */
    #[OA\Post(
        path: '/dashboard/service-pages',
        summary: 'Create a new service page (admin)',
        security: [['sanctum' => []]],
        tags: ['Service Pages'],
        responses: [
            new CreatedResponse('Service page created'),
            new ErrorResponse(400, 'This order already exists'),
            new UnprocessableResponse(),
            new UnauthorizedResponse(),
            new ForbiddenResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function store(StoreServicePageRequest $request): JsonResponse
    {
        try {


            if (ServicePage::where('order', $request->order)->exists()) {
                return $this->errorResponse('هذا الترتيب موجود بالفعل', 400);
            }

            $servicePage = $this->servicePageService->create($request->validated(), $request);

            return $this->successResponse($servicePage, 201);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Update an existing service page
     */
    #[OA\Post(
        path: '/dashboard/service-pages/{id}',
        summary: 'Update an existing service page (admin)',
        security: [['sanctum' => []]],
        tags: ['Service Pages'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new EntityOkResponse('ServicePage'),
            new ErrorResponse(400, 'This order already exists'),
            new UnprocessableResponse(),
            new UnauthorizedResponse(),
            new ForbiddenResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function update(UpdateServicePageRequest $request, int $id): JsonResponse
    {
        try {

            if (
                ServicePage::where('order', $request->order)
                ->where('id', '!=', $id)
                ->exists()
            ) {
                return $this->errorResponse('هذا الترتيب موجود بالفعل', 400);
            }

            $servicePage = ServicePage::with($this->servicePageService->getEagerLoadRelations())->findOrFail($id);
            $updatedPage = $this->servicePageService->update($servicePage, $request->validated(), $request);

            return $this->successResponse($updatedPage, 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Delete a service page
     */
    #[OA\Delete(
        path: '/dashboard/service-pages/{id}',
        summary: 'Delete a service page (admin)',
        security: [['sanctum' => []]],
        tags: ['Service Pages'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OkResponse('Service page deleted successfully'),
            new UnauthorizedResponse(),
            new ForbiddenResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function destroy(int $id): JsonResponse
    {
        try {
            $servicePage = ServicePage::findOrFail($id);
            $this->servicePageService->delete($servicePage);

            return $this->successResponse([], 200, 'Service page deleted successfully');
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    // =========================================================================
    // HELPER METHODS
    // =========================================================================

    /**
     * Get validated locale from request
     */
    private function getLocale(Request $request): string
    {
        $locale = $request->header('Accept-Language', 'en');
        return in_array($locale, ['ar', 'en']) ? $locale : 'en';
    }

    /**
     * Format service page data for frontend cards
     */
    private function formatCardData(ServicePage $page, string $locale): array
    {
        $hero = $page->heroSection;
        $gallery = $page->galleryImages;

        return [
            'id' => $page->id,
            'slug' => $page->slug,
            'price' => $page->price,
            'price_before_discount' => $page->price_before_discount,
            'description' => $hero?->{"description_{$locale}"} ?? $hero?->description_en,
            'type' => $page->type,
            'payment_type' => $page->payment_type,
            'category' => $page->category,
            'status' => $page->status,
            'is_active' => $page->is_active,
            'title' => $hero?->{"title_{$locale}"} ?? $hero?->title_en,
            'subtitle' => $hero?->{"subtitle_{$locale}"} ?? $hero?->subtitle_en,
            'badge' => $hero?->{"badge_{$locale}"} ?? $hero?->badge_en,
            'image' => $gallery[0]['path'] ??  $gallery[0]['path'] ?? null,
        ];
    }

    /**
     * Format service page data for admin list
     */
    private function formatAdminListData(ServicePage $page, string $locale): array
    {
        $hero = $page->heroSection;
        $gallery = $page->galleryImages;

        return [
            'id' => $page->id,
            'slug' => $page->slug,
            'is_active' => $page->is_active,
            'title' => $hero?->{"title_{$locale}"} ?? $hero?->title_en,
            'image' => $gallery[0]['path'] ??  $gallery[0]['path'] ?? null,
            'price' => $page->price,
            'price_before_discount' => $page->price_before_discount,
            'type' => $page->type,
            'payment_type' => $page->payment_type,
            'category' => $page->category,
            'order' => $page->order,
            'status' => $page->status,
            'created_at' => $page->created_at?->toISOString(),
            'updated_at' => $page->updated_at?->toISOString(),
        ];
    }



    private function formatTitle(?string $title): string
    {
        return $title && trim($title) !== ''
            ? Str::slug($title)
            : 'no-title-' . uniqid();
    }
}
