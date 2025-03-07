<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CardTypeCategory extends Model
{
    protected $fillable = [
        'title_en',
        'title_ar',
        'image',
    ];

    public function cards()
    {
        return $this->hasMany(CardType::class);
    }
}
