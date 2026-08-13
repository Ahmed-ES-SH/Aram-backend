<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'ValidationErrorResponse',
    title: 'Validation error response envelope',
    description: 'Response returned when request validation fails.',
    required: ['errors'],
)]
class ValidationErrorResponseSchema
{
    #[OA\Property(
        property: 'errors',
        type: 'object',
        description: 'Map of field name to the first validation message.',
        additionalProperties: new OA\AdditionalProperties(type: 'string', example: 'The title field is required.'),
    )]
    public array $errors = [];
}