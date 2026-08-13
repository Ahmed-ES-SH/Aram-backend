<?php

namespace App\OpenApi\Responses;

use OpenApi\Attributes as OA;

/** 200 — standard { data, message } envelope. */
class OkResponse extends OA\Response
{
    public function __construct(?string $description = 'Success')
    {
        parent::__construct(
            response: 200,
            description: $description,
            content: new OA\JsonContent(ref: '#/components/schemas/ApiResponse'),
        );
    }
}
