<?php

namespace App\Modules\Content\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'subject',
        'message',
        'status',
    ];
}
