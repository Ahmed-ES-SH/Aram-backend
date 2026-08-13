<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'PromotionActivity',
    title: 'Promotion activity',
    description: 'Promoter activity entity.',
    required: ['id'],
)]
class PromotionActivitySchema
{
    #[OA\Property(property: 'id', type: 'integer', example: 1)]
    public int $id = 1;
    #[OA\Property(property: 'promoter_id', type: 'integer', example: 1)]
    public int $promoter_id = 1;
    #[OA\Property(property: 'promoter_type', type: 'string', example: 'user')]
    public string $promoter_type = '';
    #[OA\Property(property: 'activity_type', type: 'string', example: 'visit')]
    public string $activity_type = '';
    #[OA\Property(property: 'member_id', type: 'integer', example: 5)]
    public int $member_id = 5;
    #[OA\Property(property: 'member_type', type: 'string', example: 'user')]
    public string $member_type = '';
    #[OA\Property(property: 'commission_amount', type: 'number', example: 2.5)]
    public float $commission_amount = 2.5;
    #[OA\Property(property: 'activity_at', type: 'string', example: '2026-01-01T10:00:00.000000Z')]
    public string $activity_at = '';
    #[OA\Property(property: 'created_at', type: 'string', example: '2026-01-01T10:00:00.000000Z')]
    public string $created_at = '';
    #[OA\Property(property: 'updated_at', type: 'string', example: '2026-01-01T10:00:00.000000Z')]
    public string $updated_at = '';
}
