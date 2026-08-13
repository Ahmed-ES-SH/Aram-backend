<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'ErrorResponse',
    title: 'Error response envelope',
    description: 'Error response for 401 / 403 / 500 responses.',
    required: ['message'],
)]
class ErrorResponseSchema
{
    #[OA\Property(property: 'message', type: 'string', example: 'Unauthorized')]
    public string $message = '';
}