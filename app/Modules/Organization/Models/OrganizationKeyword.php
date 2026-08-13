<?php

namespace App\Modules\Organization\Models;

use Illuminate\Database\Eloquent\Model;

class OrganizationKeyword extends Model
{
    protected $fillable = [
        'organization_id',
        'keyword_id',
    ];
}
