<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'ContactMessage',
    title: 'Contact message',
    description: 'Contact message entity.',
    required: ['id'],
)]
class ContactMessageSchema
{
    #[OA\Property(property: 'id', type: 'integer', example: 1)]
    public int $id = 1;
    #[OA\Property(property: 'name', type: 'string', example: 'John Doe')]
    public string $name = '';
    #[OA\Property(property: 'email', type: 'string', example: 'user@example.com')]
    public string $email = '';
    #[OA\Property(property: 'message', type: 'string', example: 'Hello there')]
    public string $message = '';
    #[OA\Property(property: 'status', type: 'string', example: 'new')]
    public string $status = '';
    #[OA\Property(property: 'created_at', type: 'string', example: '2026-01-01T10:00:00.000000Z')]
    public string $created_at = '';
    #[OA\Property(property: 'updated_at', type: 'string', example: '2026-01-01T10:00:00.000000Z')]
    public string $updated_at = '';
}
