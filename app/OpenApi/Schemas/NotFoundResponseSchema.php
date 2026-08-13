<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'NotFoundResponse',
    title: 'Not found response envelope',
    description: 'Response returned when the requested resource does not exist.',
    required: ['status', 'message'],
)]
class NotFoundResponseSchema
{
    #[OA\Property(property: 'status', type: 'boolean', example: false)]
    public bool $status = false;

    #[OA\Property(property: 'message', type: 'string', example: 'Resource not found')]
    public string $message = '';
}