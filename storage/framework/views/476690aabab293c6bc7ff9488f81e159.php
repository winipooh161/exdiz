<div class="mb mobile__ponel"  id="step-mobile-2">
    <ul>
       
      
       
        <li>
            <button onclick="location.href='<?php echo e(url('/brifs')); ?>'" id="step-mobile-4">
                <img src="/storage/icon/brif.svg" alt="">
            </button>
        </li>
        <?php if(Auth::user()->status == 'coordinator' || Auth::user()->status == 'admin'): ?>
            <li>
                <button onclick="location.href='<?php echo e(route('deal.cardinator')); ?>'" id="step-mobile-5">
                    <img src="/storage/icon/deal.svg" alt=""> 
                </button>
            </li>
            <li>
                <button onclick="location.href='<?php echo e(url('/chats')); ?>'"  id="step-mobile-6">
                    <img src="/storage/icon/chat.svg" alt=""> 
                </button>
            </li>
        <?php else: ?>
            <li>
                <button onclick="location.href='<?php echo e(route('deal.user')); ?>'"id="step-5"  id="step-mobile-5">
                    <img src="/storage/icon/deal.svg" alt="">
                </button>
            </li>
          
        <?php endif; ?>
        <?php if(Auth::user()->status == 'partner' || Auth::user()->status == 'admin'): ?>
            <li>
                <button onclick="location.href='<?php echo e(url('/estimate')); ?>'">
                    <img src="/storage/icon/estimates.svg" alt=""> 
                </button>
            </li>
            
        <?php endif; ?>
        <?php if(Auth::user()->status == 'admin' ): ?>
        <li>
            <button onclick="location.href='<?php echo e(url('/admin')); ?>'">
                <img src="/storage/icon/admin.svg" alt=""> 
            </button>
        </li>
        
    <?php endif; ?>
        <li>
            <button onclick="location.href='<?php echo e(url('/profile')); ?>'" id="step-mobile-7">
                <img src="/storage/icon/profile.svg" alt="">
            </button>
        </li>
       
        <li>
            <button onclick="location.href='<?php echo e(url('/support')); ?>'"  id="step-mobile-8">
                <img src="/storage/icon/support.svg" alt="">
            </button>
        </li>
    </ul>
</div><?php /**PATH C:\OSPanel\domains\dlk\resources\views/layouts/mobponel.blade.php ENDPATH**/ ?>