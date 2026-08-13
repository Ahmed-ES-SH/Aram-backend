<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'SendOTPRequest',
    title: 'Send OTP request body',
    required: ['email'],
)]
class SendOTPRequestSchema
{
    #[OA\Property(property: 'email', type: 'string', format: 'email', example: 'user@example.com')]
    public string $email = '';
}