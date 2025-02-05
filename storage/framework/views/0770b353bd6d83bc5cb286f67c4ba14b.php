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
        <h1>Чаты поддержки</h1>
        <?php $__currentLoopData = $tickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="chat-item">
                <h3><?php echo e($ticket->title); ?></h3>
                <p>Статус: <?php echo e($ticket->status); ?></p>
                <a href="<?php echo e(route('support.chat', $ticket->id)); ?>">Открыть чат</a>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <!-- Окно чата -->
    <div class="chat-window">
        <?php if($selectedTicket): ?>
            <h1>Чат поддержки: <?php echo e($selectedTicket->title); ?></h1>
            <div class="messages">
                <?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="message">
                        <strong><?php echo e($message->user->name); ?>:</strong>
                        <p><?php echo e($message->message); ?></p>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <form action="<?php echo e(route('support.chat.reply', $selectedTicket->id)); ?>" method="POST" class="chat-form">
                <?php echo csrf_field(); ?>
                <textarea name="message" placeholder="Ваш ответ" required></textarea>
                <button type="submit">Отправить</button>
            </form>
        <?php else: ?>
            <p>Выберите чат из списка, чтобы начать общение.</p>
        <?php endif; ?>
    </div>
</div>
<?php /**PATH C:\OSPanel\domains\dlk\resources\views\support\module\chat.blade.php ENDPATH**/ ?>