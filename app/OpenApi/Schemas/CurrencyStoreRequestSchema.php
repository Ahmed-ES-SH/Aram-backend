<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'CurrencyStoreRequest',
    title: 'Currency Store/Update Request',
    description: 'Payload for creating or updating a currency.',
)]
class CurrencyStoreRequestSchema
{
    #[OA\Property(property: 'name', type: 'string', maxLength: 255, example: 'US Dollar')]
    public string $name = '';

    #[OA\Property(property: 'code', type: 'string', maxLength: 10, example: 'USD')]
    public string $code = '';

    #[OA\Property(property: 'symbol', type: 'string', maxLength: 10, example: '$')]
    public string $symbol = '';

    #[OA\Property(property: 'exchange_rate', type: 'number', format: 'float', example: 3.75)]
    public float $exchange_rate = 0;

    #[OA\Property(property: 'is_default', type: 'boolean', nullable: true, example: false)]
    public ?bool $is_default = null;
}