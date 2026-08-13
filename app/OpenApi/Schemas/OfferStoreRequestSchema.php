<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'OfferStoreRequest',
    title: 'Offer Store/Update Request',
    description: 'Payload for creating or updating an offer (multipart/form-data).',
)]
class OfferStoreRequestSchema
{
    #[OA\Property(property: 'title', type: 'string', maxLength: 255, example: 'Summer Sale')]
    public string $title = '';

    #[OA\Property(property: 'description', type: 'string', nullable: true, example: 'Get 30% off on all services.')]
    public ?string $description = null;

    #[OA\Property(property: 'image', type: 'string', format: 'binary', description: 'Image file (jpg, jpeg, png, webp, max 2048 KB).')]
    public string $image = '';

    #[OA\Property(property: 'discount_type', type: 'string', enum: ['percentage', 'fixed'], example: 'percentage')]
    public string $discount_type = '';

    #[OA\Property(property: 'discount_value', type: 'number', format: 'float', example: 30.0)]
    public float $discount_value = 0;

    #[OA\Property(property: 'usage_limit', type: 'integer', nullable: true, example: 100)]
    public ?int $usage_limit = null;

    #[OA\Property(property: 'per_user_limit', type: 'integer', nullable: true, example: 1)]
    public ?int $per_user_limit = null;

    #[OA\Property(property: 'number_of_uses', type: 'integer', nullable: true, example: 0)]
    public ?int $number_of_uses = null;

    #[OA\Property(property: 'start_date', type: 'string', format: 'date', example: '2026-01-01')]
    public string $start_date = '';

    #[OA\Property(property: 'end_date', type: 'string', format: 'date', nullable: true, example: '2026-02-01')]
    public ?string $end_date = null;

    #[OA\Property(property: 'status', type: 'string', enum: ['waiting', 'active', 'expired'], nullable: true, example: 'active')]
    public ?string $status = null;

    #[OA\Property(property: 'organization_id', type: 'integer', example: 1)]
    public int $organization_id = 0;

    #[OA\Property(property: 'category_id', type: 'integer', example: 1)]
    public int $category_id = 0;

    #[OA\Property(
        property: 'categories',
        type: 'array',
        description: 'JSON encoded array of category ids.',
        items: new OA\Items(type: 'integer'),
    )]
    public array $categories = [];

    #[OA\Property(property: 'code', type: 'string', maxLength: 50, nullable: true, example: 'SUMMER30')]
    public ?string $code = null;
}