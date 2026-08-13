<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'Transaction',
    title: 'Transaction',
    description: 'Wallet transaction entity.',
    required: ['user_id', 'type', 'amount'],
)]
class TransactionSchema
{
    #[OA\Property(property: 'id', type: 'integer', example: 1)]
    public int $id = 0;

    #[OA\Property(property: 'user_id', type: 'integer', example: 1)]
    public int $user_id = 0;

    #[OA\Property(property: 'account_type', type: 'string', enum: ['user', 'organization'], example: 'user')]
    public string $account_type = '';

    #[OA\Property(property: 'type', type: 'string', enum: ['deposit', 'sale', 'transfer', 'withdrawal'], example: 'deposit')]
    public string $type = '';

    #[OA\Property(property: 'direction', type: 'string', enum: ['in', 'out'], example: 'in')]
    public string $direction = '';

    #[OA\Property(property: 'amount', type: 'number', format: 'float', example: 100.0)]
    public float $amount = 0;

    #[OA\Property(property: 'status', type: 'string', enum: ['pending', 'completed', 'failed'], example: 'completed')]
    public string $status = '';

    #[OA\Property(property: 'source_type', type: 'string', nullable: true, example: 'withdraw_requests')]
    public ?string $source_type = null;

    #[OA\Property(property: 'source_id', type: 'integer', nullable: true, example: 3)]
    public ?int $source_id = null;

    #[OA\Property(property: 'note', type: 'string', nullable: true, example: 'Simulated deposit')]
    public ?string $note = null;

    #[OA\Property(property: 'meta', type: 'object', nullable: true, additionalProperties: true)]
    public ?object $meta = null;

    #[OA\Property(property: 'created_at', type: 'string', format: 'date-time', example: '2026-01-01T10:00:00.000000Z')]
    public string $created_at = '';

    #[OA\Property(property: 'updated_at', type: 'string', format: 'date-time', example: '2026-01-01T10:00:00.000000Z')]
    public string $updated_at = '';
}