<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceCategory extends Model
{
    protected $fillable = [
        "title_ar",
        "title_en",
        "image",
    ];


    public function services()
    {
        return $this->hasMany(Service::class, 'category_id');
    }
    public function coupons()
    {
        return $this->hasMany(Copone::class);
    }
}
