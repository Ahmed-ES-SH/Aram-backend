<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProvisionalData extends Model
{
    protected $fillable = [
        'cardsDetailes',
        'uniqueId',
        'expire_at',
        'purchase_id',
    ];
}
