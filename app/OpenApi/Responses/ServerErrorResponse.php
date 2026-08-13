<?php

namespace App\OpenApi\Responses;

use OpenApi\Attributes as OA;

/** 500 — server error. */
class ServerErrorResponse extends OA\Response
{
    public function __construct(?string $description = 'Server error')
    {
        parent::__construct(
            response: 500,
            description: $description,
            content: new OA\JsonContent(ref: '#/components/schemas/ErrorResponse'),
        );
    }
}
