<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'FooterLink',
    title: 'Footer link',
    description: 'Footer link entity.',
    required: ['id'],
)]
class FooterLinkSchema
{
    #[OA\Property(property: 'id', type: 'integer', example: 1)]
    public int $id = 1;
    #[OA\Property(property: 'title', type: 'string', example: 'About Us')]
    public string $title = '';
    #[OA\Property(property: 'url', type: 'string', example: '/about')]
    public string $url = '';
    #[OA\Property(property: 'created_at', type: 'string', example: '2026-01-01T10:00:00.000000Z')]
    public string $created_at = '';
    #[OA\Property(property: 'updated_at', type: 'string', example: '2026-01-01T10:00:00.000000Z')]
    public string $updated_at = '';
}
