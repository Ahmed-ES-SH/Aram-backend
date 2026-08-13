<?php

namespace App\OpenApi\Responses;

use OpenApi\Attributes as OA;

/** 204 — empty no-content body. */
class NoContentResponse extends OA\Response
{
    public function __construct(?string $description = 'No content')
    {
        parent::__construct(
            response: 204,
            description: $description,
        );
    }
}