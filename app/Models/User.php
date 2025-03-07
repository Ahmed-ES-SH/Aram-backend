<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "name",
        'email',
        'password',
        "phone_number",
        'location',
        "image",
        "role",
        'social_id',
        'social_type',
        'is_signed',
        'is_promoter',
        'user_gender',
        'user_birthdate',
        'email_verification_token',
        'number_of_reservations',
        'account_type'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    public function articals()
    {
        return $this->hasMany(Blog::class);
    }
    public function counts()
    {
        return $this->hasMany(ArticleReactionCount::class);
    }
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function Cards()
    {
        return $this->hasMany(Arma_Card::class);
    }
    public function Books()
    {
        return $this->hasMany(Arma_Card::class);
    }
    public function usersBell()
    {
        return $this->hasMany(Arma_Card::class);
    }
    public function financialTransactions()
    {
        return $this->hasMany(FinancialTransactions::class);
    }

    public function coupons()
    {
        return $this->belongsToMany(Copone::class, 'coupon_user', 'user_id', 'coupon_id');
    }


    public function blockedUsers()
    {
        return $this->morphMany(blocked_user::class, 'blocker');
    }

    public function blockedBy()
    {
        return $this->morphMany(blocked_user::class, 'blocked');
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class, 'user_id');
    }
    public function visitors()
    {
        return $this->hasMany(Visit::class, 'user_id');
    }
    public function Cardvisitors()
    {
        return $this->hasMany(CardVisit::class, 'user_id');
    }
    public function newUsers()
    {
        return $this->hasMany(PromoterNewUser::class, 'user_id');
    }
    public function orgreviews()
    {
        return $this->hasMany(organizationReview::class, 'user_id');
    }
    public function orgreviewslikes()
    {
        return $this->hasMany(ReviewLikesCheck::class, 'user_id');
    }
}
