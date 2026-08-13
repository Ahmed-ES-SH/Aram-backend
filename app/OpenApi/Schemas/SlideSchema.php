<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'Slide',
    title: 'Slide',
    description: 'Homepage slide entity.',
    required: ['id'],
)]
class SlideSchema
{
    #[OA\Property(property: 'id', type: 'integer', example: 1)]
    public int $id = 1;
    #[OA\Property(property: 'title', type: 'string', example: '{"en": "Welcome", "ar": "أهلا"}')]
    public string $title = '';
    #[OA\Property(property: 'description', type: 'string', example: '{"en": "Description", "ar": "الوصف"}')]
    public string $description = '';
    #[OA\Property(property: 'image', type: 'string', example: 'images/slides/abc.jpg')]
    public string $image = '';
    #[OA\Property(property: 'status', type: 'string', example: 'active')]
    public string $status = '';
    #[OA\Property(property: 'created_at', type: 'string', example: '2026-01-01T10:00:00.000000Z')]
    public string $created_at = '';
    #[OA\Property(property: 'updated_at', type: 'string', example: '2026-01-01T10:00:00.000000Z')]
    public string $updated_at = '';
}
