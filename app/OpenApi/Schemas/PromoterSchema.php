<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'Promoter',
    title: 'Promoter',
    description: 'Promoter entity.',
    required: ['id'],
)]
class PromoterSchema
{
    #[OA\Property(property: 'id', type: 'integer', example: 1)]
    public int $id = 1;
    #[OA\Property(property: 'promoter_id', type: 'integer', example: 5)]
    public int $promoter_id = 5;
    #[OA\Property(property: 'promoter_type', type: 'string', enum: ['user', 'organization'])]
    public string $promoter_type = 'user';
    #[OA\Property(property: 'referral_code', type: 'string', example: 'PROMO2026')]
    public string $referral_code = '';
    #[OA\Property(property: 'discount_percentage', type: 'number', example: 10.0)]
    public float $discount_percentage = 0;
    #[OA\Property(property: 'status', type: 'string', enum: ['active', 'disabled'])]
    public string $status = 'active';
    #[OA\Property(property: 'total_visits', type: 'integer', example: 12)]
    public int $total_visits = 0;
    #[OA\Property(property: 'created_at', type: 'string', example: '2026-01-01T10:00:00.000000Z')]
    public string $created_at = '';
}