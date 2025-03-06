<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'password',
        'phone',
        'status',
        'avatar_url', // Добавляем это поле!
        'cod',
        'verification_code',
        'verification_code_expires_at',
        'city',
        'contract_number',
        'comment',
        'portfolio_link',
        'experience',
        'rating',
        'active_projects_count',
        'firebase_token',
    ];
    

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Примеры связей
    public function deals()
    {
        return $this->belongsToMany(Deal::class, 'deal_user', 'user_id', 'deal_id');
    }

    public function deal()
    {
        return $this->hasOne(Deal::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function getAvatarUrlAttribute()
    {
        return !empty($this->attributes['avatar_url']) 
            ? asset('' . ltrim($this->attributes['avatar_url'], '')) 
            : asset('storage/default-avatar.png');
    }
    
    public function isCoordinator()
    {
        return $this->status === 'coordinator';
    }

    public function chats()
    {
        return $this->belongsToMany(Chat::class)
                    ->withPivot('last_read_at');
    }

    public function coordinatorDeals()
    {
        return $this->belongsToMany(Deal::class, 'deal_user')
                    ->withPivot('role')
                    ->wherePivot('role', 'coordinator');
    }

    public function responsibleDeals()
    {
        return $this->belongsToMany(Deal::class, 'deal_user')
                    ->withPivot('role')
                    ->wherePivot('role', 'responsible');
    }

    public function tokens()
    {
        return $this->hasMany(UserToken::class);
    }
}
