<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'ServiceForm',
    title: 'ServiceForm',
    description: 'Service form entity.',
    required: ['id'],
)]
class ServiceFormSchema
{
    #[OA\Property(property: 'id', type: 'integer', example: 1)]
    public int $id = 1;
    #[OA\Property(property: 'service_page_id', type: 'integer', example: 3)]
    public int $service_page_id = 3;
    #[OA\Property(property: 'name_ar', type: 'string', example: 'نموذج الطلب')]
    public string $name_ar = '';
    #[OA\Property(property: 'name_en', type: 'string', example: 'Order form')]
    public string $name_en = '';
    #[OA\Property(property: 'description_ar', type: 'string', nullable: true)]
    public ?string $description_ar = null;
    #[OA\Property(property: 'description_en', type: 'string', nullable: true)]
    public ?string $description_en = null;
    #[OA\Property(property: 'is_active', type: 'boolean', example: true)]
    public bool $is_active = true;
    #[OA\Property(property: 'version', type: 'integer', example: 3)]
    public int $version = 3;
    #[OA\Property(property: 'created_at', type: 'string', example: '2026-01-01T10:00:00.000000Z')]
    public string $created_at = '';
}