<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'MessageResponse',
    title: 'Message-only response body',
    description: 'Simple { message } body used by several endpoints.',
    required: ['message'],
)]
class MessageResponseSchema
{
    #[OA\Property(property: 'message', type: 'string', example: 'تم إرسال كود التحقق إلى بريدك الإلكتروني.')]
    public string $message = '';
}