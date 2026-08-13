<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'VerifyOTPRequest',
    title: 'Verify OTP request body',
    required: ['email', 'otp'],
)]
class VerifyOTPRequestSchema
{
    #[OA\Property(property: 'email', type: 'string', format: 'email', example: 'user@example.com')]
    public string $email = '';

    #[OA\Property(property: 'otp', type: 'string', minLength: 5, maxLength: 5, example: '12345')]
    public string $otp = '';
}