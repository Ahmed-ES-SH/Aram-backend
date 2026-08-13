<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'Offer',
    title: 'Offer',
    description: 'Discount offer entity.',
    required: ['id', 'title'],
)]
class OfferSchema
{
    #[OA\Property(property: 'id', type: 'integer', example: 1)]
    public int $id = 0;

    #[OA\Property(property: 'title', type: 'string', example: 'Summer Sale')]
    public string $title = '';

    #[OA\Property(property: 'description', type: 'string', nullable: true, example: 'Get 30% off on all services.')]
    public ?string $description = null;

    #[OA\Property(property: 'image', type: 'string', nullable: true, example: 'images/offers/abc.jpg')]
    public ?string $image = null;

    #[OA\Property(property: 'number_of_uses', type: 'integer', example: 15)]
    public int $number_of_uses = 0;

    #[OA\Property(property: 'usage_limit', type: 'integer', nullable: true, example: 100)]
    public ?int $usage_limit = null;

    #[OA\Property(property: 'discount_type', type: 'string', enum: ['percentage', 'fixed'], example: 'percentage')]
    public string $discount_type = '';

    #[OA\Property(property: 'discount_value', type: 'number', format: 'float', example: 30.0)]
    public float $discount_value = 0;

    #[OA\Property(property: 'code', type: 'string', nullable: true, example: 'SUMMER30')]
    public ?string $code = null;

    #[OA\Property(property: 'start_date', type: 'string', format: 'date', example: '2026-01-01')]
    public string $start_date = '';

    #[OA\Property(property: 'end_date', type: 'string', format: 'date', nullable: true, example: '2026-02-01')]
    public ?string $end_date = null;

    #[OA\Property(property: 'status', type: 'string', enum: ['waiting', 'active', 'expired'], example: 'active')]
    public string $status = '';

    #[OA\Property(property: 'organization_id', type: 'integer', example: 1)]
    public int $organization_id = 0;

    #[OA\Property(property: 'category_id', type: 'integer', nullable: true, example: 1)]
    public ?int $category_id = null;

    #[OA\Property(
        property: 'organization',
        ref: '#/components/schemas/Organization',
        type: 'object',
        nullable: true,
    )]
    public object $organization;

    #[OA\Property(
        property: 'category',
        ref: '#/components/schemas/Category',
        type: 'object',
        nullable: true,
    )]
    public object $category;

    #[OA\Property(
        property: 'categories',
        type: 'array',
        nullable: true,
        items: new OA\Items(ref: '#/components/schemas/Category'),
    )]
    public ?array $categories = null;

    #[OA\Property(property: 'created_at', type: 'string', format: 'date-time', example: '2026-01-01T10:00:00.000000Z')]
    public string $created_at = '';

    #[OA\Property(property: 'updated_at', type: 'string', format: 'date-time', example: '2026-01-01T10:00:00.000000Z')]
    public string $updated_at = '';
}