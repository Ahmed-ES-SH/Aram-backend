<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'RegisterUserRequest',
    title: 'Register user request body',
    description: 'Posted as multipart/form-data when an image is included.',
)]
class RegisterUserRequestSchema
{
    #[OA\Property(property: 'id_number', type: 'string', description: 'Unique national ID.', example: '123456789')]
    public ?string $id_number = null;

    #[OA\Property(property: 'name', type: 'string', example: 'John Doe')]
    public string $name = '';

    #[OA\Property(property: 'email', type: 'string', format: 'email', example: 'user@example.com')]
    public string $email = '';

    #[OA\Property(property: 'password', type: 'string', format: 'password', example: 'secret123')]
    public string $password = '';

    #[OA\Property(property: 'phone', type: 'string', pattern: '^[0-9]{10,15}$', example: '0555000000')]
    public string $phone = '';

    #[OA\Property(property: 'country', type: 'string', nullable: true, example: 'SA')]
    public ?string $country = null;

    #[OA\Property(property: 'gender', type: 'string', enum: ['male', 'female'], example: 'male')]
    public string $gender = 'male';

    #[OA\Property(property: 'birth_date', type: 'string', format: 'date', example: '1990-01-01')]
    public string $birth_date = '';

    #[OA\Property(property: 'device_type', type: 'string', nullable: true, example: 'web')]
    public ?string $device_type = null;

    #[OA\Property(property: 'role', type: 'string', nullable: true, enum: ['admin', 'user', 'super_admin'], example: 'user')]
    public ?string $role = null;

    #[OA\Property(property: 'location', type: 'string', nullable: true, description: 'JSON-encoded location.')]
    public ?string $location = null;

    #[OA\Property(property: 'ref_code', type: 'string', nullable: true, description: 'Promoter referral code.')]
    public ?string $ref_code = null;

    #[OA\Property(property: 'image', type: 'string', format: 'binary', nullable: true, description: 'Profile image file.')]
    public ?string $image = null;
}