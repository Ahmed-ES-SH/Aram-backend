<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'User',
    title: 'User',
    description: 'User account entity (authenticates via Sanctum).',
    required: ['id', 'name'],
)]
class UserSchema
{
    #[OA\Property(property: 'id', type: 'integer', example: 1)]
    public int $id = 0;

    #[OA\Property(property: 'id_number', type: 'string', nullable: true, example: '123-xxx-xxx-xx')]
    public ?string $id_number = null;

    #[OA\Property(property: 'name', type: 'string', example: 'John Doe')]
    public string $name = '';

    #[OA\Property(property: 'email', type: 'string', format: 'email', example: 'user@example.com')]
    public string $email = '';

    #[OA\Property(property: 'role', type: 'string', nullable: true, example: 'user')]
    public ?string $role = null;

    #[OA\Property(property: 'status', type: 'string', nullable: true, example: 'active')]
    public ?string $status = null;

    #[OA\Property(property: 'failed_attempts', type: 'integer', nullable: true, example: 0)]
    public ?int $failed_attempts = null;

    #[OA\Property(property: 'last_login_at', type: 'string', format: 'date-time', nullable: true)]
    public ?string $last_login_at = null;

    #[OA\Property(property: 'account_type', type: 'string', nullable: true)]
    public ?string $account_type = null;

    #[OA\Property(property: 'image', type: 'string', nullable: true, example: 'images/users/abc.jpg')]
    public ?string $image = null;

    #[OA\Property(property: 'phone', type: 'string', nullable: true, example: '+966500000000')]
    public ?string $phone = null;

    #[OA\Property(property: 'country', type: 'string', nullable: true, example: 'SA')]
    public ?string $country = null;

    #[OA\Property(property: 'location', type: 'object', nullable: true, description: 'Location data (array cast).')]
    public ?object $location = null;

    #[OA\Property(property: 'gender', type: 'string', nullable: true, example: 'male')]
    public ?string $gender = null;

    #[OA\Property(property: 'birth_date', type: 'string', nullable: true, example: '1990-01-01')]
    public ?string $birth_date = null;

    #[OA\Property(property: 'social_id', type: 'string', nullable: true)]
    public ?string $social_id = null;

    #[OA\Property(property: 'social_type', type: 'string', nullable: true, example: 'google')]
    public ?string $social_type = null;

    #[OA\Property(property: 'is_signed', type: 'boolean', nullable: true, example: true)]
    public ?bool $is_signed = null;

    #[OA\Property(property: 'email_verified_at', type: 'string', format: 'date-time', nullable: true)]
    public ?string $email_verified_at = null;

    #[OA\Property(property: 'created_at', type: 'string', format: 'date-time', example: '2026-01-01T10:00:00.000000Z')]
    public string $created_at = '';

    #[OA\Property(property: 'updated_at', type: 'string', format: 'date-time', example: '2026-01-01T10:00:00.000000Z')]
    public string $updated_at = '';
}