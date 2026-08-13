<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'CurrentUserResponse',
    title: 'Current user response body',
    description: 'Body returned by GET /current-user (not the standard envelope).',
    required: ['data', 'type'],
)]
class CurrentUserResponseSchema
{
    #[OA\Property(
        property: 'data',
        oneOf: [
            new OA\Schema(ref: '#/components/schemas/User'),
            new OA\Schema(ref: '#/components/schemas/Organization'),
        ],
    )]
    public object $data;

    #[OA\Property(property: 'unread_count', type: 'integer', example: 2)]
    public int $unread_count = 0;

    #[OA\Property(property: 'unread_notifications_count', type: 'integer', example: 3)]
    public int $unread_notifications_count = 0;

    #[OA\Property(property: 'type', type: 'string', enum: ['user', 'organization'], example: 'user')]
    public string $type = 'user';

    #[OA\Property(property: 'is_promoter', type: 'boolean', example: false)]
    public bool $is_promoter = false;
}