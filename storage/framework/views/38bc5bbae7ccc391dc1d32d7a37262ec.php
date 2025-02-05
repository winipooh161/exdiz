
<h1><?php echo e($title_site); ?></h1>

<form action="<?php echo e(route('deals.store')); ?>" method="POST" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>

    
    <label for="name">ФИО клиента:
        <input type="text" id="name" name="name" class="form-control" 
               required minlength="2" maxlength="255"
               pattern="^[\pL\s\-]+$"  
               title="Только буквы, пробелы и дефисы.">
    </label>

    
    <label for="client_phone">Контакт (Номер телефона):
        <input type="text" id="client_phone" name="client_phone" class="maskphone form-control" 
               required pattern="^\+7\s\(\d{3}\)\s\d{3}-\d{2}-\d{2}$"
               title="Формат: +7 (XXX) XXX-XX-XX">
    </label>

    
    <label for="completion_responsible">Кто делает комплектацию:
        <input type="text" id="completion_responsible" name="completion_responsible" class="form-control"
               maxlength="255">
    </label>

    
    <label>
        <input type="checkbox" id="office_equipment" name="office_equipment" value="1">
        Комплектация по объекту ОФИС
    </label>

    
    <label for="stage">Стадия:
        <select id="stage" name="stage" class="form-control">
            <option value="">-- Не выбрано --</option>
            <option value="Офис">Офис</option>
            <option value="Партнер">Партнер</option>
            <option value="Другая">Другая</option>
        </select>
    </label>

    
    <label for="coordinator_score">Оценка координатора (0..10):
        <input type="number" id="coordinator_score" name="coordinator_score" class="form-control"
               min="0" max="10" step="0.5">
    </label>

    
    <label for="client_city">Город:
        <input type="text" id="client_city" name="client_city" class="form-control"
               maxlength="100">
    </label>

    
    <label for="total_sum">Сумма заказа (руб.):
        <input type="number" step="0.01" id="total_sum" name="total_sum" class="form-control" min="0">
    </label>

    
    <label for="measuring_cost">Стоимость замеров:
        <input type="number" step="0.01" id="measuring_cost" name="measuring_cost" class="form-control" min="0">
    </label>

    
    <label for="project_budget">Бюджет по проекту:
        <input type="number" step="0.01" id="project_budget" name="project_budget" class="form-control" min="0">
    </label>

    
    <label for="created_date">Дата создания:
        <input type="date" id="created_date" name="created_date" class="form-control">
    </label>

    
    <label for="deal_end_date">Дата окончания:
        <input type="date" id="deal_end_date" name="deal_end_date" class="form-control">
    </label>

    
    <label for="client_info">Информация о клиенте и объекте:
        <textarea id="client_info" name="client_info" class="form-control" rows="3"></textarea>
    </label>

    
    <label for="payment_date">Дата оплаты:
        <input type="date" id="payment_date" name="payment_date" class="form-control">
    </label>

    
    <label for="package">Выбор пакета:
        <input type="text" id="package" name="package" class="form-control" maxlength="255">
    </label>

    
    <label for="rooms_count">Количество комнат (по прайсу):
        <input type="number" id="rooms_count" name="rooms_count" class="form-control" min="1">
    </label>

    
    <label for="execution_comment">Комментарий (для отдела исполнения):
        <textarea id="execution_comment" name="execution_comment" class="form-control" rows="2"></textarea>
    </label>

    
    <label for="comment">Комментарий (общий):
        <textarea id="comment" name="comment" class="form-control" rows="2"></textarea>
    </label>

    
    <label for="status">Статус:
        <select id="status" name="status" class="form-control" required>
            <option value="в работе">В работе</option>
            <option value="Завершенный">Завершенный</option>
            <option value="На потом">На потом</option>
        </select>
    </label>

    
    <?php if($users->isEmpty()): ?>
        <p>Нет доступных пользователей с подходящим статусом.</p>
    <?php else: ?>
        <label for="responsibles">Ответственные за сделку:
            <select id="responsibles" name="responsibles[]" class="form-control" multiple>
                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($user->id); ?>">
                        <?php echo e($user->name); ?> (<?php echo e($user->status); ?>)
                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </label>
    <?php endif; ?>

    
    <label for="avatar">Загрузить фото аватара сделки:
        <input type="file" name="avatar" id="avatar" accept="image/*">
    </label>

    <button type="submit" class="btn btn-primary">Создать сделку</button>
</form>


<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        $('#responsibles').select2({
            placeholder: 'Выберите ответственных',
            allowClear: true,
            width: '100%'
        });
    });
</script>


<script>
document.addEventListener("DOMContentLoaded", function () {
    var inputs = document.querySelectorAll("input.maskphone");
    for (var i = 0; i < inputs.length; i++) {
        var input = inputs[i];
        input.addEventListener("input", mask);
        input.addEventListener("focus", mask);
        input.addEventListener("blur", mask);
    }
    function mask(event) {
        // Пример +7 (XXX) XXX-XX-XX
        var blank = "+7 (___) ___-__-__";
        var i = 0;
        var val = this.value.replace(/\D/g, "");
        // Если пользователь начинает ввод не с +7 
        // - можно автоматически подменять, но для простоты оставим
        this.value = blank.replace(/./g, function (char) {
            if (/[_\d]/.test(char) && i < val.length) {
                return val.charAt(i++);
            }
            return i >= val.length ? "" : char;
        });
        if (event.type === "blur") {
            if (this.value.length < 5) this.value = "";
        } else {
            setCursorPosition(this, this.value.length);
        }
    }
    function setCursorPosition(elem, pos) {
        if (elem.setSelectionRange) {
            elem.focus();
            elem.setSelectionRange(pos, pos);
        }
    }
});
</script>

<?php /**PATH C:\OSPanel\domains\dlk\resources\views/deals/create.blade.php ENDPATH**/ ?>