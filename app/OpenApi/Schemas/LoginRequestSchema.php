<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'LoginRequest',
    title: 'Login request body',
    required: ['login', 'password'],
)]
class LoginRequestSchema
{
    #[OA\Property(property: 'login', type: 'string', description: 'Email or phone of the account.', example: 'user@example.com')]
    public string $login = '';

    #[OA\Property(property: 'password', type: 'string', format: 'password', example: 'secret123')]
    public string $password = '';
}