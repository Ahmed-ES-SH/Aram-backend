<?php

namespace App\OpenApi\Responses;

use OpenApi\Attributes as OA;

/** 201 — standard envelope for created resources. */
class CreatedResponse extends OA\Response
{
    public function __construct(?string $description = 'Created')
    {
        parent::__construct(
            response: 201,
            description: $description,
            content: new OA\JsonContent(ref: '#/components/schemas/ApiResponse'),
        );
    }
}
