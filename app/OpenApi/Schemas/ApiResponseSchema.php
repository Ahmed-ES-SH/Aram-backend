<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'ApiResponse',
    title: 'API response envelope',
    description: 'Standard success response envelope, see the ApiResponse trait.',
    required: ['data', 'message'],
)]
class ApiResponseSchema
{
    #[OA\Property(
        property: 'data',
        description: 'Endpoint-specific payload.',
        additionalProperties: true,
    )]
    public array $data = [];

    #[OA\Property(property: 'message', type: 'string', example: 'Data Found Successfully')]
    public string $message = '';
}