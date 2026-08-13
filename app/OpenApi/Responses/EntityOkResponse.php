<?php

namespace App\OpenApi\Responses;

use OpenApi\Attributes as OA;

/** 200 — standard envelope with a typed entity inside data. */
class EntityOkResponse extends OA\Response
{
    public function __construct(string $schema, ?string $description = 'Success')
    {
        parent::__construct(
            response: 200,
            description: $description,
            content: new OA\JsonContent(
                allOf: [
                    new OA\Schema(ref: '#/components/schemas/ApiResponse'),
                    new OA\Schema(
                        properties: [
                            new OA\Property(property: 'data', ref: '#/components/schemas/' . $schema),
                        ],
                    ),
                ],
            ),
        );
    }
}
