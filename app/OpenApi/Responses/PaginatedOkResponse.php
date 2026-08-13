<?php

namespace App\OpenApi\Responses;

use OpenApi\Attributes as OA;

/** 200 — paginated envelope with typed items inside data. */
class PaginatedOkResponse extends OA\Response
{
    public function __construct(string $schema, ?string $description = 'Success')
    {
        parent::__construct(
            response: 200,
            description: $description,
            content: new OA\JsonContent(
                allOf: [
                    new OA\Schema(ref: '#/components/schemas/PaginationResponse'),
                    new OA\Schema(
                        properties: [
                            new OA\Property(
                                property: 'data',
                                type: 'array',
                                items: new OA\Items(ref: '#/components/schemas/' . $schema),
                            ),
                        ],
                    ),
                ],
            ),
        );
    }
}
