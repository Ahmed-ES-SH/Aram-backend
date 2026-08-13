<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'ArticleStoreRequest',
    title: 'Article Store/Update Request',
    description: 'Payload for creating or updating an article (multipart/form-data).',
)]
class ArticleStoreRequestSchema
{
    #[OA\Property(property: 'title_en', type: 'string', maxLength: 255, example: 'Top 10 Offers')]
    public string $title_en = '';

    #[OA\Property(property: 'title_ar', type: 'string', maxLength: 255, example: 'أفضل 10 عروض')]
    public string $title_ar = '';

    #[OA\Property(property: 'content_en', type: 'string', example: 'Article body in English.')]
    public string $content_en = '';

    #[OA\Property(property: 'content_ar', type: 'string', example: 'نص المقال بالعربية.')]
    public string $content_ar = '';

    #[OA\Property(property: 'image', type: 'string', format: 'binary', description: 'Image file (max 40960 KB).')]
    public string $image = '';

    #[OA\Property(property: 'status', type: 'string', enum: ['draft', 'published', 'archived'], example: 'published')]
    public string $status = '';

    #[OA\Property(property: 'category_id', type: 'integer', example: 1)]
    public int $category_id = 0;

    #[OA\Property(property: 'author_id', type: 'integer', example: 1)]
    public int $author_id = 0;
}