<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'ArticleComment',
    title: 'ArticleComment',
    description: 'Article comment entity.',
    required: ['id'],
)]
class ArticleCommentSchema
{
    #[OA\Property(property: 'id', type: 'integer', example: 1)]
    public int $id = 1;
    #[OA\Property(property: 'article_id', type: 'integer', example: 4)]
    public int $article_id = 4;
    #[OA\Property(property: 'user_id', type: 'integer', example: 5)]
    public int $user_id = 5;
    #[OA\Property(property: 'parent_id', type: 'integer', nullable: true, example: 2)]
    public ?int $parent_id = null;
    #[OA\Property(property: 'content', type: 'string', example: 'Great article!')]
    public string $content = '';
    #[OA\Property(property: 'created_at', type: 'string', example: '2026-01-01T10:00:00.000000Z')]
    public string $created_at = '';
}