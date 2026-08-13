<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;
use App\Http\Requests\CreateServiceOrderInvoiceRequest;
use App\Http\Requests\StoreServiceOrderRequest;
use App\Http\Resources\ServiceOrderResource;
use App\Http\Services\NotificationService;
use App\Http\Traits\ApiResponse;
use App\Http\Services\StoreServiceOrderService;
use App\Models\Organization;
use App\Models\ServiceOrder;
use App\Modules\User\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Exception;
use Throwable;
use App\OpenApi\Responses\CreatedResponse;
use App\OpenApi\Responses\EntityOkResponse;
use App\OpenApi\Responses\ErrorResponse;
use App\OpenApi\Responses\NoContentResponse;
use App\OpenApi\Responses\OkResponse;
use App\OpenApi\Responses\PaginatedOkResponse;
use App\OpenApi\Responses\ServerErrorResponse;
use App\OpenApi\Responses\UnauthorizedResponse;
use App\OpenApi\Responses\UnprocessableResponse;

class ServiceOrderController extends Controller
{
    use ApiResponse;
    protected $notificationService;
    protected $storeServiceOrderService;


    public function __construct(NotificationService $notificationService, StoreServiceOrderService $storeServiceOrderService)
    {
        $this->notificationService = $notificationService;
        $this->storeServiceOrderService = $storeServiceOrderService;
    }


    #[OA\Get(
        path: '/all-service-orders',
        summary: 'List all service orders with filters (admin, paginated)',
        security: [['sanctum' => []]],
        tags: ['Service Orders'],
        parameters: [
            new OA\Parameter(name: 'status', in: 'query', required: false, schema: new OA\Schema(type: 'string', enum: ['pending', 'confirmed', 'in_progress', 'on_hold', 'completed', 'canceled', 'refunded'])),
            new OA\Parameter(name: 'payment_status', in: 'query', required: false, schema: new OA\Schema(type: 'string', enum: ['pending', 'paid', 'failed'])),
            new OA\Parameter(name: 'subscription_status', in: 'query', required: false, schema: new OA\Schema(type: 'string', enum: ['active', 'expired'])),
            new OA\Parameter(name: 'user_type', in: 'query', required: false, schema: new OA\Schema(type: 'string', enum: ['user', 'organization'])),
            new OA\Parameter(name: 'search', in: 'query', required: false, schema: new OA\Schema(type: 'string'), description: 'Search term'),
            new OA\Parameter(name: 'per_page', in: 'query', required: false, schema: new OA\Schema(type: 'integer'), description: 'Items per page (default 15)'),
        ],
        responses: [
            new PaginatedOkResponse('ServiceOrder'),
            new NoContentResponse(),
            new UnauthorizedResponse(),
            new ServerErrorResponse(),
        ],
    )]
    #[OA\Get(
        path: '/service-orders',
        summary: 'List all service orders with filters (admin, paginated)',
        security: [['sanctum' => []]],
        tags: ['Service Orders'],
        parameters: [
            new OA\Parameter(name: 'status', in: 'query', required: false, schema: new OA\Schema(type: 'string', enum: ['pending', 'confirmed', 'in_progress', 'on_hold', 'completed', 'canceled', 'refunded'])),
            new OA\Parameter(name: 'payment_status', in: 'query', required: false, schema: new OA\Schema(type: 'string', enum: ['pending', 'paid', 'failed'])),
            new OA\Parameter(name: 'subscription_status', in: 'query', required: false, schema: new OA\Schema(type: 'string', enum: ['active', 'expired'])),
            new OA\Parameter(name: 'user_type', in: 'query', required: false, schema: new OA\Schema(type: 'string', enum: ['user', 'organization'])),
            new OA\Parameter(name: 'search', in: 'query', required: false, schema: new OA\Schema(type: 'string'), description: 'Search term'),
            new OA\Parameter(name: 'per_page', in: 'query', required: false, schema: new OA\Schema(type: 'integer'), description: 'Items per page (default 15)'),
        ],
        responses: [
            new PaginatedOkResponse('ServiceOrder'),
            new NoContentResponse(),
            new UnauthorizedResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function index(Request $request)
    {
        try {
            $filters = $request->all();

            $orders = ServiceOrder::filter($filters)
                ->with([
                    'service',
                    'service.firstImage',
                    'invoice',
                    'owner' => function (MorphTo $morphTo) {
                        $morphTo->constrain([
                            User::class => function ($query) {
                                $query->select('id', 'name', 'email', 'image', 'account_type');
                            },
                            Organization::class => function ($query) {
                                $query->select(
                                    'id',
                                    'email',
                                    'title as name',
                                    'logo as image',
                                    'account_type'
                                );
                            },
                        ]);
                    },
                ])
                ->withCount('tracking')
                ->paginate($request->get('per_page', 15));


            if ($orders->total() === 0) {
                return $this->noContentResponse();
            }

            $orders->getCollection()->transform(function ($order) {
                return $this->normalizeOrder($order);
            });

            return $this->paginationResponse($orders, 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }



    public function getDealOrders(Request $request)
    {
        try {
            $filters = $request->all();
            $query = ServiceOrder::where('is_deal', true);

            $orders = $query->with([
                'service',
                'service.firstImage',
                'invoice'
            ])
                ->withCount('tracking')
                ->filter($filters)
                ->paginate($request->get('per_page', 15));

            if ($orders->total() === 0) {
                return $this->noContentResponse();
            }

            $orders->getCollection()->transform(function ($order) {
                return $this->normalizeOrder($order);
            });

            return $this->paginationResponse($orders, 200);
        } catch (Throwable $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    #[OA\Get(
        path: '/get-service-orders-options',
        summary: 'Get filter options for service orders (admin)',
        security: [['sanctum' => []]],
        tags: ['Service Orders'],
        responses: [
            new OkResponse('Filter options'),
            new UnauthorizedResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function getFilterOptions(): \Illuminate\Http\JsonResponse
    {
        return $this->successResponse([
            'statuses' => ['pending', 'confirmed', 'in_progress', 'on_hold', 'completed', 'canceled', 'refunded'],
            'payment_statuses' => ['pending', 'paid', 'failed'],
            'subscription_statuses' => ['active', 'expired'],
            'user_types' => ['user', 'organization'],
        ], 200);
    }



    #[OA\Get(
        path: '/service-orders/{serviceOrder}',
        summary: 'Show a service order detail (admin)',
        security: [['sanctum' => []]],
        tags: ['Service Orders'],
        parameters: [
            new OA\Parameter(name: 'serviceOrder', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new EntityOkResponse('ServiceOrder'),
            new UnauthorizedResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function adminShow(ServiceOrder $serviceOrder)
    {
        try {

            $serviceOrder->load([
                'service',
                'service.firstImage',
                'tracking',
                'tracking.files',
                'invoice',
                'owner' => function (MorphTo $morphTo) {
                    $morphTo->constrain([
                        User::class => function ($query) {
                            $query->select('id', 'name', 'email', 'image', 'account_type');
                        },
                        Organization::class => function ($query) {
                            $query->select(
                                'id',
                                'email',
                                'title as name',
                                'logo as image',
                                'account_type'
                            );
                        },
                    ]);
                },
            ]);

            if ($serviceOrder->user_type === 'user') {
                $serviceOrder->load('user:id,name,email,image');
            } else {
                $serviceOrder->load('organization:id,title as name,email,logo as image');
            }

            $this->normalizeOrder($serviceOrder);

            return $this->successResponse(
                new ServiceOrderResource($serviceOrder),
                200
            );
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }



    #[OA\Post(
        path: '/store-service-order',
        summary: 'Create a new service order',
        security: [['sanctum' => []]],
        tags: ['Service Orders'],
requestBody: new OA\RequestBody(
            required: true,
            content: new OA\MediaType(
                mediaType: 'multipart/form-data',
                schema: new OA\Schema(
                    type: 'object',
                    properties: [
                        new OA\Property(property: 'service_id', type: 'integer'),
                        new OA\Property(property: 'activity_id', type: 'integer', nullable: true),
                        new OA\Property(property: 'invoice_type', type: 'string', nullable: true),
                        new OA\Property(property: 'metadata', type: 'object'),
                        new OA\Property(property: 'files', type: 'array', items: new OA\Items(type: 'object'), description: 'Attached files'),
                    ],
                ),
            ),
        ),
        responses: [
            new CreatedResponse('Order created'),
            new ErrorResponse(422, 'Order creation failed'),
            new UnauthorizedResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function StoreServiceOrder(StoreServiceOrderRequest $request)
    {
        try {
            $order = $this->storeServiceOrderService->store($request);

            if (!$order) {
                return $this->errorResponse('Order creation failed', 422);
            }

            $order->load('tracking', 'tracking.files', 'service:id,slug');
            return $this->successResponse($order, 201);
        } catch (Throwable  $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }


    #[OA\Post(
        path: '/service-orders/create-invoice',
        summary: 'Create an invoice for a service order (admin)',
        security: [['sanctum' => []]],
        tags: ['Service Orders'],
requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['order_id', 'invoice_number', 'total_invoice', 'invoice_type', 'user_id', 'user_type'],
                properties: [
                    new OA\Property(property: 'order_id', type: 'integer'),
                    new OA\Property(property: 'invoice_number', type: 'string'),
                    new OA\Property(property: 'total_invoice', type: 'number'),
                    new OA\Property(property: 'before_discount', type: 'number', nullable: true),
                    new OA\Property(property: 'discount', type: 'number', nullable: true),
                    new OA\Property(property: 'ref_code', type: 'string', nullable: true),
                    new OA\Property(property: 'invoice_type', type: 'string'),
                    new OA\Property(property: 'user_id', type: 'integer'),
                    new OA\Property(property: 'tax_amount', type: 'number', nullable: true),
                    new OA\Property(property: 'user_type', type: 'string', enum: ['user', 'organization']),
                ],
            ),
        ),
        responses: [
            new CreatedResponse('Invoice created'),
            new ErrorResponse(422, 'Invoice creation failed'),
            new UnauthorizedResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function createServiceOrderInvoice(CreateServiceOrderInvoiceRequest $request)
    {
        try {
            $invoice = $this->storeServiceOrderService->createInvoice($request);

            if (!$invoice) {
                return $this->errorResponse('Invoice creation failed', 422);
            }

            return $this->successResponse($invoice, 201);
        } catch (Throwable  $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }


    public function checkExpiredSubscriptions()
    {
        try {
            // Trigger the command to handle expiration
            \Illuminate\Support\Facades\Artisan::call('subscriptions:check-expired');

            return $this->successResponse('Expired subscriptions check initiated successfully', 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    #[OA\Get(
        path: '/user-service-orders',
        summary: 'List the authenticated account service orders (paginated)',
        security: [['sanctum' => []]],
        tags: ['Service Orders'],
        parameters: [
            new OA\Parameter(name: 'per_page', in: 'query', required: false, schema: new OA\Schema(type: 'integer'), description: 'Items per page (default 15)'),
        ],
        responses: [
            new PaginatedOkResponse('ServiceOrder'),
            new NoContentResponse(),
            new UnauthorizedResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function userServiceOrders(Request $request)
    {
        try {
            $user = $request->user();

            $orders = ServiceOrder::where('user_id', $user->id)
                ->where('user_type', $user->account_type)
                ->with([
                    'service',
                    'service.galleryImages',
                    'invoice'
                ])
                ->withCount('tracking')
                ->orderBy('created_at', 'desc')
                ->paginate(15);

            if ($orders->isEmpty()) {
                return $this->noContentResponse();
            }

            // 🔥 Normalize before response
            $orders->getCollection()->transform(function ($order) {
                return $this->normalizeOrder($order);
            });

            return $this->paginationResponse($orders, 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }


    #[OA\Post(
        path: '/service-orders/{serviceOrder}/update-status',
        summary: 'Update a service order status (admin)',
        security: [['sanctum' => []]],
        tags: ['Service Orders'],
        parameters: [
            new OA\Parameter(name: 'serviceOrder', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['status'],
                properties: [
                    new OA\Property(property: 'status', type: 'string', enum: ['pending', 'confirmed', 'in_progress', 'on_hold', 'completed', 'canceled', 'refunded']),
                ],
            ),
        ),
        responses: [
            new EntityOkResponse('ServiceOrder'),
            new UnprocessableResponse(),
            new UnauthorizedResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function updateStatus(ServiceOrder $serviceOrder, Request $request)
    {
        try {

            $request->validate([
                'status' => 'required|string|in:pending,confirmed,in_progress,on_hold,completed,canceled,refunded',
            ]);

            $serviceOrder->update([
                'status' => $request->status,
            ]);

            return $this->successResponse(
                new ServiceOrderResource($serviceOrder),
                200
            );
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }


    #[OA\Get(
        path: '/user-service-orders/{serviceOrder}',
        summary: 'Show one of the authenticated account service orders',
        security: [['sanctum' => []]],
        tags: ['Service Orders'],
        parameters: [
            new OA\Parameter(name: 'serviceOrder', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new EntityOkResponse('ServiceOrder'),
            new UnauthorizedResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function showOrder(ServiceOrder $serviceOrder, Request $request)
    {
        $serviceOrder->load([
            'service',
            'service.galleryImages',
            'invoice',
            'tracking',
            'tracking.files',
        ]);


        $this->normalizeOrder($serviceOrder);

        return $this->successResponse(
            new ServiceOrderResource($serviceOrder),
            200
        );
    }

    private function normalizeOrder(ServiceOrder $order): ServiceOrder
    {
        $metadata = $order->metadata;

        if ($this->isJson($metadata)) {
            $metadata = json_decode($metadata, true);
        }

        if (
            is_array($metadata) &&
            isset($metadata['items']['metadata']) &&
            $this->isJson($metadata['items']['metadata'])
        ) {
            $metadata['items']['metadata'] = json_decode(
                $metadata['items']['metadata'],
                true
            );
        }

        $order->metadata = $metadata;

        return $order;
    }

    private function isJson($value): bool
    {
        if (!is_string($value)) {
            return false;
        }

        json_decode($value, true);

        return json_last_error() === JSON_ERROR_NONE;
    }
}
