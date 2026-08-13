<?php

namespace App\Modules\Content\Models;

use Illuminate\Database\Eloquent\Model;

class FooterList extends Model
{
    protected $fillable = [
        'title'
    ];

    public function links()
    {
        return $this->hasMany(FooterLink::class, 'list_id');
    }
}
