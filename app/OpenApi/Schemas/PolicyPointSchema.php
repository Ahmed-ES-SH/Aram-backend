<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'PolicyPoint',
    title: 'Policy Point',
    description: 'A bilingual policy/terms point (privacy policy or terms conditions).',
    required: ['id'],
)]
class PolicyPointSchema
{
    #[OA\Property(property: 'id', type: 'integer', example: 1)]
    public int $id = 0;

    #[OA\Property(property: 'content_en', type: 'string', example: 'We do not share your data.')]
    public string $content_en = '';

    #[OA\Property(property: 'content_ar', type: 'string', example: 'نحن لا نشارك بياناتك.')]
    public string $content_ar = '';

    #[OA\Property(property: 'created_at', type: 'string', format: 'date-time', example: '2026-01-01T10:00:00.000000Z')]
    public string $created_at = '';

    #[OA\Property(property: 'updated_at', type: 'string', format: 'date-time', example: '2026-01-01T10:00:00.000000Z')]
    public string $updated_at = '';
}