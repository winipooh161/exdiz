<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class FirebaseController extends Controller
{
    /**
     * Сохранение FCM токена пользователя.
     */
    public function saveToken(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
        ]);

        $user = Auth::user();

        try {
            // Сохраните токен в базе данных
            // Предполагается, что у вас есть таблица user_tokens с полями user_id и token
            $user->tokens()->updateOrCreate(
                ['token' => $request->token],
                ['user_id' => $user->id]
            );

            return response()->json(['success' => true], 200);
        } catch (\Exception $e) {
            Log::error('Ошибка при сохранении FCM токена:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }
}
