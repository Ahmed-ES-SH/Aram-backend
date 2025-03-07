<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bell extends Model
{
    protected $fillable = [
        'bell_items',
        'bell_type',
        'amount',
        'user_id',
        'account_type',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function promoterCards()
    {
        return $this->hasMany(promotionalCard::class);
    }
}
