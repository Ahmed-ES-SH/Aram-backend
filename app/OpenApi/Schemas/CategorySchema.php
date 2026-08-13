<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'Category',
    title: 'Category',
    description: 'Main category entity.',
    required: ['id', 'title_en', 'title_ar'],
)]
class CategorySchema
{
    #[OA\Property(property: 'id', type: 'integer', example: 1)]
    public int $id = 0;

    #[OA\Property(property: 'title_en', type: 'string', example: 'Health')]
    public string $title_en = '';

    #[OA\Property(property: 'title_ar', type: 'string', example: 'الصحة')]
    public string $title_ar = '';

    #[OA\Property(property: 'bg_color', type: 'string', example: '#4f46e5')]
    public string $bg_color = '';

    #[OA\Property(property: 'icon_name', type: 'string', example: 'heart')]
    public string $icon_name = '';

    #[OA\Property(property: 'is_active', type: 'boolean', example: true)]
    public bool $is_active = true;

    #[OA\Property(property: 'image', type: 'string', nullable: true, example: 'images/categories/abc.jpg')]
    public ?string $image = null;

    #[OA\Property(property: 'sub_categories_count', type: 'integer', nullable: true, example: 3)]
    public ?int $sub_categories_count = null;

    #[OA\Property(property: 'organizations_count', type: 'integer', nullable: true, example: 5)]
    public ?int $organizations_count = null;

    #[OA\Property(
        property: 'sub_categories',
        type: 'array',
        nullable: true,
        items: new OA\Items(ref: '#/components/schemas/SubCategory'),
    )]
    public ?array $sub_categories = null;

    #[OA\Property(
        property: 'organizations',
        type: 'array',
        nullable: true,
        items: new OA\Items(ref: '#/components/schemas/Organization'),
    )]
    public ?array $organizations = null;

    #[OA\Property(property: 'created_at', type: 'string', format: 'date-time', example: '2026-01-01T10:00:00.000000Z')]
    public string $created_at = '';

    #[OA\Property(property: 'updated_at', type: 'string', format: 'date-time', example: '2026-01-01T10:00:00.000000Z')]
    public string $updated_at = '';
}