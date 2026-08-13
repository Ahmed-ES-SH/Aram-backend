<?php

namespace App\OpenApi\Responses;

use OpenApi\Attributes as OA;

/** Any other error status with the plain { message } body. */
class ErrorResponse extends OA\Response
{
    public function __construct(int $status, ?string $description)
    {
        parent::__construct(
            response: $status,
            description: $description,
            content: new OA\JsonContent(ref: '#/components/schemas/ErrorResponse'),
        );
    }
}
