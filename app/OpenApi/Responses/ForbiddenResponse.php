<?php

namespace App\OpenApi\Responses;

use OpenApi\Attributes as OA;

/** 403 — admin role required. */
class ForbiddenResponse extends OA\Response
{
    public function __construct(?string $description = 'Forbidden — admin role required')
    {
        parent::__construct(
            response: 403,
            description: $description,
            content: new OA\JsonContent(ref: '#/components/schemas/ErrorResponse'),
        );
    }
}
