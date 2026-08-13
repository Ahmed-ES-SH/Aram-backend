<?php

namespace App\OpenApi\Responses;

use OpenApi\Attributes as OA;

/** 422 — { errors } validation body. */
class UnprocessableResponse extends OA\Response
{
    public function __construct(?string $description = 'Validation failed')
    {
        parent::__construct(
            response: 422,
            description: $description,
            content: new OA\JsonContent(ref: '#/components/schemas/ValidationErrorResponse'),
        );
    }
}
