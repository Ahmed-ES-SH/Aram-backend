<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'QuestionAnswer',
    title: 'Question answer',
    description: 'FAQ question and answer entity.',
    required: ['id'],
)]
class QuestionAnswerSchema
{
    #[OA\Property(property: 'id', type: 'integer', example: 1)]
    public int $id = 1;
    #[OA\Property(property: 'question', type: 'string', example: 'How does it work?')]
    public string $question = '';
    #[OA\Property(property: 'answer', type: 'string', example: 'It works like this')]
    public string $answer = '';
    #[OA\Property(property: 'is_visible', type: 'boolean', example: True)]
    public bool $is_visible = True;
    #[OA\Property(property: 'created_at', type: 'string', example: '2026-01-01T10:00:00.000000Z')]
    public string $created_at = '';
    #[OA\Property(property: 'updated_at', type: 'string', example: '2026-01-01T10:00:00.000000Z')]
    public string $updated_at = '';
}
