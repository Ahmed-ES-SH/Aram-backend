<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'UpdateUserRequest',
    title: 'Update user request body',
    description: 'All fields optional; partial update. Posted as multipart/form-data when an image is included.',
)]
class UpdateUserRequestSchema
{
    #[OA\Property(property: 'name', type: 'string', example: 'John Doe')]
    public ?string $name = null;

    #[OA\Property(property: 'email', type: 'string', format: 'email', example: 'user@example.com')]
    public ?string $email = null;

    #[OA\Property(property: 'password', type: 'string', format: 'password', example: 'newsecret123')]
    public ?string $password = null;

    #[OA\Property(property: 'phone', type: 'string', pattern: '^[0-9]{10,15}$', example: '0555000000')]
    public ?string $phone = null;

    #[OA\Property(property: 'country', type: 'string', nullable: true, example: 'SA')]
    public ?string $country = null;

    #[OA\Property(property: 'gender', type: 'string', enum: ['male', 'female'], example: 'male')]
    public ?string $gender = null;

    #[OA\Property(property: 'birth_date', type: 'string', format: 'date', example: '1990-01-01')]
    public ?string $birth_date = null;

    #[OA\Property(property: 'role', type: 'string', enum: ['admin', 'user'], example: 'user')]
    public ?string $role = null;

    #[OA\Property(property: 'status', type: 'string', enum: ['active', 'inactive', 'banned'], example: 'active')]
    public ?string $status = null;

    #[OA\Property(property: 'location', type: 'string', nullable: true, description: 'JSON-encoded location.')]
    public ?string $location = null;

    #[OA\Property(property: 'image', type: 'string', format: 'binary', nullable: true, description: 'Profile image file.')]
    public ?string $image = null;
}