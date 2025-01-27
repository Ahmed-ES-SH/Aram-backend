<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class participant extends Model
{
    protected $fillable = [];

    public function conversations()
    {
        return $this->belongsTo(Conversation::class);
    }

    public function participant()
    {
        return $this->morphTo();
    }
}
