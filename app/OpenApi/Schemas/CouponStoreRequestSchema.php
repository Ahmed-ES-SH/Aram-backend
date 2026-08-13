<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'CouponStoreRequest',
    title: 'Coupon Store/Update Request',
    description: 'Payload for creating or updating a coupon (multipart/form-data).',
)]
class CouponStoreRequestSchema
{
    #[OA\Property(property: 'code', type: 'string', maxLength: 50, example: 'WELCOME10')]
    public string $code = '';

    #[OA\Property(property: 'title', type: 'string', maxLength: 255, example: 'Welcome Discount')]
    public string $title = '';

    #[OA\Property(property: 'description', type: 'string', example: '10% off your first purchase.')]
    public string $description = '';

    #[OA\Property(property: 'image', type: 'string', format: 'binary', description: 'Image file (max 5048 KB).')]
    public string $image = '';

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

    #[OA\Property(property: 'category_id', type: 'integer', example: 1)]
    public int $category_id = 0;

    #[OA\Property(property: 'usage_limit', type: 'integer', nullable: true, example: 50)]
    public ?int $usage_limit = null;

    #[OA\Property(property: 'status', type: 'string', enum: ['active', 'inactive', 'expired'], example: 'active')]
    public string $status = '';

    #[OA\Property(
        property: 'organizations',
        type: 'array',
        nullable: true,
        description: 'JSON encoded array of organization ids.',
        items: new OA\Items(type: 'integer'),
    )]
    public ?array $organizations = null;

    #[OA\Property(
        property: 'users',
        type: 'array',
        nullable: true,
        description: 'JSON encoded array of user ids.',
        items: new OA\Items(type: 'integer'),
    )]
    public ?array $users = null;

    #[OA\Property(
        property: 'sub_categories',
        type: 'array',
        nullable: true,
        description: 'JSON encoded array of sub category ids.',
        items: new OA\Items(type: 'integer'),
    )]
    public ?array $sub_categories = null;
}