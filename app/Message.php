<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'conversation_id',
        'sender_id',
        'sender_type',
        'content',
        'file_path',
        'is_read',
        'message_type',
        'message_type',
    ];


    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }
}

