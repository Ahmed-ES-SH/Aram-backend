<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class promotionalCard extends Model
{
    protected $fillable = [
        'card_id',
        'bell_id',
        'promoter_code',
    ];

    public function bell()
    {
        return $this->belongsTo(Bell::class);
    }

    public function card()
    {
        return $this->belongsTo(CardType::class);
    }

    public function promoter()
    {
        return $this->belongsTo(User::class, 'promoter_code', 'user_code');
    }
}
