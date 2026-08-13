<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'ServiceFormSubmission',
    title: 'ServiceFormSubmission',
    description: 'Service form submission entity.',
    required: ['id'],
)]
class ServiceFormSubmissionSchema
{
    #[OA\Property(property: 'id', type: 'integer', example: 1)]
    public int $id = 1;
    #[OA\Property(property: 'service_form_id', type: 'integer', example: 2)]
    public int $service_form_id = 2;
    #[OA\Property(property: 'user_id', type: 'integer', example: 5)]
    public int $user_id = 5;
    #[OA\Property(property: 'user_type', type: 'string', enum: ['user', 'organization'])]
    public string $user_type = 'user';
    #[OA\Property(property: 'status', type: 'string', enum: ['pending', 'reviewed', 'approved', 'rejected'])]
    public string $status = 'pending';
    #[OA\Property(property: 'created_at', type: 'string', example: '2026-01-01T10:00:00.000000Z')]
    public string $created_at = '';
}