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
        // Передаём флаг, чтобы шаблон отобразил режим чата поддержки
        return view('support', compact('title_site', 'user'))->with('supportChat', true);
    }
    
    // Другие методы поддержки (например, создание тикета) можно добавить здесь
}
