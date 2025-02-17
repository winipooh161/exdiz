<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use App\Models\Chat;
use App\Models\User;
use App\Models\DealChangeLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log; 
use Illuminate\Support\Str;

class DealsController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    // Отображение списка сделок
    public function dealCardinator(Request $request)
    {
        $title_site = "Сделки Кардинатора";
        $user = Auth::user();
    
        $search = $request->input('search');
        $status = $request->input('status');
        $viewType = $request->input('view_type', 'blocks');
    
        $query = Deal::with('users');
    
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('client_phone', 'LIKE', "%{$search}%")
                  ->orWhere('client_email', 'LIKE', "%{$search}%")
                  ->orWhere('project_number', 'LIKE', "%{$search}%")
                  ->orWhere('package', 'LIKE', "%{$search}%")
                  ->orWhere('deal_note', 'LIKE', "%{$search}%")
                  ->orWhere('client_city', 'LIKE', "%{$search}%")
                  ->orWhere('total_sum', 'LIKE', "%{$search}%");
            });
        }
    
        if ($status) {
            $query->where('status', $status);
        }
    
        $deals = $query->get()->map(function ($deal) {
            // Проверяем, есть ли токен, иначе устанавливаем null
            $deal->registration_token_url = $deal->registration_token
                ? route('register_by_deal', ['token' => $deal->registration_token])
                : null;
            return $deal;
        });
    
        return view('cardinators', compact('title_site', 'user', 'deals', 'status', 'viewType', 'search'));
    }
    

    // Отображение страницы чата сделки
    public function dealUser()
    {
        $user = Auth::user();
    
        if ($user->status === 'partner') {
            return redirect()->route('deal.cardinator');
        }
    
        $title_site = "Чат вашей сделки";
        $userDeals = Deal::with('coordinator', 'users', 'briefs')
            ->where('user_id', $user->id)
            ->get();
    
        $chatController = app(\App\Http\Controllers\ChatController::class);
        $chats = $chatController->getUserChats($user->id);
    
        return view('user', compact('title_site', 'user', 'userDeals', 'chats'));
    }
    
    // Форма создания сделки – доступна для координатора, администратора и партнёра
    public function createDeal()
    {
        $user = Auth::user();
        if (!in_array($user->status, ['coordinator', 'admin'])) {
            return redirect()->route('deal.cardinator')
                ->with('error', 'Только кардинатор, администратор или партнер могут создавать сделку.');
        }
        $title_site = "Создание сделки";

        $citiesFile = public_path('cities.json');
        if (file_exists($citiesFile)) {
            $citiesJson = file_get_contents($citiesFile);
            $russianCities = json_decode($citiesJson, true);
        } else {
            $russianCities = [];
        }

        $responsibleUsers = User::whereIn('status', ['designer', 'coordinator'])->get();
        $coordinators = User::where('status', 'coordinator')->get();
        $partners = User::where('status', 'partner')->get();
        $architects = User::where('status', 'architect')->get();
        $designers   = User::where('status', 'designer')->get();
        $visualizers = User::where('status', 'visualizer')->get();

        return view('create_deal', compact(
            'title_site',
            'user',
            'responsibleUsers',
            'coordinators',
            'partners',
            'architects',
            'designers',
            'visualizers',
            'russianCities'
        ));
    }

    // Сохранение сделки
    public function storeDeal(Request $request)
    {
        $user = Auth::user();
        if (!in_array($user->status, ['coordinator', 'admin'])) {
            return redirect()->route('deal.cardinator')
                ->with('error', 'Только кардинатор или администратор могут создавать сделку.');
        }

        try {
            $validated = $request->validate([
                'name'         => 'required|string|max:255',
                'client_phone' => ['required', 'regex:/^\+7\s\(\d{3}\)\s\d{3}\-\d{2}\-\d{2}$/'],
                'status'       => 'required|in:Ждем ТЗ,Планировка,Коллажи,Визуализация,Рабочка/сбор ИП,Проект готов,Проект завершен,Проект на паузе,Возврат,В работе,Завершенный,На потом,Регистрация,Бриф прикриплен,Поддержка,Активный',
                'priority'     => 'required|in:высокий,средний,низкий',
                'package'      => 'required|string|max:255',
                'project_number'        => 'nullable|string|max:21',
                'price_service_option'  => 'required|string|max:255',
                'rooms_count_pricing'   => 'nullable|integer|min:1',
                'execution_order_comment' => 'nullable|string|max:1000',
                'execution_order_file'  => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
                'client_timezone'       => 'nullable|string|max:100',
                'office_partner_id'     => 'nullable|exists:users,id',
                'coordinator_id'        => 'nullable|exists:users,id',
                'total_sum'      => 'nullable|numeric',
                'measuring_cost' => 'nullable|numeric',
                'project_budget' => 'nullable|numeric',
                'client_info'    => 'nullable|string',
                'payment_date'   => 'nullable|date',
                'execution_comment' => 'nullable|string',
                'comment'        => 'nullable|string',
                'office_equipment' => 'nullable|boolean',
                'measurement_comments' => 'nullable|string|max:1000',
                'measurements_file'    => 'nullable|file|mimes:pdf,jpg,jpeg,png,dwg|max:5120',
                'start_date'           => 'nullable|date',
                'project_duration'     => 'nullable|integer',
                'project_end_date'     => 'nullable|date',
                'architect_id'         => 'nullable|exists:users,id',
                'final_floorplan'      => 'nullable|file|mimes:pdf|max:20480',
                'designer_id'          => 'nullable|exists:users,id',
                'final_collage'        => 'nullable|file|mimes:pdf|max:204800',
                'visualizer_id'        => 'nullable|exists:users,id',
                'visualization_link'   => 'nullable|url',
                'final_project_file'   => 'nullable|file|mimes:pdf|max:204800',
                'work_act'             => 'nullable|file|mimes:pdf|max:10240',
                'client_project_rating'=> 'nullable|numeric',
                'architect_rating_client'   => 'nullable|numeric',
                'architect_rating_partner'  => 'nullable|numeric',
                'architect_rating_coordinator' => 'nullable|numeric',
                'designer_rating_client'    => 'nullable|numeric',
                'designer_rating_partner'   => 'nullable|numeric',
                'designer_rating_coordinator' => 'nullable|numeric',
                'visualizer_rating_client'  => 'nullable|numeric',
                'visualizer_rating_partner' => 'nullable|numeric',
                'visualizer_rating_coordinator' => 'nullable|numeric',
                'coordinator_rating_client'  => 'nullable|numeric',
                'coordinator_rating_partner' => 'nullable|numeric',
                'coordinator_comment'        => 'nullable|string',
                'chat_screenshot'        => 'nullable|image|mimes:jpeg,jpg,png|max:5120',
                'archicad_file'          => 'nullable|file|mimes:pln,dwg|max:307200',
                'contract_number'   => 'required|string|max:100',
                'contract_attachment' => 'nullable|file|mimes:pdf,jpeg,jpg,png|max:5120',
                'deal_note'         => 'nullable|string',
                'avatar'            => 'required|image|mimes:jpg,jpeg,png,gif|max:5120',
                'responsibles'      => 'nullable|array',
                'responsibles.*'    => 'exists:users,id',
            ]);

            $office_equipment = $request->has('office_equipment') ? 1 : 0;
            $coordinatorId = $validated['coordinator_id'] ?? auth()->id();

            $deal = Deal::create([
                'name'         => $validated['name'],
                'client_phone' => $validated['client_phone'],
                'status'       => $validated['status'],
                'priority'     => $validated['priority'],
                'package'      => $validated['package'],
                'client_name'  => $validated['name'],
                'project_number' => $validated['project_number'] ?? null,
                'price_service' => $validated['price_service_option'],
                'rooms_count_pricing' => $validated['rooms_count_pricing'] ?? null,
                'execution_order_comment' => $validated['execution_order_comment'] ?? null,
                'client_timezone' => $validated['client_timezone'] ?? null,
                'office_partner_id' => $validated['office_partner_id'] ?? null,
                'coordinator_id' => $coordinatorId,
                'total_sum' => $validated['total_sum'] ?? null,
                'measuring_cost' => $validated['measuring_cost'] ?? null,
                'project_budget' => $validated['project_budget'] ?? null,
                'client_info' => $validated['client_info'] ?? null,
                'payment_date' => $validated['payment_date'] ?? null,
                'execution_comment' => $validated['execution_comment'] ?? null,
                'comment' => $validated['comment'] ?? null,
                'office_equipment' => $office_equipment,
                'measurement_comments' => $validated['measurement_comments'] ?? null,
                'start_date' => $validated['start_date'] ?? null,
                'project_duration' => $validated['project_duration'] ?? null,
                'project_end_date' => $validated['project_end_date'] ?? null,
                'architect_id' => $validated['architect_id'] ?? null,
                'designer_id' => $validated['designer_id'] ?? null,
                'visualizer_id' => $validated['visualizer_id'] ?? null,
                'visualization_link' => $validated['visualization_link'] ?? null,
                'final_floorplan' => null,
                'final_collage' => null,
                'final_project_file' => null,
                'client_project_rating' => $validated['client_project_rating'] ?? null,
                'architect_rating_client' => $validated['architect_rating_client'] ?? null,
                'architect_rating_partner' => $validated['architect_rating_partner'] ?? null,
                'architect_rating_coordinator' => $validated['architect_rating_coordinator'] ?? null,
                'designer_rating_client' => $validated['designer_rating_client'] ?? null,
                'designer_rating_partner' => $validated['designer_rating_partner'] ?? null,
                'designer_rating_coordinator' => $validated['designer_rating_coordinator'] ?? null,
                'visualizer_rating_client' => $validated['visualizer_rating_client'] ?? null,
                'visualizer_rating_partner' => $validated['visualizer_rating_partner'] ?? null,
                'visualizer_rating_coordinator' => $validated['visualizer_rating_coordinator'] ?? null,
                'coordinator_rating_client' => $validated['coordinator_rating_client'] ?? null,
                'coordinator_rating_partner' => $validated['coordinator_rating_partner'] ?? null,
                'coordinator_comment' => $validated['coordinator_comment'] ?? null,
                'contract_number' => $validated['contract_number'],
                'deal_note' => $validated['deal_note'] ?? null,
                'user_id' => auth()->id(),
                'registration_token' => Str::random(32),
                'registration_token_expiry' => now()->addDays(7),
            ]);

            // Обработка загрузки файлов
            $fileFields = [
                'avatar',
                'execution_order_file',
                'measurements_file',
                'final_floorplan',
                'final_collage',
                'final_project_file',
                'work_act',
                'chat_screenshot',
                'archicad_file',
                'contract_attachment',
            ];

            foreach ($fileFields as $field) {
                $uploadData = $this->handleFileUpload($request, $deal, $field, $field === 'avatar' ? 'avatar_path' : $field);
                if (!empty($uploadData)) {
                    $deal->update($uploadData);
                }
            }

            // Прикрепляем пользователей
            $responsibles = $request->input('responsibles', []);
            $deal->users()->attach([auth()->id() => ['role' => 'coordinator']]);
            foreach ($responsibles as $respId) {
                if ($respId != auth()->id()) {
                    $deal->users()->attach([$respId => ['role' => 'responsible']]);
                }
            }

            $this->createGroupChat($deal, array_merge([auth()->id()], $responsibles));
            $this->sendSmsNotification($deal, $deal->registration_token);

            return redirect()->route('deal.cardinator')->with('success', 'Сделка успешно создана.');
        } catch (\Exception $e) {
            Log::error("Ошибка при создании сделки: " . $e->getMessage());
            return redirect()->back()->with('error', 'Ошибка при создании сделки.');
        }
    }

    // Редактирование сделки с учётом роли (координатор и партнер)
    public function updateDeal(Request $request, $id)
    {
        $deal = Deal::findOrFail($id);
        $user = Auth::user();
        $userRole = $user->status;

        if ($userRole == 'coordinator' || $userRole == 'admin') {
            $rules = [
                'project_number' => 'nullable|string|max:21',
                'status'         => 'nullable|in:Ждем ТЗ,Планировка,Коллажи,Визуализация,Рабочка/сбор ИП,Проект готов,Проект завершен,Проект на паузе,Возврат,В работе,Завершенный,На потом,Регистрация,Бриф прикриплен,Поддержка,Активный',
                'start_date'         => 'nullable|date',
                'project_duration'   => 'nullable|integer',
                'project_end_date'   => 'nullable|date',
                'architect_id'       => 'nullable|exists:users,id',
                'final_floorplan'    => 'nullable|file|mimes:pdf|max:20480',
                'designer_id'        => 'nullable|exists:users,id',
                'final_collage'      => 'nullable|file|mimes:pdf|max:204800',
                'visualizer_id'      => 'nullable|exists:users,id',
                'visualization_link' => 'nullable|url',
                'final_project_file' => 'nullable|file|mimes:pdf|max:204800',
                'work_act'             => 'nullable|file|mimes:pdf|max:10240',
                'client_project_rating'=> 'nullable|numeric',
                'architect_rating_client'   => 'nullable|numeric',
                'architect_rating_partner'  => 'nullable|numeric',
                'architect_rating_coordinator' => 'nullable|numeric',
                'designer_rating_client'    => 'nullable|numeric',
                'designer_rating_partner'   => 'nullable|numeric',
                'designer_rating_coordinator' => 'nullable|numeric',
                'visualizer_rating_client'  => 'nullable|numeric',
                'visualizer_rating_partner' => 'nullable|numeric',
                'visualizer_rating_coordinator' => 'nullable|numeric',
                'coordinator_rating_client' => 'nullable|numeric',
                'coordinator_rating_partner'=> 'nullable|numeric',
                'coordinator_comment'     => 'nullable|string',
                'chat_screenshot'         => 'nullable|image|mimes:jpeg,jpg,png|max:5120',
                'archicad_file'           => 'nullable|file|mimes:pln,dwg|max:307200',
                'avatar'                  => 'nullable|image|mimes:jpg,jpeg,png,gif|max:5120'
            ];
        } elseif ($userRole == 'partner') {
            $rules = [
                'price_service_option'   => 'nullable|string|max:255',
                'rooms_count_pricing'    => 'nullable|integer|min:1',
                'execution_order_comment'=> 'nullable|string|max:1000',
                'package'                => 'nullable|string|max:255',
                'name'                   => 'nullable|string|max:255',
                'client_phone'           => ['nullable', 'regex:/^\+7\s\(\d{3}\)\s\d{3}\-\d{2}\-\d{2}$/'],
                'client_timezone'        => 'nullable|string|max:100',
                'office_partner_id'      => 'nullable|exists:users,id',
                'completion_responsible' => 'nullable|string|max:255',
                'measurement_comments'   => 'nullable|string|max:1000',
                'measurements_file'      => 'nullable|file|mimes:pdf,dwg,jpeg,jpg,png|max:5120',
                'contract_number'        => 'nullable|string|max:100',
                'payment_date'           => 'nullable|date',
                'total_sum'              => 'nullable|numeric',
                'contract_attachment'    => 'nullable|file|mimes:pdf,jpeg,jpg,png|max:5120',
                'deal_note'              => 'nullable|string',
                'avatar'                 => 'nullable|image|mimes:jpg,jpeg,png,gif|max:5120'
            ];
        } else {
            return redirect()->back()->with('error', 'У вас нет прав для редактирования этой сделки.');
        }

        $validated = $request->validate($rules);
        $originalData = $deal->getAttributes();
        $dataToUpdate = $validated;

        $fileFields = [];
        if ($userRole == 'coordinator') {
            $fileFields = ['final_floorplan', 'final_collage', 'final_project_file', 'work_act', 'chat_screenshot', 'archicad_file', 'avatar'];
        } elseif ($userRole == 'partner') {
            $fileFields = ['measurements_file', 'contract_attachment', 'avatar'];
        }

        foreach ($fileFields as $field) {
            $uploadData = $this->handleFileUpload($request, $deal, $field, $field);
            if (!empty($uploadData)) {
                $dataToUpdate = array_merge($dataToUpdate, $uploadData);
            }
        }

        $deal->update($dataToUpdate);
        $this->logDealChanges($deal, $originalData, $deal->getAttributes());

        return redirect()->back()->with('success', 'Сделка успешно обновлена.');
    }

    /**
     * Логирование изменений сделки.
     */
    protected function logDealChanges($deal, $original, $new)
    {
        foreach (['updated_at', 'created_at'] as $key) {
            unset($original[$key], $new[$key]);
        }

        $changes = [];
        foreach ($new as $key => $newValue) {
            if (array_key_exists($key, $original) && $original[$key] != $newValue) {
                $changes[$key] = [
                    'old' => $original[$key],
                    'new' => $newValue,
                ];
            }
        }

        if (!empty($changes)) {
            DealChangeLog::create([
                'deal_id'   => $deal->id,
                'user_id'   => Auth::id(),
                'user_name' => Auth::user()->name,
                'changes'   => $changes,
            ]);
        }
    }

    /**
     * Вывод логов изменений по сделке.
     */
    public function changeLogsForDeal(Request $request, $dealId)
    {
        $deal = Deal::findOrFail($dealId);

        if (!in_array(Auth::user()->status, ['coordinator', 'admin'])) {
            return redirect()->back()->with('error', 'Доступ запрещён.');
        }

        $logs = DealChangeLog::where('deal_id', $deal->id)->orderBy('created_at', 'desc')->get();
        $title_site = "Аудит изменений сделки: " . $deal->name;

        return view('deal_change_logs', compact('logs', 'title_site', 'deal'));
    }

    /**
     * Метод для общего просмотра логов (по всем сделкам).
     */
    public function changeLogs(Request $request)
    {
        if (!in_array(Auth::user()->status, ['coordinator', 'admin'])) {
            return redirect()->back()->with('error', 'Доступ запрещён.');
        }

        $logs = DealChangeLog::orderBy('created_at', 'desc')->paginate(20);
        $title_site = "Аудит изменений сделок";

        return view('deal_change_logs', compact('logs', 'title_site'));
    }

    public function showDealChat($dealId)
    {
        $deal = Deal::findOrFail($dealId);
        $groupChat = Chat::where('deal_id', $deal->id)
            ->where('type', 'group')
            ->first();
        if (!$groupChat) {
            return redirect()->back()->with('error', 'Групповой чат для сделки не найден.');
        }
        $title_site = "";
        $user = Auth::user();
        return view('deal_group_chat', compact('title_site', 'user', 'deal', 'groupChat'));
    }

    public function removeExpiredDeals()
    {
        // Оптимизированное удаление просроченных сделок
        Deal::where('registration_token_expiry', '<', now())->each(function($deal) {
            $deal->delete();
        });
        return redirect()->route('deal.cardinator')->with('success', 'Просроченные сделки удалены.');
    }

    private function createGroupChat($deal, $userIds)
    {
        $chat = Chat::create([
            'deal_id' => $deal->id,
            'name'    => "Групповой чат: {$deal->name}",
            'type'    => 'group',
        ]);
        foreach ($userIds as $userId) {
            $chat->users()->attach($userId);
        }
    }

    private function sendSmsNotification($deal, $registrationToken)
    {
        if (!$registrationToken) {
            Log::error("Отсутствует регистрационный токен для сделки ID: {$deal->id}");
            throw new \Exception('Отсутствует регистрационный токен для сделки.');
        }
        $rawPhone = preg_replace('/\D/', '', $deal->client_phone);
        $registrationLinkUrl = route('register_by_deal', ['token' => $registrationToken]);
        $apiKey = '6CDCE0B0-6091-278C-5145-360657FF0F9B';
        $response = Http::get("https://sms.ru/sms/send", [
            'api_id'    => $apiKey,
            'to'        => $rawPhone,
            'msg'       => "Здравствуйте! Для регистрации пройдите по ссылке: $registrationLinkUrl",
            'partner_id'=> 1,
        ]);
        if ($response->failed()) {
            Log::error("Ошибка при отправке SMS для сделки ID: {$deal->id}. Ответ сервера: " . $response->body());
            throw new \Exception('Ошибка при отправке SMS.');
        }
    }

    /**
     * Метод для обработки загрузки файлов.
     *
     * @param Request $request
     * @param Deal $deal
     * @param string $field
     * @param string|null $targetField Если указано, то используется для обновления модели
     * @return array
     */
    private function handleFileUpload(Request $request, $deal, $field, $targetField = null)
    {
        if ($request->hasFile($field) && $request->file($field)->isValid()) {
            $dir = "dels/{$deal->id}";
            $extension = $request->file($field)->getClientOriginalExtension();
            $fileName = $field . '.' . $extension;
            $filePath = $request->file($field)->storeAs($dir, $fileName, 'public');
            return [$targetField ?? $field => $filePath];
        }
        return [];
    }
}
