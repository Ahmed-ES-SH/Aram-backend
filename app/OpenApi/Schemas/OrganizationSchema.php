<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'Organization',
    title: 'Organization',
    description: 'Organization account entity (also authenticates via Sanctum).',
    required: ['id', 'email', 'title'],
)]
class OrganizationSchema
{
    #[OA\Property(property: 'id', type: 'integer', example: 1)]
    public int $id = 0;

    #[OA\Property(property: 'email', type: 'string', format: 'email', example: 'org@example.com')]
    public string $email = '';

    #[OA\Property(property: 'title', type: 'string', example: 'Aram Center')]
    public string $title = '';

    #[OA\Property(property: 'description', type: 'string', nullable: true, example: 'A leading service center.')]
    public ?string $description = null;

    #[OA\Property(property: 'location', type: 'object', nullable: true, description: 'Location data (address).')]
    public ?object $location = null;

    #[OA\Property(property: 'features', type: 'string', nullable: true)]
    public ?string $features = null;

    #[OA\Property(property: 'accaptable_message', type: 'string', nullable: true)]
    public ?string $accaptable_message = null;

    #[OA\Property(property: 'unaccaptable_message', type: 'string', nullable: true)]
    public ?string $unaccaptable_message = null;

    #[OA\Property(property: 'confirmation_price', type: 'number', format: 'float', nullable: true)]
    public ?float $confirmation_price = null;

    #[OA\Property(property: 'confirmation_status', type: 'boolean', nullable: true)]
    public ?bool $confirmation_status = null;

    #[OA\Property(property: 'phone_number', type: 'string', nullable: true, example: '+966500000000')]
    public ?string $phone_number = null;

    #[OA\Property(property: 'open_at', type: 'string', nullable: true, example: '09:00')]
    public ?string $open_at = null;

    #[OA\Property(property: 'close_at', type: 'string', nullable: true, example: '18:00')]
    public ?string $close_at = null;

    #[OA\Property(property: 'url', type: 'string', nullable: true)]
    public ?string $url = null;

    #[OA\Property(property: 'email_verified', type: 'boolean', nullable: true)]
    public ?bool $email_verified = null;

    #[OA\Property(property: 'email_verified_at', type: 'string', format: 'date-time', nullable: true)]
    public ?string $email_verified_at = null;

    #[OA\Property(property: 'rating', type: 'number', format: 'float', nullable: true, example: 4.5)]
    public ?float $rating = null;

    #[OA\Property(property: 'status', type: 'string', nullable: true, example: 'pending')]
    public ?string $status = null;

    #[OA\Property(property: 'order', type: 'integer', nullable: true)]
    public ?int $order = null;

    #[OA\Property(property: 'image', type: 'string', nullable: true)]
    public ?string $image = null;

    #[OA\Property(property: 'logo', type: 'string', nullable: true)]
    public ?string $logo = null;

    #[OA\Property(property: 'booking_status', type: 'boolean', nullable: true)]
    public ?bool $booking_status = null;

    #[OA\Property(property: 'is_signed', type: 'boolean', nullable: true)]
    public ?bool $is_signed = null;

    #[OA\Property(property: 'number_of_reservations', type: 'integer', nullable: true)]
    public ?int $number_of_reservations = null;

    #[OA\Property(property: 'account_type', type: 'string', nullable: true)]
    public ?string $account_type = null;

    #[OA\Property(property: 'cooperation_file', type: 'string', nullable: true)]
    public ?string $cooperation_file = null;

    #[OA\Property(property: 'active', type: 'boolean', nullable: true, example: true)]
    public ?bool $active = null;

    #[OA\Property(
        property: 'categories',
        type: 'array',
        nullable: true,
        items: new OA\Items(ref: '#/components/schemas/Category'),
    )]
    public ?array $categories = null;

    #[OA\Property(
        property: 'subCategories',
        type: 'array',
        nullable: true,
        items: new OA\Items(ref: '#/components/schemas/SubCategory'),
    )]
    public ?array $subCategories = null;

    #[OA\Property(
        property: 'keywords',
        type: 'array',
        nullable: true,
        items: new OA\Items(ref: '#/components/schemas/Keyword'),
    )]
    public ?array $keywords = null;

    #[OA\Property(
        property: 'benefits',
        type: 'array',
        nullable: true,
        items: new OA\Items(additionalProperties: true),
    )]
    public ?array $benefits = null;

    #[OA\Property(property: 'created_at', type: 'string', format: 'date-time', example: '2026-01-01T10:00:00.000000Z')]
    public string $created_at = '';

    #[OA\Property(property: 'updated_at', type: 'string', format: 'date-time', example: '2026-01-01T10:00:00.000000Z')]
    public string $updated_at = '';
}