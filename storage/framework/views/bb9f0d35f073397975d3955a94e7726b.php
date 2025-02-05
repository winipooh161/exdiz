<form action="<?php echo e(route('commercial.store')); ?>" method="POST" class="div__create_form">
    <?php echo csrf_field(); ?>
    <div class="div__create_block">
        <h1>Уважаемый клиент, мы подготовили для Вас Коммерческий бриф</h1>
        <p>Вам необходимо заполнить все поля. Чем больше мы получим информации, тем более точный результат мы сможем гарантировать!</p>
        <p>Если Вы не можете ответить на вопрос, поставьте “-” в поле, чтобы вернуться к заполнению позже.</p>
        <button type="submit">Создать бриф</button>
    </div>
</form>
<?php /**PATH C:\OSPanel\domains\dlk\resources\views\commercial\module\create.blade.php ENDPATH**/ ?>