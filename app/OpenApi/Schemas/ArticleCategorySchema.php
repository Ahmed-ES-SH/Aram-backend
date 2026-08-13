<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'ArticleCategory',
    title: 'Article category',
    description: 'Category that groups articles.',
    required: ['id', 'title_en', 'title_ar'],
)]
class ArticleCategorySchema
{
    #[OA\Property(property: 'id', type: 'integer', example: 1)]
    public int $id = 0;

    #[OA\Property(property: 'title_en', type: 'string', example: 'News')]
    public string $title_en = '';

    #[OA\Property(property: 'title_ar', type: 'string', example: 'أخبار')]
    public string $title_ar = '';

    #[OA\Property(property: 'image', type: 'string', nullable: true, example: 'images/articlecategories/abc.jpg')]
    public ?string $image = null;

    #[OA\Property(property: 'icon_name', type: 'string', example: 'newspaper')]
    public string $icon_name = '';

    #[OA\Property(property: 'bg_color', type: 'string', example: '#4f46e5')]
    public string $bg_color = '';

    #[OA\Property(property: 'created_at', type: 'string', format: 'date-time', example: '2026-01-01T10:00:00.000000Z')]
    public string $created_at = '';

    #[OA\Property(property: 'updated_at', type: 'string', format: 'date-time', example: '2026-01-01T10:00:00.000000Z')]
    public string $updated_at = '';
}