<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'PaginationResponse',
    title: 'Pagination response envelope',
    description: 'Paginated success response envelope, see the ApiResponse trait.',
    required: ['data', 'pagination', 'message'],
)]
class PaginationResponseSchema
{
    #[OA\Property(
        property: 'data',
        type: 'array',
        description: 'Current page items.',
        items: new OA\Items(additionalProperties: true),
    )]
    public array $data = [];

    #[OA\Property(
        property: 'pagination',
        type: 'object',
        required: ['total', 'per_page', 'current_page', 'last_page', 'next_page_url', 'prev_page_url'],
        properties: [
            new OA\Property(property: 'total', type: 'integer', example: 100),
            new OA\Property(property: 'per_page', type: 'integer', example: 15),
            new OA\Property(property: 'current_page', type: 'integer', example: 1),
            new OA\Property(property: 'last_page', type: 'integer', example: 7),
            new OA\Property(property: 'next_page_url', type: 'string', nullable: true, example: null),
            new OA\Property(property: 'prev_page_url', type: 'string', nullable: true, example: null),
        ],
    )]
    public array $pagination = [];

    #[OA\Property(property: 'message', type: 'string', example: '')]
    public string $message = '';
}