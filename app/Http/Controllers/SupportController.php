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
        $userId = $user->id;
    
    
        $title_site = "Поддержка | Личный кабинет Экспресс-дизайн";
        return view('support', compact( 'title_site', 'user'));
    }
    
    /**
     * Показать страницу с чатами (жалобами).
     */
    

    
}
