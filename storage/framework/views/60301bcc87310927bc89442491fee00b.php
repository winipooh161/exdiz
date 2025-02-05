<div class="chat-message">
    <strong><?php echo e($message->user->name); ?></strong>
    <p><?php echo e($message->content); ?></p> 
    <span><?php echo e($message->created_at->format('d.m.Y H:i')); ?></span>
</div>
<?php /**PATH C:\OSPanel\domains\dlk\resources\views\chats\partials\message.blade.php ENDPATH**/ ?>