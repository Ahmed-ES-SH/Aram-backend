<?php

namespace App\Modules\Organization\Models;

use Illuminate\Database\Eloquent\Model;

class OrganizationCategory extends Model
{
    protected $fillable = ['organization_id', 'category_id'];
}
