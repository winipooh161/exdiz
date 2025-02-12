<div class="chat-container">
    <!-- Список чатов -->
    <div class="chat-list">
        <?php $__currentLoopData = $chats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="chat-item <?php echo e($currentChatId === $chat['id'] ? 'Активный' : ''); ?>"
                 wire:click="$emit('selectChat', <?php echo e($chat['id']); ?>)">
                <img src="<?php echo e($chat['avatar_url']); ?>" alt="Avatar" class="avatar">
                <div class="chat-info">
                    <h4><?php echo e($chat['name']); ?></h4>
                    <p><?php echo e($chat['unread_count'] > 0 ? '(' . $chat['unread_count'] . ' новых)' : 'Нет новых сообщений'); ?></p>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <!-- Окно сообщений -->
    <div class="chat-window">
        <?php if($currentChatId): ?>
            <div class="messages">
                <?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="message <?php echo e($message->sender_id === $userId ? 'sent' : 'received'); ?>">
                        <p><?php echo e($message->message); ?></p>
                        <small><?php echo e($message->created_at->format('H:i')); ?></small>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <!-- Отправка нового сообщения -->
            <div class="send-message">
                <input type="text" wire:model="newMessage" placeholder="Введите сообщение...">
                <button wire:click="sendMessage">Отправить</button>
            </div>
        <?php else: ?>
            <div class="no-chat">
                <p>Выберите чат, чтобы начать общение.</p>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php /**PATH C:\OSPanel\domains\dlk\resources\views\livewire\chat.blade.php ENDPATH**/ ?>