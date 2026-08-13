<?php

namespace App\Modules\Organization\Models;

use Illuminate\Database\Eloquent\Model;

class OrganizationPrivacyPolicy extends Model
{
    protected $fillable = ['content_en', 'content_ar'];
}
