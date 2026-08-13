<?php

namespace App\OpenApi\Responses;

use OpenApi\Attributes as OA;

/** 404 — { status, message } not found body. */
class NotFoundResponse extends OA\Response
{
    public function __construct(?string $description = 'Resource not found')
    {
        parent::__construct(
            response: 404,
            description: $description,
            content: new OA\JsonContent(ref: '#/components/schemas/NotFoundResponse'),
        );
    }
}
