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
        'avatar_url',
        'cod',
        'verification_code',
        'verification_code_expires_at',
        // Дополнительные поля:
        'city',
        'contract_number',
        'comment',
        'portfolio_link',
        'experience',
        'rating',
        'active_projects_count',
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
}
