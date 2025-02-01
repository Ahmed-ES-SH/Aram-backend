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


    public function blockedUsers()
    {
        return $this->morphMany(blocked_user::class, 'blocker');
    }

    public function blockedBy()
    {
        return $this->morphMany(blocked_user::class, 'blocked');
    }
}
