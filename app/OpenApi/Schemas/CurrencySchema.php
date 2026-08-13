<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'Currency',
    title: 'Currency',
    description: 'Currency entity.',
    required: ['id', 'name', 'code'],
)]
class CurrencySchema
{
    #[OA\Property(property: 'id', type: 'integer', example: 1)]
    public int $id = 0;

    #[OA\Property(property: 'name', type: 'string', example: 'US Dollar')]
    public string $name = '';

    #[OA\Property(property: 'code', type: 'string', maxLength: 10, example: 'USD')]
    public string $code = '';

    #[OA\Property(property: 'symbol', type: 'string', maxLength: 10, example: '$')]
    public string $symbol = '';

    #[OA\Property(property: 'exchange_rate', type: 'number', format: 'float', example: 3.75)]
    public float $exchange_rate = 0;

    #[OA\Property(property: 'is_default', type: 'boolean', example: false)]
    public bool $is_default = false;

    #[OA\Property(property: 'created_at', type: 'string', format: 'date-time', example: '2026-01-01T10:00:00.000000Z')]
    public string $created_at = '';

    #[OA\Property(property: 'updated_at', type: 'string', format: 'date-time', example: '2026-01-01T10:00:00.000000Z')]
    public string $updated_at = '';
}