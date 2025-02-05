<form action="<?php echo e(route('common.saveAnswers', $page)); ?>" method="POST" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
    <?php if(!empty($title) || !empty($subtitle)): ?>
        <div class="form__title">
            <?php if(!empty($title)): ?>
                <h1><?php echo e($title); ?></h1>
            <?php endif; ?>
            <?php if(!empty($subtitle)): ?>
                <p><?php echo e($subtitle); ?></p>
            <?php endif; ?>
        </div>
    <?php endif; ?>
    <div class="form__body flex between wrap pointblock">
        <?php $__currentLoopData = $questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($question['format'] === 'checkpoint'): ?>
                <div class="checkpoint flex wrap">
                    <div class="radio">
                        <input type="checkbox" id="answer_<?php echo e($loop->index); ?>" class="custom-checkbox"
                            name="answers[<?php echo e($question['key']); ?>]" value="<?php echo e($question['title']); ?>"
                            <?php echo e(isset($brif->{$question['key']}) && $brif->{$question['key']} === $question['title'] ? 'checked' : ''); ?>>
                        <label for="answer_<?php echo e($loop->index); ?>"><?php echo e($question['title']); ?></label>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <div class="form__body flex between wrap">
        <?php $__currentLoopData = $questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($question['format'] === 'default'): ?>
                <div class="form-group flex wrap">
                    <h2><?php echo e($question['title']); ?></h2>
                    <p><?php echo e($question['subtitle']); ?></p>
                    <?php if($question['type'] === 'textarea'): ?>
                        <textarea name="answers[<?php echo e($question['key']); ?>]" placeholder="<?php echo e($question['placeholder']); ?>" class="form-control"
                            maxlength="500"><?php echo e($brif->{$question['key']} ?? ''); ?></textarea>
                    <?php else: ?>
                        <input type="text" name="answers[<?php echo e($question['key']); ?>]" class="form-control"
                            value="<?php echo e($brif->{$question['key']} ?? ''); ?>" placeholder="<?php echo e($question['placeholder']); ?>"
                            maxlength="500">
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <?php if($page <= 13): ?>
                <?php if($question['format'] === 'faq'): ?>
                    <div class="faq__body">
                        <div class="faq_block flex center">
                            <div class="faq_item">
                                <div class="faq_question" onclick="toggleFaq(this, 'faq2')">
                                    <h2><?php echo e($question['title']); ?></h2>
                                    <svg class="arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                        width="24" height="24">
                                        <path d="M7 10l5 5 5-5z"></path>
                                    </svg>
                                </div>
                                <div class="faq_answer">
                                    <?php if($question['type'] === 'textarea'): ?>
                                        <textarea name="answers[<?php echo e($question['key']); ?>]" placeholder="<?php echo e($question['placeholder']); ?>" class="form-control"
                                            maxlength="500"><?php echo e($brif->{$question['key']} ?? ''); ?></textarea>
                                    <?php else: ?>
                                        <input type="text" name="answers[<?php echo e($question['key']); ?>]"
                                            class="form-control" value="<?php echo e($brif->{$question['key']} ?? ''); ?>"
                                            placeholder="<?php echo e($question['placeholder']); ?>" maxlength="500">
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
            <?php if($page >= 14): ?>
                <?php if($question['format'] === 'faq'): ?>
                    <div class="faq__body">
                        <div class="faq_block flex center">
                            <div class="faq_item">
                                <div class="faq_question" onclick="toggleFaq(this, 'faq1')">
                                    <h2><?php echo e($question['title']); ?></h2>
                                    <svg class="arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                        width="24" height="24">
                                        <path d="M7 10l5 5 5-5z"></path>
                                    </svg>
                                </div>
                                <div class="faq_answer">
                                    <?php if($question['type'] === 'textarea'): ?>
                                        <textarea name="answers[<?php echo e($question['key']); ?>]" placeholder="<?php echo e($question['placeholder']); ?>"
                                            class="form-control control__price" maxlength="15"><?php echo e($brif->{$question['key']} ?? ''); ?></textarea>
                                    <?php else: ?>
                                        <input type="text" name="answers[<?php echo e($question['key']); ?>]"
                                            class="form-control" value="<?php echo e($brif->{$question['key']} ?? ''); ?>"
                                            placeholder="<?php echo e($question['placeholder']); ?>" maxlength="15">
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php if($page == 15): ?>
            <div class="upload__files">
                <h6>Загрузите документы (суммарно не более 25 МБ):</h6>
                <p class="error-message" style="color: red;"></p> <!-- Место для вывода ошибок -->
                <input id="fileInput" type="file" name="documents[]" multiple
                    accept=".pdf,.xlsx,.xls,.doc,.docx,.jpg,.jpeg,.png,.heic,.heif" class="form-control">
                <small>Допустимые форматы: .pdf, .xlsx, .xls, .doc, .docx, .jpg, .jpeg, .png, .heic, .heif</small>
                <small>Максимальный размер всех файлов: 25 МБ</small>
            </div>
        <?php endif; ?>
    </div>
    <?php if($page == 14): ?>
        <div class="faq__custom-template__prise">
            <h6>Бюджет: <span id="budget-total">0</span></h6>
            <input type="hidden" id="budget-input" name="price" value="0"> <!-- Добавлено скрытое поле -->
        </div>
        <script>
            function calculateBudget() {
                let total = 0;
                const textareas = document.querySelectorAll('.faq__body textarea');
                textareas.forEach(function(textarea) {
                    const value = parseFloat(textarea.value.replace(/\s+/g, '').replace('₽', '')) ||
                        0;
                    total += value;
                });
                const formattedTotal = formatCurrency(total);
                document.getElementById('budget-total').textContent = formattedTotal;
                document.getElementById('budget-input').value = total;
            }
            function formatCurrency(amount) {
                const formattedAmount = amount.toLocaleString('ru-RU');
                return formattedAmount + '₽';
            }
            function formatTextareaInput(event) {
                let value = event.target.value.replace(/\D/g, '');
                if (value) {
                    value = parseInt(value, 10).toLocaleString('ru-RU');
                }
                event.target.value = value + '₽';
            }
            document.querySelectorAll('.faq__body textarea').forEach(function(textarea) {
                textarea.addEventListener('input', function(event) {
                    formatTextareaInput(event);
                    calculateBudget();
                });
            });
            window.addEventListener('load', calculateBudget);
        </script>
    <?php endif; ?>
    <div class="form__button flex between">
        <?php if($page > 1): ?>
        <button type="button" class="btn btn-secondary" id="prevPageButton">На прошлый вопрос</button>

        <script>
            document.getElementById('prevPageButton').addEventListener('click', function() {
                // Calculate the previous page number
                const prevPage = <?php echo e($page); ?> - 1;
                
                // Make sure the page number is valid (>= 1)
                if (prevPage >= 1) {
                    // Navigate to the previous page using the correct URL with the page number
                    window.location.href = '<?php echo e(url("common/questions/")); ?>/' + prevPage;
                }
            });
        </script>
        
        <?php endif; ?>
        <button type="submit" class="btn btn-primary">Далее</button>
    </div>
</form>
<script>
    document.getElementById('fileInput').addEventListener('change', function() {
        const allowedFormats = ['pdf', 'xlsx', 'xls', 'doc', 'docx', 'jpg', 'jpeg', 'png', 'heic', 'heif'];
        const errorMessageElement = document.querySelector('.error-message');
        const files = this.files;
        let totalSize = 0;
        errorMessageElement.textContent = '';
        for (const file of files) {
            const fileExt = file.name.split('.').pop().toLowerCase();
            if (!allowedFormats.includes(fileExt)) {
                errorMessageElement.textContent = `Недопустимый формат файла: ${file.name}.`;
                this.value = '';
                return;
            }
            totalSize += file.size;
        }
        if (totalSize > 25 * 1024 * 1024) {
            errorMessageElement.textContent = 'Суммарный размер файлов не должен превышать 25 МБ.';
            this.value = '';
        }
    });

    function toggleFaq(element, type = '') {
        const parentSelector = type === 'faq2' ? '.faq__body .faq_item' : '.faq_item';
        const faqItem = element.parentElement;
        document.querySelectorAll(parentSelector).forEach(item => {
            if (item !== faqItem) {
                item.classList.remove('active');
            }
        });
        const isActive = faqItem.classList.toggle('active');

        // Если элемент стал активным, установить фокус на внутренний input или textarea
        if (isActive) {
            const input = faqItem.querySelector('input, textarea');
            if (input) {
                input.focus();
            }
        }
    }

    document.querySelector('form').addEventListener('submit', function(e) {
        const files = document.getElementById('fileInput').files;
        const errorMessageElement = document.querySelector('.error-message');
        let totalSize = 0;
        errorMessageElement.textContent = '';
        for (const file of files) {
            totalSize += file.size;
        }
        if (totalSize > 25 * 1024 * 1024) {
            errorMessageElement.textContent = 'Суммарный размер файлов не должен превышать 25 МБ.';
            e.preventDefault();
        }
    });
</script>
<style>
    .radio input[type=checkbox]:checked+label:hover {
    background: #fff;
}
</style>
<?php /**PATH C:\OSPanel\domains\dlk\resources\views\common\module\questions.blade.php ENDPATH**/ ?>