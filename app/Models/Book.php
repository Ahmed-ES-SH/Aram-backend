<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'book_day',
        'book_time',
        'expire_in',
        'additional_notes',
        'user_id',
        'organization_id',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function organization()
    {
        return $this->belongsTo(organization::class, 'organization_id');
    }
}
