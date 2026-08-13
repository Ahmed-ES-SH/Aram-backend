<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'ServiceOrder',
    title: 'ServiceOrder',
    description: 'Service order entity.',
    required: ['id'],
)]
class ServiceOrderSchema
{
    #[OA\Property(property: 'id', type: 'integer', example: 1)]
    public int $id = 1;
    #[OA\Property(property: 'service_id', type: 'integer', example: 3)]
    public int $service_id = 3;
    #[OA\Property(property: 'user_id', type: 'integer', example: 5)]
    public int $user_id = 5;
    #[OA\Property(property: 'user_type', type: 'string', enum: ['user', 'organization'])]
    public string $user_type = 'user';
    #[OA\Property(property: 'status', type: 'string', enum: ['pending', 'confirmed', 'in_progress', 'on_hold', 'completed', 'canceled', 'refunded'])]
    public string $status = 'pending';
    #[OA\Property(property: 'payment_status', type: 'string', enum: ['pending', 'paid', 'failed'])]
    public string $payment_status = 'pending';
    #[OA\Property(property: 'invoice_type', type: 'string', nullable: true, example: 'service')]
    public ?string $invoice_type = null;
    #[OA\Property(property: 'is_deal', type: 'boolean', example: false)]
    public bool $is_deal = false;
    #[OA\Property(property: 'metadata', type: 'object', nullable: true)]
    public ?object $metadata = null;
    #[OA\Property(property: 'created_at', type: 'string', example: '2026-01-01T10:00:00.000000Z')]
    public string $created_at = '';
}