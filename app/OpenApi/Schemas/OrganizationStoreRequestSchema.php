<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'OrganizationStoreRequest',
    title: 'Store organization request body',
    description: 'Posted as multipart/form-data with image and logo files. Arrays (categories, sub_categories, keywords, benefits) may be JSON-encoded strings.',
)]
class OrganizationStoreRequestSchema
{
    #[OA\Property(property: 'email', type: 'string', format: 'email', example: 'org@example.com')]
    public string $email = '';

    #[OA\Property(property: 'password', type: 'string', format: 'password', minLength: 8, example: 'secret123')]
    public string $password = '';

    #[OA\Property(property: 'title', type: 'string', example: 'Aram Center')]
    public string $title = '';

    #[OA\Property(property: 'description', type: 'string', example: 'A leading service center.')]
    public string $description = '';

    #[OA\Property(property: 'features', type: 'string', nullable: true)]
    public ?string $features = null;

    #[OA\Property(property: 'location', type: 'string', nullable: true, description: 'JSON-encoded location.')]
    public ?string $location = null;

    #[OA\Property(property: 'phone_number', type: 'string', nullable: true, example: '+966500000000')]
    public ?string $phone_number = null;

    #[OA\Property(property: 'confirmation_price', type: 'number', format: 'float', nullable: true)]
    public ?float $confirmation_price = null;

    #[OA\Property(property: 'confirmation_status', type: 'boolean', example: true)]
    public bool $confirmation_status = true;

    #[OA\Property(property: 'open_at', type: 'string', example: '09:00')]
    public string $open_at = '';

    #[OA\Property(property: 'close_at', type: 'string', example: '18:00')]
    public string $close_at = '';

    #[OA\Property(property: 'url', type: 'string', nullable: true)]
    public ?string $url = null;

    #[OA\Property(property: 'booking_status', type: 'boolean', example: true)]
    public bool $booking_status = true;

    #[OA\Property(property: 'status', type: 'string', nullable: true, enum: ['published', 'not_published', 'under_review'])]
    public ?string $status = null;

    #[OA\Property(property: 'rating', type: 'number', format: 'float', nullable: true, example: 4.5)]
    public ?float $rating = null;

    #[OA\Property(property: 'categories', type: 'array', nullable: true, description: 'Category ids or JSON-encoded array.', items: new OA\Items(type: 'integer'))]
    public ?array $categories = null;

    #[OA\Property(property: 'sub_categories', type: 'array', nullable: true, description: 'Sub category ids or JSON-encoded array.', items: new OA\Items(type: 'integer'))]
    public ?array $sub_categories = null;

    #[OA\Property(property: 'image', type: 'string', format: 'binary', description: 'Cover image file.')]
    public string $image = '';

    #[OA\Property(property: 'logo', type: 'string', format: 'binary', description: 'Logo file.')]
    public string $logo = '';

    #[OA\Property(property: 'cooperation_file', type: 'string', nullable: true, description: 'Cooperation file URL or file.')]
    public ?string $cooperation_file = null;
}