<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'CardCategory',
    title: 'Card category',
    description: 'Category that groups loyalty cards.',
    required: ['id', 'title_en', 'title_ar'],
)]
class CardCategorySchema
{
    #[OA\Property(property: 'id', type: 'integer', example: 1)]
    public int $id = 0;

    #[OA\Property(property: 'title_en', type: 'string', example: 'Memberships')]
    public string $title_en = '';

    #[OA\Property(property: 'title_ar', type: 'string', example: 'العضويات')]
    public string $title_ar = '';

    #[OA\Property(property: 'bg_color', type: 'string', example: '#4f46e5')]
    public string $bg_color = '';

    #[OA\Property(property: 'icon_name', type: 'string', example: 'card')]
    public string $icon_name = '';

    #[OA\Property(property: 'is_active', type: 'boolean', example: true)]
    public bool $is_active = true;

    #[OA\Property(property: 'image', type: 'string', nullable: true, example: 'images/cardcategories/abc.jpg')]
    public ?string $image = null;

    #[OA\Property(property: 'cards_count', type: 'integer', nullable: true, example: 4)]
    public ?int $cards_count = null;

    #[OA\Property(
        property: 'cards',
        type: 'array',
        nullable: true,
        items: new OA\Items(ref: '#/components/schemas/Card'),
    )]
    public ?array $cards = null;

    #[OA\Property(property: 'created_at', type: 'string', format: 'date-time', example: '2026-01-01T10:00:00.000000Z')]
    public string $created_at = '';

    #[OA\Property(property: 'updated_at', type: 'string', format: 'date-time', example: '2026-01-01T10:00:00.000000Z')]
    public string $updated_at = '';
}