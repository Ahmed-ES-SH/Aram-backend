<?php

namespace App\OpenApi\Responses;

use OpenApi\Attributes as OA;

/** 401 — unauthenticated. */
class UnauthorizedResponse extends OA\Response
{
    public function __construct(?string $description = 'Unauthenticated')
    {
        parent::__construct(
            response: 401,
            description: $description,
            content: new OA\JsonContent(ref: '#/components/schemas/ErrorResponse'),
        );
    }
}
