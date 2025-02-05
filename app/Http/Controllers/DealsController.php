<?php

namespace App\Http\Controllers;

use App\Models\Common;
use App\Models\Commercial;
use App\Models\News;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\Deal;
use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Http;

class DealsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Show the application home.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dealCardinator(Request $request)
    {
        $title_site = "Сделки Кардинатора";
        $user = Auth::user();

        // Если есть входящие данные (search/status/view_type),
        // записываем их в сессию. 
        // Можно задать более точную логику: «если нажата кнопка «Применить» или что-то ещё»
        if ($request->hasAny(['search', 'status', 'view_type'])) {
            // Сохраняем в сессии все параметры фильтра одним массивом
            session([
                'dealFilters' => [
                    'search'   => $request->input('search'),
                    'status'   => $request->input('status'),
                    'viewType' => $request->input('view_type', 'blocks')
                ]
            ]);
        }

        // Читаем данные фильтров из сессии, если там что-то есть
        // Если в сессии ничего не лежит, задаём дефолты
        $filters = session('dealFilters', [
            'search'   => null,
            'status'   => null,
            'viewType' => 'blocks'
        ]);

        // Для наглядности
        $search   = $filters['search'];
        $status   = $filters['status'];
        $viewType = $filters['viewType'];

        // Формируем запрос с учётом фильтров
        $query = Deal::with('users');

        if ($search) {
            $query->where('name', 'LIKE', "%{$search}%")
                ->orWhere('client_phone', 'LIKE', "%{$search}%");
        }

        if ($status) {
            $query->where('status', $status);
        }

        $deals = $query->get();

        return view('cardinators', compact('title_site', 'user', 'deals', 'viewType', 'search', 'status'));
    }


    // App\Http\Controllers\DealsController.php

    public function dealUser()
    {
        $title_site = "Чат вашей сделки";
        $user = Auth::user();

        // Ваши сделки
        $userDeals = Deal::with('coordinator', 'users', 'briefs')
            ->where('user_id', $user->id)
            ->get();

        // Получаем список чатов для текущего пользователя
        $chatController = app(\App\Http\Controllers\ChatController::class);
        $chats = $chatController->getUserChats($user->id);

        return view('user', compact('title_site', 'user', 'userDeals', 'chats'));
    }




    public function createDeal()
    {
        $user = Auth::user();
        $title_site = "Создание сделки";
        $users = User::where('status', 'coordinator')->get(); // Или другой статус
        return view('create_deal', compact('title_site', 'users', 'user'));
    }

    public function storeDeal(Request $request)
    {
        $validated = $request->validate([
            // ФИО клиента
            'name' => [
                'required',
                'string',
                'max:255',
                // Пример паттерна: только буквы, пробелы, дефисы
                'regex:/^[\pL\s\-]+$/u'
            ],
            // Телефон
            'client_phone' => [
                'required',
                'string',
                // Регулярка для +7 (XXX) XXX-XX-XX
                'regex:/^\+7\s\(\d{3}\)\s\d{3}\-\d{2}\-\d{2}$/'
            ],
            'completion_responsible' => 'nullable|string|max:255',
            'office_equipment'       => 'nullable|boolean',
            'stage'                  => 'nullable|string|max:255',
            'coordinator_score'      => 'nullable|numeric|min:0|max:10',
            'client_city'            => 'nullable|string|max:100',

            'total_sum'      => 'nullable|numeric|min:0',
            'measuring_cost' => 'nullable|numeric|min:0',
            'project_budget' => 'nullable|numeric|min:0',
            'created_date'   => 'nullable|date',
            'deal_end_date'  => 'nullable|date',
            'client_info'    => 'nullable|string',
            'payment_date'   => 'nullable|date',
            'package'        => 'nullable|string|max:255',
            'rooms_count'    => 'nullable|integer|min:1',
            'execution_comment' => 'nullable|string',
            'comment'           => 'nullable|string',

            // Статус
            'status' => 'required|in:в работе,Завершенный,На потом',

            // Ответственные
            'responsibles'   => 'nullable|array',
            'responsibles.*' => 'exists:users,id',

            // Аватар
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        // Ставим office_equipment = 1, если чекбокс есть, иначе 0
        $office_equipment = $request->has('office_equipment') ? 1 : 0;

        // Создание сделки
        $deal = Deal::create([
            'name'                   => $validated['name'],
            'client_phone'           => $validated['client_phone'],
            'status'                 => $validated['status'],

            'completion_responsible' => $validated['completion_responsible'] ?? null,
            'office_equipment'       => $office_equipment,
            'stage'                  => $validated['stage'] ?? null,
            'coordinator_score'      => $validated['coordinator_score'] ?? null,
            'client_city'            => $validated['client_city'] ?? null,
            'total_sum'              => $validated['total_sum'] ?? null,
            'measuring_cost'         => $validated['measuring_cost'] ?? null,
            'project_budget'         => $validated['project_budget'] ?? null,
            'created_date'           => $validated['created_date'] ?? null,
            'deal_end_date'          => $validated['deal_end_date'] ?? null,
            'client_info'            => $validated['client_info'] ?? null,
            'payment_date'           => $validated['payment_date'] ?? null,
            'package'                => $validated['package'] ?? null,
            'rooms_count'            => $validated['rooms_count'] ?? null,
            'execution_comment'      => $validated['execution_comment'] ?? null,
            'comment'                => $validated['comment'] ?? null,

            // Обязательные
            'user_id'                => auth()->id(),
            'coordinator_id'         => auth()->id(),
            'registration_token'     => Str::random(32),
            'registration_token_expiry' => now()->addDays(7),
        ]);

        // Сохранение аватара
        if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
            $avatarDir = "dels/{$deal->id}";
            $avatarExt = $request->file('avatar')->getClientOriginalExtension();
            $avatarPath = $request->file('avatar')->storeAs(
                $avatarDir,
                'avatar.' . $avatarExt,
                'public'
            );
            $deal->update(['avatar_path' => "storage/{$avatarPath}"]);
        }

        // Привязка ответственных
        $responsibles = $request->input('responsibles', []);
        // Добавляем текущего пользователя (координатора)
        $deal->users()->attach([auth()->id() => ['role' => 'coordinator']]);
        foreach ($responsibles as $respId) {
            if ($respId != auth()->id()) {
                $deal->users()->attach([$respId => ['role' => 'responsible']]);
            }
        }

        // Создание группового чата (если нужно)
        $this->createGroupChat($deal, array_merge([auth()->id()], $responsibles));

        // Отправка SMS (при необходимости)
        $this->sendSmsNotification($deal, $deal->registration_token);

        return redirect()->route('deal.cardinator')
            ->with('success', 'Сделка успешно создана.');
    }




    private function createGroupChat($deal, $userIds)
    {
        $chat = Chat::create([
            'deal_id' => $deal->id,
            'name' => "Групповой чат: {$deal->name}",
            'type' => 'group',
        ]);

        foreach ($userIds as $userId) {
            $chat->users()->attach($userId);
        }
    }





    /**
     * Отправка SMS с регистрационной ссылкой.
     *
     * @param Deal $deal
     * @param string $registrationLink
     */
    private function sendSmsNotification($deal, $registrationToken)
    {
        if (!$registrationToken) {
            throw new \Exception('Отсутствует регистрационный токен для сделки.');
        }

        $rawPhone = preg_replace('/\D/', '', $deal->client_phone);

        $registrationLinkUrl = route('register_by_deal', ['token' => $registrationToken]);

        $apiKey = '6CDCE0B0-6091-278C-5145-360657FF0F9B';

        $response = Http::get("https://sms.ru/sms/send", [
            'api_id' => $apiKey,
            'to' => $rawPhone,
            'msg' => "Здравствуйте! Для регистрации пройдите по следующей ссылке: $registrationLinkUrl",
            'partner_id' => 1,
        ]);

        if ($response->failed()) {
            throw new \Exception('Ошибка при отправке SMS.');
        }
    }




    // Существующие методы

    /**
     * Удаление просроченных сделок.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeExpiredDeals()
    {
        // Получаем все сделки, у которых срок действия ссылки истек
        $expiredDeals = Deal::where('registration_link_expiry', '<', now())->get();

        // Удаляем каждую просроченную сделку
        foreach ($expiredDeals as $deal) {
            $deal->delete();  // Удаление сделки
        }

        return redirect()->route('deal.cardinator')->with('success', 'Просроченные сделки удалены.');
    }


    // -------------------------------------------
    // РЕДАКТИРОВАНИЕ СДЕЛКИ
    // -------------------------------------------
    public function updateDeal(Request $request, $id)
    {
        // 1) Найти сделку
        $deal = Deal::findOrFail($id);

        // 2) Проверить права
        if ($deal->coordinator_id !== Auth::id()) {
            return redirect()->back()
                ->with('error', 'У вас нет прав для редактирования этой сделки.');
        }

        // ------------------
        // 3) Валидация
        // ------------------
        $validated = $request->validate([
            // Поля могут быть не обязательны, но проверяем тип
            'name' => [
                'nullable',
                'string',
                'max:255',
                'regex:/^[\pL\s\-]+$/u' // разрешаем буквы, пробелы, дефисы
            ],
            'client_phone' => [
                'nullable',
                'string',
                'regex:/^\+7\s\(\d{3}\)\s\d{3}\-\d{2}\-\d{2}$/'
            ],
            'status' => 'nullable|in:в работе,Завершенный,На потом',

            'completion_responsible' => 'nullable|string|max:255',
            'office_equipment'       => 'nullable|boolean',
            'stage'                  => 'nullable|string|max:255',
            'coordinator_score'      => 'nullable|numeric|min:0|max:10',
            'client_city'            => 'nullable|string|max:100',
            'total_sum'              => 'nullable|numeric|min:0',
            'measuring_cost'         => 'nullable|numeric|min:0',
            'project_budget'         => 'nullable|numeric|min:0',
            'created_date'           => 'nullable|date',
            'deal_end_date'          => 'nullable|date',
            'client_info'            => 'nullable|string',
            'payment_date'           => 'nullable|date',
            'package'                => 'nullable|string|max:255',
            'rooms_count'            => 'nullable|integer|min:1',
            'execution_comment'      => 'nullable|string',
            'comment'                => 'nullable|string',

            // Если хотим менять ответственных, можно так же:
            'responsibles'   => 'nullable|array',
            'responsibles.*' => 'exists:users,id',

            // avatar (если хотим разрешать менять)
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        // 4) Обрабатываем office_equipment
        $office_equipment = $request->has('office_equipment') ? 1 : 0;

        // 5) Собираем данные для обновления
        $dataToUpdate = [
            'office_equipment' => $office_equipment,
        ];

        // Если поле есть в $validated — добавляем
        // (Другой вариант — сразу $deal->update($validated), затем перезаписать office_equipment)
        foreach (
            [
                'name',
                'client_phone',
                'status',
                'completion_responsible',
                'stage',
                'coordinator_score',
                'client_city',
                'total_sum',
                'measuring_cost',
                'project_budget',
                'created_date',
                'deal_end_date',
                'client_info',
                'payment_date',
                'package',
                'rooms_count',
                'execution_comment',
                'comment'
            ] as $field
        ) {
            if (array_key_exists($field, $validated)) {
                $dataToUpdate[$field] = $validated[$field];
            }
        }

        // 6) Если загружаем новый avatar
        if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
            $avatarDir = "dels/{$deal->id}";
            $avatarExt = $request->file('avatar')->getClientOriginalExtension();
            $avatarPath = $request->file('avatar')->storeAs($avatarDir, 'avatar.' . $avatarExt, 'public');
            $dataToUpdate['avatar_path'] = "storage/{$avatarPath}";
        }

        // 7) Обновляем сделку
        $deal->update($dataToUpdate);

        // 8) Если нужно обновлять ответственных
        if (array_key_exists('responsibles', $validated)) {
            // Перепривязка pivot (пример: сначала отвязать всех, потом заново)
            $deal->users()->detach();

            // Назначить текущего пользователя = координатор
            $deal->users()->attach([Auth::id() => ['role' => 'coordinator']]);

            foreach ($validated['responsibles'] as $respId) {
                if ($respId != Auth::id()) {
                    $deal->users()->attach([$respId => ['role' => 'responsible']]);
                }
            }
        }

        return redirect()->back()
            ->with('success', 'Сделка успешно обновлена.');
    }
    public function showDealChat($dealId)
    {
        // 1. Найти сделку
        $deal = Deal::findOrFail($dealId);

        // 2. Найти групповой чат этой сделки
        //    Предполагаем, что Chat имеет поле `deal_id` + `type = group`
        //    и что он гарантированно существует (или нужно обработать ситуацию,
        //    если чата ещё нет).
        $groupChat = Chat::where('deal_id', $deal->id)
            ->where('type', 'group')
            ->first();

        // Если чата нет — по ситуации:
        // либо создать, либо вернуть ошибку/редирект
        if (!$groupChat) {
            return redirect()->back()->with('error', 'Групповой чат для сделки не найден.');
        }

        // 3. Передаём данные во вьюшку
        $title_site = "";
        $user = Auth::user();

        return view('deal_group_chat', compact('title_site', 'user', 'deal', 'groupChat'));
    }
}
