<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'SubCategory',
    title: 'Sub category',
    description: 'Sub category entity linked to a main category.',
    required: ['id', 'title_en', 'title_ar', 'parent_id'],
)]
class SubCategorySchema
{
    #[OA\Property(property: 'id', type: 'integer', example: 1)]
    public int $id = 0;

    #[OA\Property(property: 'title_en', type: 'string', example: 'Dentistry')]
    public string $title_en = '';

    #[OA\Property(property: 'title_ar', type: 'string', example: 'طب الأسنان')]
    public string $title_ar = '';

    #[OA\Property(property: 'bg_color', type: 'string', example: '#4f46e5')]
    public string $bg_color = '';

    #[OA\Property(property: 'icon_name', type: 'string', example: 'tooth')]
    public string $icon_name = '';

    #[OA\Property(property: 'image', type: 'string', nullable: true, example: 'images/subcategories/abc.jpg')]
    public ?string $image = null;

    #[OA\Property(property: 'is_active', type: 'boolean', example: true)]
    public bool $is_active = true;

    #[OA\Property(property: 'parent_id', type: 'integer', example: 1)]
    public int $parent_id = 0;

    #[OA\Property(property: 'organizations_count', type: 'integer', nullable: true, example: 2)]
    public ?int $organizations_count = null;

    #[OA\Property(
        property: 'parent',
        ref: '#/components/schemas/Category',
        type: 'object',
        nullable: true,
    )]
    public object $parent;

    #[OA\Property(property: 'created_at', type: 'string', format: 'date-time', example: '2026-01-01T10:00:00.000000Z')]
    public string $created_at = '';

    #[OA\Property(property: 'updated_at', type: 'string', format: 'date-time', example: '2026-01-01T10:00:00.000000Z')]
    public string $updated_at = '';
}