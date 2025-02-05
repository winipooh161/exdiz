<div class="ponel__body ">
    <div class="ponel__ul">
        <li class="logo_flex flex">
            <a class="flex" href="<?php echo e(url('/home')); ?>"> <img src="/storage/icon/Ex.svg" alt=""> <span><img
                        src="/storage/icon/logo.svg" alt=""></span></a>
        </li>
        <li>
            <button id="toggle-panel" class="toggle-btn"> <img src="/storage/icon/burger.svg" alt=""> <span>Свернуть меню</span></button>
        </li>
       
        
        <li>
            <button onclick="location.href='<?php echo e(url('/brifs')); ?>'" id="step-4">
                <img src="/storage/icon/brif.svg" alt=""><span>Ваши брифы</span>
            </button>
        </li>
        <?php if(Auth::user()->status == 'coordinator' || Auth::user()->status == 'admin'): ?>
        <li>
            <button onclick="location.href='<?php echo e(route('deal.cardinator')); ?>'" id="step-5">
                <img src="/storage/icon/deal.svg" alt=""> <span>Ваши сделки</span>
            </button>
        </li>
        <li>
            <button onclick="location.href='<?php echo e(url('/chats')); ?>'"  id="step-6">
                <img src="/storage/icon/chat.svg" alt=""> <span>Ваши чаты</span>
            </button>
        </li>
    <?php else: ?>
        <li>
            <button onclick="location.href='<?php echo e(route('deal.user')); ?>'"id="step-5">
                <img src="/storage/icon/deal.svg" alt=""> <span>Сделка </span>
            </button>
        </li>
       
    <?php endif; ?>
        <?php if(Auth::user()->status == 'partner' || Auth::user()->status == 'admin'): ?>
            <li>
                <button onclick="location.href='<?php echo e(url('/estimate')); ?>'">
                    <img src="/storage/icon/estimates.svg" alt=""> <span>Ваши сметы</span>
                </button>
            </li>
            
        <?php endif; ?>
  
        <li>
            <button onclick="location.href='<?php echo e(url('/profile')); ?>'" id="step-7">
                <img src="/storage/icon/profile.svg" alt=""><span>Ваш профиль</span>
            </button>
        </li>
        <?php if(Auth::user()->status == 'admin' ): ?>
        <li>
            <button onclick="location.href='<?php echo e(url('/admin')); ?>'">
                <img src="/storage/icon/admin.svg" alt=""> <span>Админка</span>
            </button>
        </li>
    <?php endif; ?>
        <li>
            <button onclick="location.href='<?php echo e(url('/support')); ?>'"  id="step-8">
                <img src="/storage/icon/support.svg" alt=""><span>Помощь</span>
            </button>
        </li>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Получаем текущий URL
        const currentUrl = window.location.pathname;

        // Находим все кнопки с атрибутами onclick
        const buttons = document.querySelectorAll('button[onclick]');

        // Перебираем кнопки
        buttons.forEach(button => {
            // Извлекаем URL из атрибута onclick
            const onclickValue = button.getAttribute('onclick');
            const urlMatch = onclickValue.match(/'(.*?)'/);

            // Если URL найден в атрибуте onclick
            if (urlMatch && urlMatch[1]) {
                const buttonUrl = new URL(urlMatch[1], window.location.origin).pathname;

                // Сравниваем URL кнопки с текущим URL
                if (buttonUrl === currentUrl) {
                    button.classList.add('active_Btn');
                }
            }
        });
    });
</script>
<?php /**PATH C:\OSPanel\domains\dlk\resources\views/layouts/ponel.blade.php ENDPATH**/ ?>