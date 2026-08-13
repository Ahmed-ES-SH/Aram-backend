<?php

namespace App\Modules\Organization\Models;

use App\Modules\Card\Models\Card;
use Illuminate\Database\Eloquent\Model;

class OrganizationBenefit extends Model
{
    protected $fillable = [
        'title',
        'organization_id'
    ];


    public function organization()
    {
        return $this->belongsTo(Card::class);
    }
}
