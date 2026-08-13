<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'Card',
    title: 'Card',
    description: 'Loyalty card entity.',
    required: ['id', 'title'],
)]
class CardSchema
{
    #[OA\Property(property: 'id', type: 'integer', example: 1)]
    public int $id = 0;

    #[OA\Property(property: 'title', type: 'string', example: 'Silver Membership')]
    public string $title = '';

    #[OA\Property(property: 'description', type: 'string', example: 'Annual membership with discounts.')]
    public string $description = '';

    #[OA\Property(property: 'price_before_discount', type: 'number', format: 'float', nullable: true, example: 1200.0)]
    public ?float $price_before_discount = null;

    #[OA\Property(property: 'price', type: 'number', format: 'float', example: 999.0)]
    public float $price = 0;

    #[OA\Property(property: 'number_of_promotional_purchases', type: 'integer', example: 5)]
    public int $number_of_promotional_purchases = 0;

    #[OA\Property(property: 'duration', type: 'string', nullable: true, example: '1 year')]
    public ?string $duration = null;

    #[OA\Property(property: 'image', type: 'string', nullable: true, example: 'images/cards/abc.jpg')]
    public ?string $image = null;

    #[OA\Property(property: 'order', type: 'integer', example: 1)]
    public int $order = 0;

    #[OA\Property(property: 'active', type: 'boolean', example: true)]
    public bool $active = true;

    #[OA\Property(property: 'category_id', type: 'integer', nullable: true, example: 1)]
    public ?int $category_id = null;

    #[OA\Property(property: 'keywords_count', type: 'integer', nullable: true, example: 2)]
    public ?int $keywords_count = null;

    #[OA\Property(property: 'benefits_count', type: 'integer', nullable: true, example: 3)]
    public ?int $benefits_count = null;

    #[OA\Property(
        property: 'category',
        ref: '#/components/schemas/CardCategory',
        type: 'object',
        nullable: true,
    )]
    public object $category;

    #[OA\Property(
        property: 'keywords',
        type: 'array',
        nullable: true,
        items: new OA\Items(ref: '#/components/schemas/Keyword'),
    )]
    public ?array $keywords = null;

    #[OA\Property(
        property: 'benefits',
        type: 'array',
        nullable: true,
        items: new OA\Items(additionalProperties: true),
    )]
    public ?array $benefits = null;

    #[OA\Property(property: 'created_at', type: 'string', format: 'date-time', example: '2026-01-01T10:00:00.000000Z')]
    public string $created_at = '';

    #[OA\Property(property: 'updated_at', type: 'string', format: 'date-time', example: '2026-01-01T10:00:00.000000Z')]
    public string $updated_at = '';
}