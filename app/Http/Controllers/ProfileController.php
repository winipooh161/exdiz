<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Применяем middleware для проверки аутентификации.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    // ===================================
    // 1. Отображение собственного профиля
    // ===================================
    public function index()
    {
        $user = Auth::user();
        $title_site = "Профиль аккаунта | Личный кабинет Экспресс-дизайн";
        return view('profile', compact('user', 'title_site'));
    }

    // ================================================================
    // 2. Просмотр профиля другого пользователя (новый метод)
    // ================================================================
    public function viewProfile($id)
    {
        $viewer = Auth::user();
        $target = User::findOrFail($id);

        // Если запрашивается собственный профиль, перенаправляем на страницу профиля
        if ($viewer->id === $target->id) {
            return redirect()->route('profile');
        }

        // Проверяем, имеет ли текущий пользователь право просматривать профиль $target
        if (!$this->canViewProfile($viewer, $target)) {
            abort(403, 'Доступ запрещён.');
        }

        return view('profile_view', ['target' => $target]);
    }

    /**
     * Проверка возможности просмотра профиля другого пользователя.
     *
     * @param  \App\Models\User  $viewer  Текущий (просматривающий) пользователь
     * @param  \App\Models\User  $target  Просматриваемый профиль
     * @return bool
     */
    protected function canViewProfile($viewer, $target)
    {
        // Всегда разрешаем просмотр своего профиля
        if ($viewer->id === $target->id) {
            return true;
        }

        // Приводим роль просматривающего к нижнему регистру для корректного сравнения
        $viewerRole = strtolower($viewer->role);

        // Координатор и администратор видят все профили
        if (in_array($viewerRole, ['coordinator', 'admin'])) {
            return true;
        }

        // Остальные правила в зависимости от роли просматривающего
        switch ($viewerRole) {
            case 'user':
                return in_array(strtolower($target->role), ['partner', 'coordinator', 'architect', 'designer']);
            case 'partner':
                return in_array(strtolower($target->role), ['coordinator', 'architect', 'designer']);
            case 'architect':
            case 'designer':
                return in_array(strtolower($target->role), ['client', 'coordinator']);
            default:
                return false;
        }
    }

    // ===========================================
    // 3. Отправка кода подтверждения на телефон
    // ===========================================
    public function sendVerificationCode(Request $request)
    {
        $request->validate([
            'phone' => 'required',
        ]);

        $user = Auth::user();

        // Удаляем все нецифровые символы из номера телефона
        $rawPhone = preg_replace('/\D/', '', $request->input('phone'));

        // Формируем форматированный номер телефона: +7 (XXX) XXX-XX-XX
        $formattedPhone = '+7 (' . substr($rawPhone, 1, 3) . ') ' 
                         . substr($rawPhone, 4, 3) 
                         . '-' 
                         . substr($rawPhone, 7, 2) 
                         . '-' 
                         . substr($rawPhone, 9);

        $verificationCode = rand(1000, 9999);
        $apiKey = '6CDCE0B0-6091-278C-5145-360657FF0F9B'; // Пример API-ключа

        // Отправка кода через SMS.RU (пример)
        $response = Http::get("https://sms.ru/sms/send", [
            'api_id' => $apiKey,
            'to'     => $rawPhone,
            'msg'    => "Ваш код: $verificationCode",
        ]);

        if ($response->failed()) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка при отправке SMS.'
            ]);
        }

        // Сохраняем код и время истечения срока действия
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

    // ================================================
    // 4. Подтверждение кода подтверждения телефона
    // ================================================
    public function verifyCode(Request $request)
    {
        $request->validate([
            'phone'             => 'required',
            'verification_code' => 'required|numeric|digits:4',
        ]);

        $user = Auth::user();
        $phone = preg_replace('/\D/', '', $request->input('phone'));
        $verificationCode = $request->input('verification_code');

        if ($user->verification_code == $verificationCode 
            && now()->lessThanOrEqualTo($user->verification_code_expires_at)) 
        {
            $formattedPhone = '+7 (' . substr($phone, 1, 3) . ') '
                            . substr($phone, 4, 3) . '-'
                            . substr($phone, 7, 2) . '-'
                            . substr($phone, 9, 2);

            $user->phone = $formattedPhone;
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

    // =======================================
    // 5. Обновление аватара пользователя
    // =======================================
    public function updateAvatar(Request $request)
    {
        $validated = $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = Auth::user();

        // Удаление старого аватара, если он существует
        if ($user->avatar_url && file_exists(public_path($user->avatar_url))) {
            unlink(public_path($user->avatar_url));
        }

        $avatar = $request->file('avatar');
        $avatarPath = 'user/avatar/' . $user->id . '/' . uniqid() . '.' . $avatar->getClientOriginalExtension();

        $destinationPath = public_path('user/avatar/' . $user->id);
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        $avatar->move($destinationPath, basename($avatarPath));
        $user->avatar_url = $avatarPath;
        $user->save();

        return redirect()->route('profile')->with('success', 'Аватар успешно обновлен');
    }

    // =======================================
    // 6. Удаление аккаунта пользователя
    // =======================================
    public function deleteAccount()
    {
        try {
            $user = Auth::user();

            if ($user->avatar_url && file_exists(public_path($user->avatar_url))) {
                unlink(public_path($user->avatar_url));
            }

            $user->delete();

            return redirect('/')->with('success', 'Ваш аккаунт был успешно удален');
        } catch (\Exception $e) {
            return redirect()->route('profile')->with('error', 'Ошибка при удалении аккаунта. Попробуйте позже.');
        }
    }

    // ========================================
    // 7. Изменение пароля (старый метод)
    // ========================================
    public function changePassword(Request $request)
    {
        $request->validate([
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();
        $user->password = bcrypt($request->new_password);
        $user->save();

        return response()->json([
            'success' => true, 
            'message' => 'Пароль успешно изменен!'
        ]);
    }

    // ========================================
    // 8. Обновление профиля (старый метод)
    // ========================================
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

    // ================================================================
    // 9. Новый метод: обновление имени, email и (опционально) пароля за один запрос
    // ================================================================
    public function updateProfileAll(Request $request)
    {
        $this->authorize('update', Auth::user());
        
        $request->validate([
            'name'         => 'nullable|string|max:255',
            'email'        => 'nullable|email|unique:users,email,' . Auth::id(),
            'new_password' => 'nullable|min:8|confirmed',
        ]);

        $user = Auth::user();

        if ($request->filled('name')) {
            $user->name = $request->name;
        }
        if ($request->filled('email')) {
            $user->email = $request->email;
        }
        if ($request->filled('new_password')) {
            $user->password = Hash::make($request->new_password);
        }

        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Данные успешно обновлены!'
        ]);
    }
}
