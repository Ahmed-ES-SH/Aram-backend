<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'Wallet',
    title: 'Wallet',
    description: 'User/organization wallet entity.',
    required: ['user_id', 'account_type'],
)]
class WalletSchema
{
    #[OA\Property(property: 'id', type: 'integer', example: 1)]
    public int $id = 0;

    #[OA\Property(property: 'user_id', type: 'integer', example: 1)]
    public int $user_id = 0;

    #[OA\Property(property: 'account_type', type: 'string', enum: ['user', 'organization'], example: 'user')]
    public string $account_type = '';

    #[OA\Property(property: 'available_balance', type: 'number', format: 'float', example: 250.0)]
    public float $available_balance = 0;

    #[OA\Property(property: 'pending_balance', type: 'number', format: 'float', example: 50.0)]
    public float $pending_balance = 0;

    #[OA\Property(property: 'total_balance', type: 'number', format: 'float', example: 300.0)]
    public float $total_balance = 0;

    #[OA\Property(property: 'created_at', type: 'string', format: 'date-time', example: '2026-01-01T10:00:00.000000Z')]
    public string $created_at = '';

    #[OA\Property(property: 'updated_at', type: 'string', format: 'date-time', example: '2026-01-01T10:00:00.000000Z')]
    public string $updated_at = '';
}