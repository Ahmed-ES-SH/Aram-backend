<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'LoginResponse',
    title: 'Login response body',
    description: 'Body returned by POST /login (not the standard envelope).',
    required: ['message', 'account', 'token', 'type'],
)]
class LoginResponseSchema
{
    #[OA\Property(property: 'message', type: 'string', example: 'User login successful')]
    public string $message = '';

    #[OA\Property(
        property: 'account',
        oneOf: [
            new OA\Schema(ref: '#/components/schemas/User'),
            new OA\Schema(ref: '#/components/schemas/Organization'),
        ],
    )]
    public object $account;

    #[OA\Property(property: 'unread_count', type: 'integer', example: 2)]
    public int $unread_count = 0;

    #[OA\Property(property: 'unread_notifications_count', type: 'integer', example: 3)]
    public int $unread_notifications_count = 0;

    #[OA\Property(
        property: 'notifications',
        type: 'array',
        items: new OA\Items(additionalProperties: true),
    )]
    public array $notifications = [];

    #[OA\Property(property: 'token', type: 'string', example: '1|abcdef123456token')]
    public string $token = '';

    #[OA\Property(property: 'type', type: 'string', enum: ['user', 'organization'], example: 'user')]
    public string $type = 'user';

    #[OA\Property(property: 'data', type: 'boolean', example: true)]
    public bool $data = true;
}