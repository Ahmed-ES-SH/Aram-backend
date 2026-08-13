<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'CategoryStoreRequest',
    title: 'Category / card category / service category store request body',
    description: 'Posted as multipart/form-data with the image file.',
)]
class CategoryStoreRequestSchema
{
    #[OA\Property(property: 'title_en', type: 'string', example: 'Health')]
    public string $title_en = '';

    #[OA\Property(property: 'title_ar', type: 'string', example: 'الصحة')]
    public string $title_ar = '';

    #[OA\Property(property: 'bg_color', type: 'string', example: '#4f46e5')]
    public string $bg_color = '';

    #[OA\Property(property: 'icon_name', type: 'string', example: 'heart')]
    public string $icon_name = '';

    #[OA\Property(property: 'image', type: 'string', format: 'binary', description: 'Category image file.')]
    public string $image = '';
}