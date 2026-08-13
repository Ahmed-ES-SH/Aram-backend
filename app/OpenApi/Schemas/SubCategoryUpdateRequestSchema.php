<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'SubCategoryUpdateRequest',
    title: 'Sub category update request body',
    description: 'All fields optional; partial update. Posted as multipart/form-data when an image is included.',
)]
class SubCategoryUpdateRequestSchema
{
    #[OA\Property(property: 'parent_id', type: 'integer', example: 1)]
    public ?int $parent_id = null;

    #[OA\Property(property: 'title_en', type: 'string', example: 'Dentistry')]
    public ?string $title_en = null;

    #[OA\Property(property: 'title_ar', type: 'string', example: 'طب الأسنان')]
    public ?string $title_ar = null;

    #[OA\Property(property: 'bg_color', type: 'string', example: '#4f46e5')]
    public ?string $bg_color = null;

    #[OA\Property(property: 'icon_name', type: 'string', example: 'tooth')]
    public ?string $icon_name = null;

    #[OA\Property(property: 'is_active', type: 'boolean', example: true)]
    public ?bool $is_active = null;

    #[OA\Property(property: 'image', type: 'string', format: 'binary', description: 'New sub category image file.')]
    public ?string $image = null;
}