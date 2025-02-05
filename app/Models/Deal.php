<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deal extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_name',
        'name',
        'client_phone',
        'total_sum',
        'status',
        'link',
        'registration_token',
        'registration_token_expiry',
        'user_id',
        'coordinator_id',
        'avatar_path',
        'client_city',
        'client_email',
        'object_type',
        'package',
        'has_animals',
        'has_plants',
        'object_style',
        'measurements',
        'rooms_count',
        'deal_end_date',
        'common_id',
        'commercial_id',

        // Новые поля:
        'completion_responsible',
        'office_equipment',
        'stage',
        'coordinator_score',
        'measuring_cost',
        'project_budget',
        'created_date',
        'client_info',
        'payment_date',
        'execution_comment',
        'comment',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function chat()
    {
        return $this->hasOne(Chat::class);
    }
    

    public function getUnreadMessagesCount($userId)
    {
        return $this->chatMessages()
            ->where('user_id', '!=', $userId)
            ->where('is_read', false)
            ->count();
    }

    // Связь с координатором
    public function coordinator()
    {
        return $this->belongsTo(User::class, 'coordinator_id');
    }

    // Связь с клиентом
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id'); // Используйте правильное поле
    }

    // Связь с коммерческим брифом
    public function commercial()
    {
        return $this->belongsTo(Commercial::class, 'commercial_id');
    }
    public function view(User $user, Deal $deal)
    {
        return $deal->users->contains($user->id);
    }
    
    // Связь с общим брифом
    public function brief()
    {
        return $this->belongsTo(Common::class, 'common_id');
    }

    // Связь с брифами Common
    public function briefs()
    {
        return $this->hasMany(Common::class, 'deal_id'); // связь с таблицей Common
    }

    // Связь с брифами Commercial
    public function commercials()
    {
        return $this->hasMany(Commercial::class, 'deal_id'); // связь с таблицей Commercial
    }

    // Связь с пользователями
    public function users()
    {
        return $this->belongsToMany(User::class, 'deal_user', 'deal_id', 'user_id');
    }
    

    // Получить координаторов
    public function coordinators()
    {
        return $this->users()->wherePivot('role', 'coordinator');
    }

    // Получить ответственных
    public function responsibles()
    {
        return $this->users()->wherePivot('role', 'responsible');
    }
    public function allUsers()
{
    return $this->users()->wherePivotIn('role', ['responsible', 'coordinator']);
}

}
