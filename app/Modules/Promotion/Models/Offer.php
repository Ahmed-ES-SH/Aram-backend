<?php

namespace App\Modules\Promotion\Models;

use App\Models\Category;
use App\Modules\Organization\Models\Organization;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $fillable = [
        'title',
        'description',
        'image',
        'number_of_uses',
        'usage_limit',
        'discount_type',
        'discount_value',
        'code',
        'start_date',
        'end_date',
        'status',
        'organization_id',
        'category_id',
    ];


    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_offer');
    }


    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function scopeFilterByCategories($query, $categories)
    {
        if (empty($categories)) {
            return $query;
        }

        // Convert single ID to array if necessary
        $categories = is_array($categories) ? $categories : [$categories];

        return $query->whereHas('categories', function ($q) use ($categories) {
            $q->whereIn('categories.id', $categories);
        });
    }
}
