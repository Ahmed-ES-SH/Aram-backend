<?php

namespace App\Modules\Coupon\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Coupon\Requests\StoreCouponRequest;
use App\Modules\Coupon\Requests\UpdateCouponRequest;
use App\Modules\Coupon\Services\CouponAuthorizationService;
use App\Modules\Coupon\Services\CouponFetchService;
use App\Modules\Coupon\Services\CouponService;
use App\Modules\Coupon\Services\CouponUsageService;
use App\Modules\Coupon\Services\CouponValidationService;
use App\Http\Traits\ApiResponse;
use App\Modules\Coupon\Models\Coupon;
use App\Modules\Coupon\Models\CouponOrganization;
use App\Modules\Coupon\Models\CouponUsage;
use App\Modules\Coupon\Models\CouponUser;
use Exception;
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

class CouponController extends Controller
{
    use ApiResponse;

    protected $couponFetchService;
    protected $couponService;
    protected $couponValidationService;
    protected $couponAuthorizationService;
    protected $couponUsageService;

    public function __construct(
        CouponFetchService $couponFetchService,
        CouponService $couponService,
        CouponValidationService $couponValidationService,
        CouponAuthorizationService $couponAuthorizationService,
        CouponUsageService $couponUsageService
    ) {
        $this->couponFetchService = $couponFetchService;
        $this->couponService = $couponService;
        $this->couponValidationService = $couponValidationService;
        $this->couponAuthorizationService = $couponAuthorizationService;
        $this->couponUsageService = $couponUsageService;
    }

    /**
     * Display a listing of the resource.
     */
    #[OA\Get(
        path: '/dashboard/coupons',
        summary: 'List all coupons (admin, paginated)',
        security: [['sanctum' => []]],
        tags: ['Coupons'],
        responses: [
            new PaginatedOkResponse('Coupon'),
            new UnauthorizedResponse(),
            new ForbiddenResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function index(Request $request)
    {
        return $this->couponFetchService->getAllCoupons($request);
    }

    #[OA\Get(
        path: '/dashboard/active-coupons',
        summary: 'List active coupons (admin, paginated)',
        security: [['sanctum' => []]],
        tags: ['Coupons'],
        responses: [
            new PaginatedOkResponse('Coupon'),
            new UnauthorizedResponse(),
            new ForbiddenResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function activeCoupons(Request $request)
    {
        return $this->couponFetchService->getActiveCoupons($request);
    }

    #[OA\Get(
        path: '/account-coupons',
        summary: 'List coupons for the current account (paginated)',
        security: [['sanctum' => []]],
        tags: ['Coupons'],
        responses: [
            new PaginatedOkResponse('Coupon'),
            new UnauthorizedResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function accountCoupons(Request $request)
    {
        return $this->couponFetchService->getAccountCoupons($request);
    }

    #[OA\Post(
        path: '/check-coupon',
        summary: 'Validate and apply a coupon code',
        security: [['sanctum' => []]],
        tags: ['Coupons'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['code'],
                properties: [
                    new OA\Property(property: 'code', type: 'string', example: 'WELCOME10'),
                    new OA\Property(property: 'card_id', type: 'integer', nullable: true, example: 1),
                ],
            ),
        ),
        responses: [
            new OkResponse('Code is valid and applied'),
            new NotFoundResponse('Coupon code is invalid'),
            new UnprocessableResponse(),
            new UnauthorizedResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function checkCoupon(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'card_id' => 'nullable|exists:cards,id',
        ]);

        try {
            $coupon = Coupon::where('code', $request->code)->first();

            if (!$coupon) {
                return $this->errorResponse('كود الكوبون غير صحيح', 404);
            }

            $user = $request->user();

            // 1. Authorization: Can this user touch this coupon?
            // Returns the organization ID if distributed, or null.
            $distributingOrgId = $this->couponAuthorizationService->authorize($user, $coupon);

            // 2. Validation: Is the coupon valid (dates, status, limits)?
            $this->couponValidationService->validate($coupon, $distributingOrgId);

            // 3. Usage: Apply benefit and record usage
            // This unifies logic for Free Cards and General/Discount coupons.
            // If benefit_type is free_card, it requires card_id (validated in service or logic).

            // NOTE: This assumes checkCoupon is intended to *CONSUME* the coupon.
            $result = $this->couponUsageService->apply($user, $coupon, $distributingOrgId, $request->all());

            if ($coupon->benefit_type === 'free_card') {
                return $this->successResponse([], 201, $result['message']);
            }

            return $this->successResponse($coupon, 200, 'Code is valid and applied');
        } catch (Exception $e) {
            // Determine status code (default to 400 if 0 or strictly internal)
            $code = $e->getCode();
            if ($code < 100 || $code > 599) {
                $code = 400;
            }
            return $this->errorResponse($e->getMessage(), $code);
        }
    }

    #[OA\Post(
        path: '/dashboard/send-coupon',
        summary: 'Send a coupon to selected users/organizations (admin)',
        security: [['sanctum' => []]],
        tags: ['Coupons'],
        responses: [
            new OkResponse('Coupon sent'),
            new UnprocessableResponse(),
            new UnauthorizedResponse(),
            new ForbiddenResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function sendCoupon(Request $request)
    {
        return $this->couponService->sendCoupon($request);
    }

    #[OA\Post(
        path: '/distribute-coupon',
        summary: 'Distribute a coupon to an account',
        security: [['sanctum' => []]],
        tags: ['Coupons'],
        responses: [
            new OkResponse('Coupon distributed'),
            new UnprocessableResponse(),
            new UnauthorizedResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function distribute(Request $request)
    {
        return $this->couponService->distributeCoupon($request);
    }

    #[OA\Post(
        path: '/dashboard/add-coupon',
        summary: 'Create a new coupon (admin)',
        security: [['sanctum' => []]],
        tags: ['Coupons'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\MediaType(
                mediaType: 'multipart/form-data',
                schema: new OA\Schema(ref: '#/components/schemas/CouponStoreRequest'),
            ),
        ),
        responses: [
            new CreatedResponse('Coupon created'),
            new UnprocessableResponse(),
            new UnauthorizedResponse(),
            new ForbiddenResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function store(StoreCouponRequest $request)
    {
        return $this->couponService->createCoupon($request, $request->validated());
    }

    /**
     * Display the specified resource.
     */
    #[OA\Get(
        path: '/get-coupon/{id}',
        summary: 'Show a single coupon',
        security: [['sanctum' => []]],
        tags: ['Coupons'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new EntityOkResponse('Coupon'),
            new UnauthorizedResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function show($id)
    {
        return $this->couponFetchService->getCouponDetails($id);
    }

    /**
     * Update the specified resource in storage.
     */
    #[OA\Post(
        path: '/dashboard/update-coupon/{id}',
        summary: 'Update an existing coupon (admin)',
        security: [['sanctum' => []]],
        tags: ['Coupons'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\MediaType(
                mediaType: 'multipart/form-data',
                schema: new OA\Schema(ref: '#/components/schemas/CouponStoreRequest'),
            ),
        ),
        responses: [
            new EntityOkResponse('Coupon'),
            new UnprocessableResponse(),
            new UnauthorizedResponse(),
            new ForbiddenResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function update(UpdateCouponRequest $request, $id)
    {
        return $this->couponService->updateCoupon($request, $id, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    #[OA\Delete(
        path: '/dashboard/delete-coupon/{id}',
        summary: 'Delete a coupon (admin)',
        security: [['sanctum' => []]],
        tags: ['Coupons'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OkResponse('Coupon deleted'),
            new UnauthorizedResponse(),
            new ForbiddenResponse(),
            new ServerErrorResponse(),
        ],
    )]
    public function destroy($id)
    {
        return $this->couponService->deleteCoupon($id);
    }
}
