<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Affiliate_cardType extends Model
{
    protected $fillable = [
        "title_en",
        "title_ar",
        "organization_id",
        "description_en",
        "description_ar",
        "price_before_discount",
        "price",
        "features_ar",
        "features_en",
        "duration",
        "image",
        "active",
        "status",
    ];

    protected $casts = ["features_ar" => 'array', "features_en" => 'array'];

    public function card()
    {
        return $this->hasMany(Arma_Card::class);
    }


    public function organization()
    {
        return $this->belongsTo(organization::class, 'organization_id');
    }
}
