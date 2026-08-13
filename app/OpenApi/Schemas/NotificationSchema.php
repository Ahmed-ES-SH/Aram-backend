<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'Notification',
    title: 'Notification',
    description: 'Notification entity.',
    required: ['id'],
)]
class NotificationSchema
{
    #[OA\Property(property: 'id', type: 'integer', example: 1)]
    public int $id = 1;
    #[OA\Property(property: 'content', type: 'string', example: 'New booking request')]
    public string $content = '';
    #[OA\Property(property: 'sender_id', type: 'integer', example: 5)]
    public int $sender_id = 5;
    #[OA\Property(property: 'sender_type', type: 'string', enum: ['user', 'organization'])]
    public string $sender_type = 'user';
    #[OA\Property(property: 'recipient_id', type: 'integer', example: 2)]
    public int $recipient_id = 2;
    #[OA\Property(property: 'recipient_type', type: 'string', enum: ['user', 'organization'])]
    public string $recipient_type = 'organization';
    #[OA\Property(property: 'is_read', type: 'boolean', example: false)]
    public bool $is_read = false;
    #[OA\Property(property: 'created_at', type: 'string', example: '2026-01-01T10:00:00.000000Z')]
    public string $created_at = '';
}