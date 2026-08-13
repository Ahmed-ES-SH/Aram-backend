<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'Coupon',
    title: 'Coupon',
    description: 'Coupon entity.',
    required: ['id', 'code', 'title'],
)]
class CouponSchema
{
    #[OA\Property(property: 'id', type: 'integer', example: 1)]
    public int $id = 0;

    #[OA\Property(property: 'title', type: 'string', example: 'Welcome Discount')]
    public string $title = '';

    #[OA\Property(property: 'description', type: 'string', example: '10% off your first purchase.')]
    public string $description = '';

    #[OA\Property(property: 'image', type: 'string', nullable: true, example: 'images/coupons/abc.jpg')]
    public ?string $image = null;

    #[OA\Property(property: 'code', type: 'string', example: 'WELCOME10')]
    public string $code = '';

    #[OA\Property(property: 'type', type: 'string', enum: ['user', 'organization', 'general'], example: 'general')]
    public string $type = '';

    #[OA\Property(property: 'benefit_type', type: 'string', enum: ['percentage', 'fixed', 'free_card'], example: 'percentage')]
    public string $benefit_type = '';

    #[OA\Property(property: 'discount_value', type: 'number', format: 'float', nullable: true, example: 10.0)]
    public ?float $discount_value = null;

    #[OA\Property(property: 'start_date', type: 'string', format: 'date', example: '2026-01-01')]
    public string $start_date = '';

    #[OA\Property(property: 'end_date', type: 'string', format: 'date', example: '2026-02-01')]
    public string $end_date = '';

    #[OA\Property(property: 'category_id', type: 'integer', nullable: true, example: 1)]
    public ?int $category_id = null;

    #[OA\Property(property: 'usage_limit', type: 'integer', nullable: true, example: 50)]
    public ?int $usage_limit = null;

    #[OA\Property(property: 'status', type: 'string', enum: ['active', 'inactive', 'expired'], example: 'active')]
    public string $status = '';

    #[OA\Property(property: 'created_at', type: 'string', format: 'date-time', example: '2026-01-01T10:00:00.000000Z')]
    public string $created_at = '';

    #[OA\Property(property: 'updated_at', type: 'string', format: 'date-time', example: '2026-01-01T10:00:00.000000Z')]
    public string $updated_at = '';
}