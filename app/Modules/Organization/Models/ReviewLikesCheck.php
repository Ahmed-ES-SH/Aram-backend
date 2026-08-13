<?php

namespace App\Modules\Organization\Models;

use App\Modules\Organization\Models\OrganizationReview;
use App\Modules\User\Models\User;
use Illuminate\Database\Eloquent\Model;

class ReviewLikesCheck extends Model
{
    protected $fillable = ['user_id', 'review_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function review()
    {
        return $this->belongsTo(organizationReview::class);
    }
}
