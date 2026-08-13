<?php

namespace App\OpenApi\Responses;

use OpenApi\Attributes as OA;

/** 2xx — custom body schema (non-envelope shapes). */
class RefOkResponse extends OA\Response
{
    public function __construct(string $schema, int $status = 200, ?string $description = 'Success')
    {
        parent::__construct(
            response: $status,
            description: $description,
            content: new OA\JsonContent(ref: '#/components/schemas/' . $schema),
        );
    }
}
