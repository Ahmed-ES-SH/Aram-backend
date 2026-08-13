<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'CardStoreRequest',
    title: 'Card Store/Update Request',
    description: 'Payload for creating or updating a card (multipart/form-data).',
)]
class CardStoreRequestSchema
{
    #[OA\Property(property: 'title', type: 'string', maxLength: 255, example: 'Silver Membership')]
    public string $title = '';

    #[OA\Property(property: 'description', type: 'string', example: 'Annual membership with discounts.')]
    public string $description = '';

    #[OA\Property(property: 'price_before_discount', type: 'number', format: 'float', nullable: true, example: 1200.0)]
    public ?float $price_before_discount = null;

    #[OA\Property(property: 'price', type: 'number', format: 'float', example: 999.0)]
    public float $price = 0;

    #[OA\Property(property: 'duration', type: 'integer', example: 365)]
    public int $duration = 0;

    #[OA\Property(property: 'image', type: 'string', format: 'binary', description: 'Image file (jpg, jpeg, png, webp, max 5048 KB).')]
    public string $image = '';

    #[OA\Property(property: 'active', type: 'boolean', example: true)]
    public bool $active = true;

    #[OA\Property(property: 'order', type: 'integer', nullable: true, example: 1)]
    public ?int $order = null;

    #[OA\Property(property: 'category_id', type: 'integer', example: 1)]
    public int $category_id = 0;

    #[OA\Property(
        property: 'benefits',
        type: 'array',
        nullable: true,
        items: new OA\Items(
            properties: [
                new OA\Property(property: 'title', type: 'string', example: 'Free delivery'),
            ],
            type: 'object',
        ),
    )]
    public ?array $benefits = null;

    #[OA\Property(
        property: 'keywords',
        type: 'array',
        nullable: true,
        description: 'Array of keyword ids to attach to the card.',
        items: new OA\Items(
            properties: [
                new OA\Property(property: 'keyword_id', type: 'integer', example: 1),
            ],
            type: 'object',
        ),
    )]
    public ?array $keywords = null;
}