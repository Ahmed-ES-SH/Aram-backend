<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;
use App\Http\Requests\StoreServiceFormRequest;
use App\Http\Requests\UpdateServiceFormRequest;
use App\Http\Traits\ApiResponse;
use App\Models\ServiceForm;
use App\Models\ServicePage;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\OpenApi\Responses\CreatedResponse;
use App\OpenApi\Responses\EntityOkResponse;
use App\OpenApi\Responses\NotFoundResponse;
use App\OpenApi\Responses\OkResponse;
use App\OpenApi\Responses\PaginatedOkResponse;
use App\OpenApi\Responses\ServerErrorResponse;
use App\OpenApi\Responses\UnauthorizedResponse;
use App\OpenApi\Responses\UnprocessableResponse;

class ServiceFormController extends Controller
{
    use ApiResponse;

    /**
     * Get locale from request
     */
    private function getLocale(Request $request): string
    {
        $locale = $request->header('Accept-Language', 'en');
        return in_array($locale, ['ar', 'en']) ? $locale : 'en';
    }

    // ========== ADMIN ENDPOINTS ==========

    /**
     * List all service forms (Admin)
     */
    #[OA\Get(
        path: '/service-forms',
        summary: 'List service forms with filters (admin, paginated)',
        security: [['sanctum' => []]],
        tags: ['Service Forms'],
        parameters: [
            new OA\Parameter(name: 'service_page_id', in: 'query', required: false, schema: new OA\Schema(type: 'integer')),
            new OA\Parameter(name: 'is_active', in: 'query', required: false, schema: new OA\Schema(type: 'boolean')),
            new OA\Parameter(name: 'search', in: 'query', required: false, schema: new OA\Schema(type: 'string'), description: 'Search in Arabic/English name'),
            new OA\Parameter(name: 'per_page', in: 'query', required: false, schema: new OA\Schema(type: 'integer'), description: 'Items per page (default 15)'),
        ],
        responses: [
            new PaginatedOkResponse('ServiceForm'),
            new UnauthorizedResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function index(Request $request): JsonResponse
    {
        try {
            $query = ServiceForm::with(['servicePage:id,slug', 'fields']);

            // Filter by service page
            if ($request->has('service_page_id')) {
                $query->where('service_page_id', $request->service_page_id);
            }

            // Filter by status
            if ($request->has('is_active')) {
                $query->where('is_active', filter_var($request->is_active, FILTER_VALIDATE_BOOLEAN));
            }

            // Search
            if ($request->has('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('name_ar', 'like', "%{$search}%")
                        ->orWhere('name_en', 'like', "%{$search}%");
                });
            }

            $perPage = $request->get('per_page', 15);
            $forms = $query->orderBy('created_at', 'desc')->paginate($perPage);

            return $this->paginationResponse($forms);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Store a new service form (Admin)
     */
    #[OA\Post(
        path: '/add-service-form',
        summary: 'Create a service form (admin)',
        security: [['sanctum' => []]],
        tags: ['Service Forms'],
requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['service_page_id', 'name_ar', 'name_en'],
                properties: [
                    new OA\Property(property: 'service_page_id', type: 'integer'),
                    new OA\Property(property: 'name_ar', type: 'string'),
                    new OA\Property(property: 'name_en', type: 'string'),
                    new OA\Property(property: 'description_ar', type: 'string', nullable: true),
                    new OA\Property(property: 'description_en', type: 'string', nullable: true),
                    new OA\Property(property: 'is_active', type: 'boolean', nullable: true),
                ],
            ),
        ),
        responses: [
            new CreatedResponse('Service form created successfully'),
            new UnprocessableResponse(),
            new UnauthorizedResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function store(StoreServiceFormRequest $request): JsonResponse
    {
        try {
            $form = ServiceForm::create($request->validated());

            return $this->successResponse(
                $form->load('fields'),
                201,
                'Service form created successfully'
            );
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Get a single service form with fields (Admin)
     */
    #[OA\Get(
        path: '/service-form/{serviceForm}',
        summary: 'Show a service form with its fields (admin)',
        security: [['sanctum' => []]],
        tags: ['Service Forms'],
        parameters: [
            new OA\Parameter(name: 'serviceForm', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new EntityOkResponse('ServiceForm'),
            new UnauthorizedResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function show(ServiceForm $serviceForm): JsonResponse
    {
        try {
            $serviceForm->load(['servicePage:id,slug', 'fields']);

            return $this->successResponse($serviceForm);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Update a service form (Admin)
     */
    #[OA\Post(
        path: '/update-service-form/{serviceForm}',
        summary: 'Update a service form (admin)',
        security: [['sanctum' => []]],
        tags: ['Service Forms'],
        parameters: [
            new OA\Parameter(name: 'serviceForm', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                                properties: [
                    new OA\Property(property: 'service_page_id', type: 'integer', nullable: true),
                    new OA\Property(property: 'name_ar', type: 'string', nullable: true),
                    new OA\Property(property: 'name_en', type: 'string', nullable: true),
                    new OA\Property(property: 'description_ar', type: 'string', nullable: true),
                    new OA\Property(property: 'description_en', type: 'string', nullable: true),
                    new OA\Property(property: 'is_active', type: 'boolean', nullable: true),
                ],
            ),
        ),
        responses: [
            new OkResponse('Service form updated successfully'),
            new UnprocessableResponse(),
            new UnauthorizedResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function update(UpdateServiceFormRequest $request, ServiceForm $serviceForm): JsonResponse
    {
        try {
            $serviceForm->update($request->validated());
            $serviceForm->incrementVersion();

            return $this->successResponse(
                $serviceForm->fresh(['fields']),
                200,
                'Service form updated successfully'
            );
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Delete a service form (Admin)
     */
    #[OA\Delete(
        path: '/delete-service-form/{serviceForm}',
        summary: 'Delete a service form (admin)',
        security: [['sanctum' => []]],
        tags: ['Service Forms'],
        parameters: [
            new OA\Parameter(name: 'serviceForm', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OkResponse('Service form deleted successfully'),
            new UnauthorizedResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function destroy(ServiceForm $serviceForm): JsonResponse
    {
        try {
            $serviceForm->delete();

            return $this->successResponse([], 200, 'Service form deleted successfully');
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Duplicate a service form (Admin)
     */
    #[OA\Post(
        path: '/duplicate-service-form/{serviceForm}',
        summary: 'Duplicate a service form with its fields (admin)',
        security: [['sanctum' => []]],
        tags: ['Service Forms'],
        parameters: [
            new OA\Parameter(name: 'serviceForm', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new CreatedResponse('Service form duplicated successfully'),
            new UnauthorizedResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function duplicate(ServiceForm $serviceForm): JsonResponse
    {
        try {
            $newForm = $serviceForm->duplicate();

            return $this->successResponse(
                $newForm->load('fields'),
                201,
                'Service form duplicated successfully'
            );
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Toggle form active status (Admin)
     */
    #[OA\Post(
        path: '/toggle-service-form/{serviceForm}',
        summary: 'Toggle a service form active status (admin)',
        security: [['sanctum' => []]],
        tags: ['Service Forms'],
        parameters: [
            new OA\Parameter(name: 'serviceForm', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OkResponse('Form activated or deactivated'),
            new UnauthorizedResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function toggleActive(ServiceForm $serviceForm): JsonResponse
    {
        try {
            $serviceForm->update(['is_active' => !$serviceForm->is_active]);

            return $this->successResponse(
                $serviceForm->fresh(),
                200,
                $serviceForm->is_active ? 'Form activated' : 'Form deactivated'
            );
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    // ========== PUBLIC ENDPOINTS ==========

    /**
     * Get form schema for a service (Public/User)
     */
    #[OA\Get(
        path: '/service/{slug}/form',
        summary: 'Get the active form schema for a service page (public)',
        tags: ['Service Forms'],
        parameters: [
            new OA\Parameter(name: 'slug', in: 'path', required: true, schema: new OA\Schema(type: 'string')),
        ],
        responses: [
            new OkResponse('Form schema or has_form=false'),
            new NotFoundResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function getFormSchema(string $slug, Request $request): JsonResponse
    {
        try {
            $locale = $this->getLocale($request);

            $servicePage = ServicePage::where('slug', $slug)
                ->where('status', 'active')
                ->first();

            if (!$servicePage) {
                return $this->notFoundResponse('Service not found');
            }

            $form = ServiceForm::where('service_page_id', $servicePage->id)
                ->active()
                ->with('fields')
                ->first();

            if (!$form) {
                return $this->successResponse([
                    'has_form' => false,
                    'form' => null,
                    'fields' => [],
                ]);
            }

            return $this->successResponse([
                'has_form' => true,
                'form' => $form->getSchema($locale),
            ]);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
