<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;

class organization extends Model
{
    use HasApiTokens, HasFactory;

    protected $fillable = [
        'email',
        'password',
        'title_ar',
        'title_en',
        'description_ar',
        'description_en',
        'location',
        'features',
        'accaptable_message',
        'unaccaptable_message',
        'categories_ids',
        'category_id',
        'confirmation_price',
        'confirmation_status',
        'phone_number',
        'open_at',
        'close_at',
        'url',
        'rateing',
        'status',
        'image',
        'icon',
        'is_signed',
        'Number_of_reservations',
        'account_type',
        'active'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'categories_ids' => 'array'
    ];

    /**
     * علاقة العديد إلى الواحد مع الفئة
     */
    public function category()
    {
        return $this->belongsTo(ServiceCategory::class, 'category_id');
    }

    public function Book()
    {
        return $this->hasMany(Book::class);
    }

    public function financialTransactions()
    {
        return $this->hasMany(FinancialTransactions::class);
    }


    public function blockedUsers()
    {
        return $this->morphMany(blocked_user::class, 'blocker');
    }

    public function blockedBy()
    {
        return $this->morphMany(blocked_user::class, 'blocked');
    }


    public function organization()
    {
        return $this->hasMany(Affiliate_cardType::class);
    }

    public function coupons()
    {
        return $this->hasMany(Copone::class);
    }
}
