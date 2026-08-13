<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'ResetPasswordRequest',
    title: 'Reset password request body',
    required: ['email', 'otp', 'password'],
)]
class ResetPasswordRequestSchema
{
    #[OA\Property(property: 'email', type: 'string', format: 'email', example: 'user@example.com')]
    public string $email = '';

    #[OA\Property(property: 'otp', type: 'string', example: '12345')]
    public string $otp = '';

    #[OA\Property(property: 'password', type: 'string', minLength: 8, example: 'newsecret123')]
    public string $password = '';
}