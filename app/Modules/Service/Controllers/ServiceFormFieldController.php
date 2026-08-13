<?php

namespace App\Modules\Service\Controllers;
use App\Http\Controllers\Controller;

use OpenApi\Attributes as OA;
use App\Modules\Service\Requests\StoreServiceFormFieldRequest;
use App\Modules\Service\Requests\UpdateServiceFormFieldRequest;
use App\Http\Traits\ApiResponse;
use App\Modules\Service\Models\ServiceForm;
use App\Modules\Service\Models\ServiceFormField;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\OpenApi\Responses\CreatedResponse;
use App\OpenApi\Responses\OkResponse;
use App\OpenApi\Responses\ServerErrorResponse;
use App\OpenApi\Responses\UnauthorizedResponse;
use App\OpenApi\Responses\UnprocessableResponse;

class ServiceFormFieldController extends Controller
{
    use ApiResponse;

    /**
     * List all fields for a form (Admin)
     */
    #[OA\Get(
        path: '/service-form/{serviceForm}/fields',
        summary: 'List fields of a service form (admin)',
        security: [['sanctum' => []]],
        tags: ['Service Forms'],
        parameters: [
            new OA\Parameter(name: 'serviceForm', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OkResponse('Form fields'),
            new UnauthorizedResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function index(ServiceForm $serviceForm): JsonResponse
    {
        try {
            $fields = $serviceForm->fields()->ordered()->get();

            return $this->successResponse($fields);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Add a field to a form (Admin)
     */
    #[OA\Post(
        path: '/service-form/{serviceForm}/fields',
        summary: 'Add a field to a service form (admin)',
        security: [['sanctum' => []]],
        tags: ['Service Forms'],
        parameters: [
            new OA\Parameter(name: 'serviceForm', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['field_key', 'field_type', 'label_ar', 'label_en'],
                properties: [
                    new OA\Property(property: 'field_key', type: 'string', pattern: '^[a-z][a-z0-9_]*$'),
                    new OA\Property(property: 'field_type', type: 'string'),
                    new OA\Property(property: 'label_ar', type: 'string'),
                    new OA\Property(property: 'label_en', type: 'string'),
                    new OA\Property(property: 'placeholder_ar', type: 'string', nullable: true),
                    new OA\Property(property: 'placeholder_en', type: 'string', nullable: true),
                    new OA\Property(property: 'options', type: 'object', nullable: true),
                    new OA\Property(property: 'validation_rules', type: 'object', nullable: true),
                    new OA\Property(property: 'order', type: 'integer', nullable: true, minimum: 0),
                    new OA\Property(property: 'visibility_logic', type: 'object', nullable: true),
                    new OA\Property(property: 'is_required', type: 'boolean', nullable: true),
                ],
            ),
        ),
        responses: [
            new CreatedResponse('Field added successfully'),
            new UnprocessableResponse(),
            new UnauthorizedResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function store(StoreServiceFormFieldRequest $request, ServiceForm $serviceForm): JsonResponse
    {
        try {
            $data = $request->validated();
            $data['service_form_id'] = $serviceForm->id;

            // Auto-set order if not provided
            if (!isset($data['order'])) {
                $data['order'] = $serviceForm->fields()->max('order') + 1;
            }

            $field = ServiceFormField::create($data);

            // Increment form version
            $serviceForm->incrementVersion();

            return $this->successResponse($field, 201, 'Field added successfully');
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Get a single field (Admin)
     */
    #[OA\Get(
        path: '/service-form-field/{serviceFormField}',
        summary: 'Show a service form field (admin)',
        security: [['sanctum' => []]],
        tags: ['Service Forms'],
        parameters: [
            new OA\Parameter(name: 'serviceFormField', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OkResponse('Form field'),
            new UnauthorizedResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function show(ServiceFormField $serviceFormField): JsonResponse
    {
        try {
            return $this->successResponse($serviceFormField);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Update a field (Admin)
     */
    #[OA\Post(
        path: '/update-service-form-field/{serviceFormField}',
        summary: 'Update a service form field (admin)',
        security: [['sanctum' => []]],
        tags: ['Service Forms'],
        parameters: [
            new OA\Parameter(name: 'serviceFormField', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                                properties: [
                    new OA\Property(property: 'field_key', type: 'string', nullable: true),
                    new OA\Property(property: 'field_type', type: 'string', nullable: true),
                    new OA\Property(property: 'label_ar', type: 'string', nullable: true),
                    new OA\Property(property: 'label_en', type: 'string', nullable: true),
                    new OA\Property(property: 'placeholder_ar', type: 'string', nullable: true),
                    new OA\Property(property: 'placeholder_en', type: 'string', nullable: true),
                    new OA\Property(property: 'options', type: 'object', nullable: true),
                    new OA\Property(property: 'validation_rules', type: 'object', nullable: true),
                    new OA\Property(property: 'order', type: 'integer', nullable: true),
                    new OA\Property(property: 'visibility_logic', type: 'object', nullable: true),
                    new OA\Property(property: 'is_required', type: 'boolean', nullable: true),
                ],
            ),
        ),
        responses: [
            new OkResponse('Field updated successfully'),
            new UnprocessableResponse(),
            new UnauthorizedResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function update(UpdateServiceFormFieldRequest $request, ServiceFormField $serviceFormField): JsonResponse
    {
        try {
            $serviceFormField->update($request->validated());

            // Increment form version
            $serviceFormField->form->incrementVersion();

            return $this->successResponse(
                $serviceFormField->fresh(),
                200,
                'Field updated successfully'
            );
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Delete a field (Admin)
     */
    #[OA\Delete(
        path: '/delete-service-form-field/{serviceFormField}',
        summary: 'Delete a service form field (admin)',
        security: [['sanctum' => []]],
        tags: ['Service Forms'],
        parameters: [
            new OA\Parameter(name: 'serviceFormField', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OkResponse('Field deleted successfully'),
            new UnauthorizedResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function destroy(ServiceFormField $serviceFormField): JsonResponse
    {
        try {
            $form = $serviceFormField->form;
            $serviceFormField->delete();

            // Increment form version
            $form->incrementVersion();

            return $this->successResponse([], 200, 'Field deleted successfully');
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Reorder fields (Admin)
     */
    #[OA\Post(
        path: '/reorder-service-form-fields/{serviceForm}',
        summary: 'Reorder fields of a service form (admin)',
        security: [['sanctum' => []]],
        tags: ['Service Forms'],
        parameters: [
            new OA\Parameter(name: 'serviceForm', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['fields'],
                properties: [
                    new OA\Property(property: 'fields', type: 'array', items: new OA\Items(type: 'object'), description: 'List of {id, order}'),
                ],
            ),
        ),
        responses: [
            new OkResponse('Fields reordered successfully'),
            new UnprocessableResponse(),
            new UnauthorizedResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function reorder(Request $request, ServiceForm $serviceForm): JsonResponse
    {
        try {
            $request->validate([
                'fields' => 'required|array',
                'fields.*.id' => 'required|exists:service_form_fields,id',
                'fields.*.order' => 'required|integer|min:0',
            ]);

            foreach ($request->fields as $fieldData) {
                ServiceFormField::where('id', $fieldData['id'])
                    ->where('service_form_id', $serviceForm->id)
                    ->update(['order' => $fieldData['order']]);
            }

            // Increment form version
            $serviceForm->incrementVersion();

            return $this->successResponse(
                $serviceForm->fields()->ordered()->get(),
                200,
                'Fields reordered successfully'
            );
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Get available field types (Admin)
     */
    #[OA\Get(
        path: '/service-form-field-types',
        summary: 'Get available field types and visibility conditions (admin)',
        security: [['sanctum' => []]],
        tags: ['Service Forms'],
        responses: [
            new OkResponse('Field types'),
            new UnauthorizedResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function getFieldTypes(): JsonResponse
    {
        return $this->successResponse([
            'field_types' => ServiceFormField::FIELD_TYPES,
            'visibility_conditions' => ['equals', 'not_equals', 'contains', 'not_empty', 'empty'],
        ]);
    }
}
