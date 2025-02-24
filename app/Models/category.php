<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    protected $fillable = ['title_ar', 'title_en', 'image'];

    public function organizations()
    {
        return $this->hasMany(organization::class, 'category_id');
    }
    public function services()
    {
        return $this->hasMany(Service::class, 'category_id');
    }
}
