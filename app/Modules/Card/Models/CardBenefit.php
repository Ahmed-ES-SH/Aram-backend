<?php

namespace App\Modules\Card\Models;

use Illuminate\Database\Eloquent\Model;

class CardBenefit extends Model
{
    protected $fillable = [
        'title',
        'card_id'
    ];


    public function card()
    {
        return $this->belongsTo(Card::class);
    }
}
