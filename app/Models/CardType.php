<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CardType extends Model
{
    protected $fillable = [
        'title_ar',
        'title_en',
        'description_en',
        'description_ar',
        'features_ar',
        'features_en',
        'duration',
        'image',
        'price_before_discount',
        'number_of_promotional_purchases',
        'price',
        'quantity',
        'category_id',
        'active'
    ];


    protected $casts = [
        'features_ar' => 'array',
        'features_en' => 'array'
    ];


    public function card()
    {
        return $this->hasMany(Arma_Card::class, 'cardtype_id');
    }


    public function category()
    {
        return $this->belongsTo(CardTypeCategory::class);
    }

    public function promoterCards()
    {
        return $this->hasMany(promotionalCard::class);
    }
}
