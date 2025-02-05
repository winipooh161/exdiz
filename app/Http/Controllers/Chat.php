<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = ['deal_id', 'name', 'type'];

    /**
     * Связь с пользователями, участвующими в чате.
     */

    /**
     * Связь с сообщениями в чате.
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'chat_user');
    }
    
    /**
     * Связь с сделкой (если чат групповой).
     */
    public function deal()
    {
        return $this->belongsTo(Deal::class);
    }
}
