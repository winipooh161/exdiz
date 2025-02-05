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
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Связь с таблицей сделок (через таблицу deal_user).
     */
    public function deals()
    {
        return $this->belongsToMany(Deal::class, 'deal_user', 'user_id', 'deal_id');
    }
    
    public function deal()
    {
        return $this->hasOne(Deal::class);
    }
    
    /**
     * Проверка — является ли пользователь координатором.
     */
    public function isCoordinator()
    {
        return $this->status === 'coordinator';
    }

    /**
     * Чаты, в которых участвует пользователь.
     */
    public function chats()
    {
        return $this->belongsToMany(Chat::class)
                    ->withPivot('last_read_at');
    }

    /**
     * Сделки, где пользователь выступает координатором.
     */
    public function coordinatorDeals()
    {
        return $this->belongsToMany(Deal::class, 'deal_user')
                    ->withPivot('role')
                    ->wherePivot('role', 'coordinator');
    }

    /**
     * Сделки, где пользователь выступает ответственным.
     */
    public function responsibleDeals()
    {
        return $this->belongsToMany(Deal::class, 'deal_user')
                    ->withPivot('role')
                    ->wherePivot('role', 'responsible');
    }
}
