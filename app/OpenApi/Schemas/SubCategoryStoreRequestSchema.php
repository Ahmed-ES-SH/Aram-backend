<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'SubCategoryStoreRequest',
    title: 'Sub category store request body',
    description: 'Posted as multipart/form-data with the image file.',
)]
class SubCategoryStoreRequestSchema
{
    #[OA\Property(property: 'parent_id', type: 'integer', example: 1)]
    public int $parent_id = 0;

    #[OA\Property(property: 'title_en', type: 'string', example: 'Dentistry')]
    public string $title_en = '';

    #[OA\Property(property: 'title_ar', type: 'string', example: 'طب الأسنان')]
    public string $title_ar = '';

    #[OA\Property(property: 'bg_color', type: 'string', example: '#4f46e5')]
    public string $bg_color = '';

    #[OA\Property(property: 'icon_name', type: 'string', example: 'tooth')]
    public string $icon_name = '';

    #[OA\Property(property: 'image', type: 'string', format: 'binary', description: 'Sub category image file.')]
    public string $image = '';
}