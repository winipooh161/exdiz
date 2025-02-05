<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // =========================
    // 1. Отображение профиля
    // =========================
    public function index()
    {
        $user = Auth::user();
        $title_site = "Профиль аккаунта | Личный кабинет Экспресс-дизайн";
        return view('profile', compact('user', 'title_site'));
    }

    // =========================================
    // 2. Отправка кода подтверждения на телефон
    // =========================================
    public function sendVerificationCode(Request $request)
    {
        $request->validate([
            'phone' => 'required',
        ]);

        $user = Auth::user();

        // Удаляем все нецифровые символы из номера телефона
        $rawPhone = preg_replace('/\D/', '', $request->input('phone'));

        // Формируем +7 (...) формат (пример, адаптируйте под нужный формат)
        $formattedPhone = '+7 (' . substr($rawPhone, 1, 3) . ') ' 
                         . substr($rawPhone, 4, 3) 
                         . '-' 
                         . substr($rawPhone, 7, 2) 
                         . '-' 
                         . substr($rawPhone, 9);

        $verificationCode = rand(1000, 9999);
        $apiKey = 'ВАШ_API_КЛЮЧ_SMS_RU'; // Пример

        // Отправка кода через SMS.RU (пример)
        $response = Http::get("https://sms.ru/sms/send", [
            'api_id' => $apiKey,
            'to'     => $rawPhone, // исходный номер
            'msg'    => "Ваш код: $verificationCode",
        ]);

        if ($response->failed()) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка при отправке SMS.'
            ]);
        }

        // Сохраняем код и время "протухания" кода
        $user->verification_code = $verificationCode;
        $user->verification_code_expires_at = now()->addMinutes(10);

        // Сохраняем форматированный номер телефона
        $user->phone = $formattedPhone;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Код подтверждения отправлен.'
        ]);
    }

    // ======================
    // 3. Подтверждение кода
    // ======================
    public function verifyCode(Request $request)
    {
        $request->validate([
            'phone'             => 'required',
            'verification_code' => 'required|numeric|digits:4',
        ]);

        $user = Auth::user();
        $phone = preg_replace('/\D/', '', $request->input('phone'));
        $verificationCode = $request->input('verification_code');

        // Проверяем код и время
        if ($user->verification_code === $verificationCode 
            && now()->lessThanOrEqualTo($user->verification_code_expires_at)) 
        {
            // Форматируем номер
            $formattedPhone = '+7 (' . substr($phone, 1, 3) . ') '
                            . substr($phone, 4, 3) . '-'
                            . substr($phone, 7, 2) . '-'
                            . substr($phone, 9, 2);

            $user->phone = $formattedPhone;

            // Сбрасываем код
            $user->verification_code = null;
            $user->verification_code_expires_at = null;
            $user->save();

            return response()->json([
                'success' => true, 
                'message' => 'Номер телефона успешно обновлен.'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Неверный или просроченный код.'
        ]);
    }

    // =======================
    // 4. Обновление аватара
    // =======================
    public function updateAvatar(Request $request)
    {
        $validated = $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = Auth::user();

        // Удаление старого аватара, если он есть
        if ($user->avatar_url && file_exists(public_path($user->avatar_url))) {
            unlink(public_path($user->avatar_url));
        }

        $avatar = $request->file('avatar');
        $avatarPath = 'user/avatar/' . $user->id . '/' 
                      . uniqid() . '.' . $avatar->getClientOriginalExtension();

        // Сохранение нового аватара в public/
        $destinationPath = public_path('user/avatar/' . $user->id);
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        $avatar->move($destinationPath, basename($avatarPath));

        // Обновление пути к аватару в базе
        $user->avatar_url = $avatarPath;
        $user->save();

        return redirect()->route('profile')->with('success', 'Аватар успешно обновлен');
    }

    // =======================
    // 5. Удаление аккаунта
    // =======================
    public function deleteAccount()
    {
        try {
            $user = Auth::user();

            // Удаляем аватар из public/, если есть
            if ($user->avatar_url && file_exists(public_path($user->avatar_url))) {
                unlink(public_path($user->avatar_url));
            }

            // Удаляем саму учетную запись
            $user->delete();

            return redirect('/')->with('success', 'Ваш аккаунт был успешно удален');
        } catch (\Exception $e) {
            return redirect()->route('profile')->with('error', 'Ошибка при удалении аккаунта. Попробуйте позже.');
        }
    }

    // =============================
    // 6. Изменение пароля (старое)
    // =============================
    public function changePassword(Request $request)
    {
        $request->validate([
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = auth()->user();
        $user->password = bcrypt($request->new_password);
        $user->save();

        return response()->json([
            'success' => true, 
            'message' => 'Пароль успешно изменен!'
        ]);
    }

    // =========================
    // 7. Обновление профиля
    // (старый метод, если нужен)
    // =========================
    public function updateProfile(Request $request)
    {
        $validatedData = $request->validate([
            'name'  => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . Auth::id(),
        ]);

        $user = Auth::user();

        if ($request->filled('name')) {
            $user->name = $request->name;
        }
        if ($request->filled('email')) {
            $user->email = $request->email;
        }

        $user->save();

        return response()->json([
            'success' => true, 
            'message' => 'Данные успешно обновлены!'
        ]);
    }

    // ======================================================================
    // 8. НОВЫЙ метод, который обновляет ИМЯ, ПОЧТУ и (опционально) ПАРОЛЬ
    //    в одном запросе — для одной формы
    // ======================================================================
    public function updateProfileAll(Request $request)
    {
        // Валидация входных данных
        $request->validate([
            'name'         => 'nullable|string|max:255',
            'email'        => 'nullable|email|unique:users,email,' . Auth::id(),
            'new_password' => 'nullable|min:8|confirmed',
        ]);

        // Текущий пользователь
        $user = Auth::user();

        // Обновляем имя
        if ($request->filled('name')) {
            $user->name = $request->name;
        }
        // Обновляем email
        if ($request->filled('email')) {
            $user->email = $request->email;
        }
        // Обновляем пароль, только если поле new_password не пустое
        if ($request->filled('new_password')) {
            $user->password = Hash::make($request->new_password);
        }

        // Сохраняем изменения
        $user->save();

        // Возвращаем JSON-ответ (можете сделать redirect, если нужно)
        return response()->json([
            'success' => true,
            'message' => 'Данные успешно обновлены!'
        ]);
    }
}
