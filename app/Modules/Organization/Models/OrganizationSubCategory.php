<?php

namespace App\Modules\Organization\Models;

use Illuminate\Database\Eloquent\Model;

class OrganizationSubCategory extends Model
{
    protected $fillable = ['organization_id', 'subcategory_id'];
}
