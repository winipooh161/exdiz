
<div class="container">
    <h1>Профиль пользователя: <?php echo e($target->name); ?></h1>

    <div class="profile-view flex between">
        <!-- Левая колонка: Аватар -->
        <div class="profile__info center bgfff flex wow fadeInLeft" data-wow-duration="1.5s" data-wow-delay="1.5s">
            <div class="profile__avatar">
                <img 
                    src="<?php echo e($target->avatar_url ? asset($target->avatar_url) : asset('user/avatar/default-avatar.png')); ?>" 
                    alt="Фото пользователя"
                >
            </div>
        </div>

        <!-- Правая колонка: Информация о пользователе -->
        <div class="profile__link flex">
            <div class="class-border-profile">
                <h3><?php echo e($target->name); ?></h3>
                <label>
                    <p>Номер телефона</p>
                    <span><?php echo e($target->phone ?? 'Не указан'); ?></span>
                </label>
                <label>
                    <p>Почта</p>
                    <span><?php echo e($target->email); ?></span>
                </label>
                <label>
                    <p>Статус</p>
                    <span><?php echo e($target->status ?? 'Не установлен'); ?></span>
                </label>
                <label>
                    <p>Роль</p>
                    <span><?php echo e($target->role); ?></span>
                </label>
                <label>
                    <p>Дата регистрации</p>
                    <span><?php echo e($target->created_at->format('d.m.Y H:i')); ?></span>
                </label>
            </div>
        </div>
    </div>

    <!-- Кнопка возврата (например, назад к списку пользователей) -->
    <div class="mt-4">
        <a href="<?php echo e(url()->previous()); ?>" class="btn btn-secondary">Назад</a>
    </div>
</div>
<?php /**PATH C:\OSPanel\domains\dlk\resources\views\module\profile_view.blade.php ENDPATH**/ ?>