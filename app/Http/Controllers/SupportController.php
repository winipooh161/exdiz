<?php
namespace App\Http\Controllers;

use App\Models\SupportTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(Request $request)
    {
        $user = Auth::user();
        $title_site = "Поддержка | Личный кабинет Экспресс-дизайн";
        // На странице поддержки через URL /support срабатывает условие в chats/index.blade.php,
        // которое выводит чат с поддержкой (user id = 55)
        return view('support', compact('title_site', 'user'));
    }
    
    // Другие методы поддержки (например, создание тикета) можно добавить здесь
}
