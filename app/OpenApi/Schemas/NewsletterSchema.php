<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'Newsletter',
    title: 'Newsletter',
    description: 'Newsletter entity.',
    required: ['id'],
)]
class NewsletterSchema
{
    #[OA\Property(property: 'id', type: 'integer', example: 1)]
    public int $id = 1;
    #[OA\Property(property: 'subject', type: 'string', example: 'Monthly offers')]
    public string $subject = '';
    #[OA\Property(property: 'created_at', type: 'string', example: '2026-01-01T10:00:00.000000Z')]
    public string $created_at = '';
    #[OA\Property(property: 'updated_at', type: 'string', example: '2026-01-01T10:00:00.000000Z')]
    public string $updated_at = '';
}
