<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'Article',
    title: 'Article',
    description: 'Article entity.',
    required: ['id', 'title_en', 'title_ar'],
)]
class ArticleSchema
{
    #[OA\Property(property: 'id', type: 'integer', example: 1)]
    public int $id = 0;

    #[OA\Property(property: 'title_en', type: 'string', example: 'Top 10 Offers')]
    public string $title_en = '';

    #[OA\Property(property: 'title_ar', type: 'string', example: 'أفضل 10 عروض')]
    public string $title_ar = '';

    #[OA\Property(property: 'content_en', type: 'string', example: 'Article body in English.')]
    public string $content_en = '';

    #[OA\Property(property: 'content_ar', type: 'string', example: 'نص المقال بالعربية.')]
    public string $content_ar = '';

    #[OA\Property(property: 'image', type: 'string', nullable: true, example: 'images/articles/abc.jpg')]
    public ?string $image = null;

    #[OA\Property(property: 'status', type: 'string', enum: ['draft', 'published', 'archived'], example: 'published')]
    public string $status = '';

    #[OA\Property(property: 'views', type: 'integer', example: 120)]
    public int $views = 0;

    #[OA\Property(property: 'category_id', type: 'integer', nullable: true, example: 1)]
    public ?int $category_id = null;

    #[OA\Property(property: 'author_id', type: 'integer', nullable: true, example: 1)]
    public ?int $author_id = null;

    #[OA\Property(
        property: 'category',
        ref: '#/components/schemas/ArticleCategory',
        type: 'object',
        nullable: true,
    )]
    public object $category;

    #[OA\Property(
        property: 'author',
        ref: '#/components/schemas/User',
        type: 'object',
        nullable: true,
    )]
    public object $author;

    #[OA\Property(
        property: 'tags',
        type: 'array',
        nullable: true,
        items: new OA\Items(ref: '#/components/schemas/Tag'),
    )]
    public ?array $tags = null;

    #[OA\Property(property: 'comments_count', type: 'integer', nullable: true, example: 3)]
    public ?int $comments_count = null;

    #[OA\Property(property: 'tags_count', type: 'integer', nullable: true, example: 2)]
    public ?int $tags_count = null;

    #[OA\Property(property: 'created_at', type: 'string', format: 'date-time', example: '2026-01-01T10:00:00.000000Z')]
    public string $created_at = '';

    #[OA\Property(property: 'updated_at', type: 'string', format: 'date-time', example: '2026-01-01T10:00:00.000000Z')]
    public string $updated_at = '';
}