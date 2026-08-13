<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'ServicePage',
    title: 'Service page',
    description: 'Service page (card/list summary).',
    required: ['id'],
)]
class ServicePageSchema
{
    #[OA\Property(property: 'id', type: 'integer', example: 1)]
    public int $id = 1;
    #[OA\Property(property: 'slug', type: 'string', example: 'loyalty-card')]
    public string $slug = '';
    #[OA\Property(property: 'title', type: 'string', example: 'Loyalty Card Service')]
    public string $title = '';
    #[OA\Property(property: 'type', type: 'string', example: 'service')]
    public string $type = '';
    #[OA\Property(property: 'status', type: 'string', example: 'active')]
    public string $status = '';
    #[OA\Property(property: 'is_active', type: 'boolean', example: True)]
    public bool $is_active = True;
    #[OA\Property(property: 'created_at', type: 'string', example: '2026-01-01T10:00:00.000000Z')]
    public string $created_at = '';
    #[OA\Property(property: 'updated_at', type: 'string', example: '2026-01-01T10:00:00.000000Z')]
    public string $updated_at = '';
}
