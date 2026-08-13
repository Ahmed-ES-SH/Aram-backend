<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'StatusMessageResponse',
    title: 'Status + message response body',
    description: '{ status, message } body used by several endpoints.',
    required: ['status', 'message'],
)]
class StatusMessageResponseSchema
{
    #[OA\Property(property: 'status', type: 'boolean', example: true)]
    public bool $status = true;

    #[OA\Property(property: 'message', type: 'string', example: 'Password has been reset successfully')]
    public string $message = '';
}