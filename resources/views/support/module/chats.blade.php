<style>
    .support-container {
        display: flex;
        gap: 20px;
        font-family: Arial, sans-serif;
        padding: 20px;
    }

    .chat-list {
        width: 30%;
        border-right: 1px solid #ddd;
        padding-right: 20px;
    }

    .chat-list h1 {
        font-size: 20px;
        margin-bottom: 10px;
    }

    .chat-item {
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        margin-bottom: 10px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .chat-item:hover {
        background-color: #f4f4f4;
    }

    .chat-item h3 {
        font-size: 16px;
        margin: 0;
    }

    .chat-item p {
        margin: 5px 0 0;
        font-size: 14px;
        color: #555;
    }

    .chat-window {
        width: 70%;
    }

    .chat-window h1 {
        font-size: 20px;
        margin-bottom: 10px;
    }

    .messages {
        max-height: 400px;
        overflow-y: auto;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        margin-bottom: 10px;
        background-color: #f9f9f9;
    }

    .message {
        margin-bottom: 10px;
        padding: 10px;
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 5px;
    }

    .message p {
        margin: 0;
        font-size: 14px;
    }

    .message strong {
        font-weight: bold;
    }

    .chat-form {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .chat-form textarea {
        width: 100%;
        height: 100px;
        padding: 10px;
        font-size: 14px;
        border: 1px solid #ddd;
        border-radius: 5px;
    }

    .chat-form button {
        align-self: flex-end;
        padding: 10px 20px;
        font-size: 14px;
        border: none;
        background-color: #007bff;
        color: #fff;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .chat-form button:hover {
        background-color: #0056b3;
    }
</style>

<div class="support-container">
    <!-- Список чатов -->
    <div class="chat-list">
        <h1>Чаты</h1>
        @foreach ($tickets as $ticket)
            <div class="chat-item">
                <h3>{{ $ticket->title }}</h3>
                <p>Статус: {{ $ticket->status }}</p>
                <a href="{{ route('support.chats', $ticket->id) }}">Открыть чат</a>
            </div>
        @endforeach

    </div>

    <!-- Окно чата -->
    <div class="chat-window">
        @if (isset($selectedTicket) && $selectedTicket)
            <h1>Чат {{ $selectedTicket->title }}</h1>
            <div class="messages">
                @foreach ($messages as $message)
                    <div class="message">
                        <strong>{{ $message->user->name }}:</strong>
                        <p>{{ $message->message }}</p>
                    </div>
                @endforeach
            </div>
            <form action="{{ route('support.chat.reply', $selectedTicket->id) }}" method="POST" class="chat-form">
                @csrf
                <textarea name="message" placeholder="Ваш ответ" required></textarea>
                <button type="submit">Отправить</button>
            </form>
        @else
            <p>Выберите чат из списка, чтобы начать общение.</p>
        @endif
    </div>

</div>
