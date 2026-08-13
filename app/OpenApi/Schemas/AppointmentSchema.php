<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'Appointment',
    title: 'Appointment',
    description: 'Appointment entity.',
    required: ['id'],
)]
class AppointmentSchema
{
    #[OA\Property(property: 'id', type: 'integer', example: 1)]
    public int $id = 1;
    #[OA\Property(property: 'user_id', type: 'integer', nullable: true, example: 5)]
    public ?int $user_id = null;
    #[OA\Property(property: 'organization_id', type: 'integer', example: 2)]
    public int $organization_id = 2;
    #[OA\Property(property: 'start_time', type: 'string', example: '2026-01-01 10:00:00')]
    public string $start_time = '';
    #[OA\Property(property: 'end_time', type: 'string', example: '2026-01-01 10:30:00')]
    public string $end_time = '';
    #[OA\Property(property: 'status', type: 'string', example: 'pending')]
    public string $status = 'pending';
    #[OA\Property(property: 'price', type: 'number', nullable: true, example: 50.00)]
    public ?float $price = null;
    #[OA\Property(property: 'is_paid', type: 'boolean', example: false)]
    public bool $is_paid = false;
    #[OA\Property(property: 'user_notes', type: 'string', nullable: true, example: 'Morning slot')]
    public ?string $user_notes = null;
    #[OA\Property(property: 'organization_notes', type: 'string', nullable: true, example: 'Confirmed')]
    public ?string $organization_notes = null;
    #[OA\Property(property: 'created_at', type: 'string', example: '2026-01-01T10:00:00.000000Z')]
    public string $created_at = '';
}