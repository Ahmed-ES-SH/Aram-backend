<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'WithdrawRequest',
    title: 'Withdraw Request',
    description: 'Withdrawal request entity.',
    required: ['user_id', 'amount', 'status'],
)]
class WithdrawRequestSchema
{
    #[OA\Property(property: 'id', type: 'integer', example: 1)]
    public int $id = 0;

    #[OA\Property(property: 'user_id', type: 'integer', example: 1)]
    public int $user_id = 0;

    #[OA\Property(property: 'account_type', type: 'string', enum: ['user', 'organization'], example: 'user')]
    public string $account_type = '';

    #[OA\Property(property: 'amount', type: 'number', format: 'float', example: 100.0)]
    public float $amount = 0;

    #[OA\Property(property: 'status', type: 'string', enum: ['pending', 'approved', 'rejected'], example: 'pending')]
    public string $status = '';

    #[OA\Property(property: 'bank_number', type: 'string', nullable: true, example: 'SA4420000000000000000000')]
    public ?string $bank_number = null;

    #[OA\Property(property: 'note', type: 'string', nullable: true, example: 'Rejected by admin')]
    public ?string $note = null;

    #[OA\Property(property: 'meta', type: 'object', nullable: true, additionalProperties: true)]
    public ?object $meta = null;

    #[OA\Property(
        property: 'user',
        ref: '#/components/schemas/User',
        type: 'object',
        nullable: true,
    )]
    public object $user;

    #[OA\Property(property: 'created_at', type: 'string', format: 'date-time', example: '2026-01-01T10:00:00.000000Z')]
    public string $created_at = '';

    #[OA\Property(property: 'updated_at', type: 'string', format: 'date-time', example: '2026-01-01T10:00:00.000000Z')]
    public string $updated_at = '';
}