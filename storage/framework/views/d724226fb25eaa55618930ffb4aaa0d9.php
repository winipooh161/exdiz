<?php $__env->startSection('content'); ?>
    <div class="container service-container wow fadeInLeft" data-wow-duration="1.5s" data-wow-delay="1.5s">
        <div class="row service-services">
            <a href="<?php echo e(route('estimate.defaultServices')); ?>" class="servise-default_btn"
                onclick="confirmResetServices()">Вернуть все услуги по умолчанию</a>
            <div class="stage_add" onclick="addBlock(this)">Создать новый этап</div>
            <div class="service_for_wrap">
                <div class="block_lider_list">
                    <div class="block__modal__addblock" id="block__modal__addblock">
                        <div class="block__modal__addblock__body">
                            <span class="close-modal" onclick="closeModalFunction()">&times;</span>
                            <!-- Modal content here -->
                        </div>
                    </div>
                    <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($service->type == 'stage'): ?>
                            <div class="row service-row">
                                <div class="abs_block_listrs">
                                </div>
                                <?php
                                    $stage = $service->info;
                                ?>
                                <input type="checkbox" id="check-<?php echo e($service->id); ?>" class="create-checkbox_stage"
                                    onchange="toggleElements('check-<?php echo e($service->id); ?>', 'counter-<?php echo e($service->id); ?>', 'stage-<?php echo e($service->id); ?>', '.content-<?php echo e($service->id); ?>')">
                                <label for="check-<?php echo e($service->id); ?>">
                                    <p class="p_block_stage "><?php echo e($stage); ?></p>
                                </label>
                                <input type="hidden" id="stage-<?php echo e($service->id); ?>" name="stage-<?php echo e($service->id); ?>"
                                    value="stage-<?php echo e($service->info); ?> " disabled>
                                <h3 class="service-h3 none" id="counter-<?php echo e($service->id); ?>" hidden>
                                    <?php echo e($stage); ?> </h3>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <div class="block_two_serv">
                    <div class="service_wrapper">
                        <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($service->type == 'stage'): ?>
                                <?php
                                    $stage = $service->info;
                                ?>
                                <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $innerService): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($innerService->type == 'service' && $innerService->stage == $stage): ?>
                                        <h3 hidden class="service-h3" id="counter-<?php echo e($service->id); ?>">
                                            <?php echo e($stage); ?>

                                        </h3>
                                        <div class="div_gop content-<?php echo e($service->id); ?>" id="div_gop">
                                            <div class="col-12 service-col-12  hp_input_prise">
                                                <input type="checkbox" id="check-<?php echo e($innerService->id); ?>"
                                                    class="create-checkbox_stage">
                                                <label for="check-<?php echo e($innerService->id); ?>" onclick="handleLinkClick(event)"
                                                    id="label-<?php echo e($innerService->id); ?>">
                                                    <div class="abs_hp_input_prise">
                                                        <!-- SVG Icon for the service -->
                                                    </div>
                                                    <?php echo e($innerService->info); ?>

                                                </label>
                                                <input type="hidden" id="service-<?php echo e($innerService->id); ?>"
                                                    name="service-<?php echo e($innerService->id); ?>"
                                                    value="service-<?php echo e($innerService->id); ?>_price-0" disabled>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <div class="block_post_list">
                        <div class="input_tipe">
                            <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $innerService): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($innerService->type == 'service'): ?>
                                    <div class="input_tipe_inputs">
                                        <input type="checkbox" id="check-<?php echo e($innerService->id); ?>"
                                            class="create-checkbox_stage"
                                            onchange="toggleElements('check-<?php echo e($innerService->id); ?>', 'service-<?php echo e($innerService->id); ?>', 'counter-<?php echo e($innerService->id); ?>', '.content-<?php echo e($innerService->id); ?>')">
                                        <div class="block_input_span_f">
                                            <input type="text" id="service-<?php echo e($innerService->id); ?>"
                                                class="serv__create-service_input" data-price='<?php echo e($innerService->price); ?>'
                                                value="<?php echo e($innerService->info); ?>">
                                            <span class="service-chenge content-<?php echo e($innerService->id); ?>"
                                                id="chenge-info-<?php echo e($innerService->id); ?>"
                                                onclick='changeThis(<?php echo e($innerService->id); ?>,"info", this)'
                                                data-id='<?php echo e($innerService->id); ?>' data-label='true'>Изменить
                                                название</span>
                                        </div>
                                        <div class="block_input_span_f">
                                            <input type="text" id="price-<?php echo e($innerService->id); ?>"
                                                class="serv__create-service_input content-<?php echo e($innerService->id); ?> numeric-input"
                                                oninput='validateInput(this)' value="<?php echo e($innerService->price); ?>">
                                            <span class="service-chenge content-<?php echo e($innerService->id); ?> "
                                                id="chenge-price-<?php echo e($innerService->id); ?>"
                                                onclick='changeThis(<?php echo e($innerService->id); ?>,"price", this)'
                                                data-id='<?php echo e($innerService->id); ?>' data-label='false'>Изменить цену</span>
                                        </div>
                                        <div class="block_input_span_f">
                                            <input type="text"
                                                name="counter-<?php echo e($innerService->id); ?>_info-<?php echo e($innerService->info); ?>, <?php echo e($innerService->unit); ?>"
                                                id="counter-<?php echo e($innerService->id); ?>"
                                                class="serv__create-service_input-data serv__create-service_input  content-<?php echo e($innerService->id); ?>"
                                                placeholder="<?php echo e($innerService->unit); ?>" value='<?php echo e($innerService->unit); ?>'>
                                            <span class="service-chenge content-<?php echo e($innerService->id); ?>"
                                                id="chenge-unit-<?php echo e($innerService->id); ?>"
                                                onclick='changeThis(<?php echo e($innerService->id); ?>,"unit", this)'
                                                data-id='<?php echo e($innerService->id); ?>' data-label='false'>Изменить
                                                размерность</span>
                                        </div>
                                        <div class="block_input_span_f">
                                            <input type="text"
                                                name="counter-<?php echo e($innerService->id); ?>_substage-<?php echo e($innerService->substage); ?>, <?php echo e($innerService->substage); ?>"
                                                id="counter-<?php echo e($innerService->id); ?>"
                                                class="serv__create-service_input-data serv__create-service_input  content-<?php echo e($innerService->id); ?>"
                                                placeholder="<?php echo e($innerService->substage); ?>"
                                                value='<?php echo e($innerService->substage); ?>'>
                                            <span class="service-chenge content-<?php echo e($innerService->id); ?>"
                                                id="chenge-substage-<?php echo e($innerService->id); ?>"
                                                onclick='changeThis(<?php echo e($innerService->id); ?>,"substage", this)'
                                                data-id='<?php echo e($innerService->id); ?>' data-label='true'>Изменить
                                                подэтап</span>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
  function toggleElements(checkboxId, serviceId, counterId, contentId = null) {
    let checkbox = document.getElementById(checkboxId);
    let service = document.getElementById(serviceId);
    let counter = document.getElementById(counterId);
    let contents = contentId ? document.querySelectorAll(contentId) : null;
    if (checkbox.checked) {
        service.classList.add('content-visible');
        service.disabled = false;
        if (contents) {
            contents.forEach(content => {
                content.classList.add('content-visible');
            });
        }
    } else {
        service.classList.remove('content-visible');
        service.disabled = true;
        if (contents) {
            contents.forEach(content => {
                content.classList.remove('content-visible');
            });
        }
        counter.disabled = true;
    }
}
        function activateInput(event, inputId, link) {
            event.preventDefault();
            let input = document.getElementById(inputId);
            input.disabled = false;
            input.focus();
            link.parentElement.style.display = 'none';
        }
    </script>
    
    <script>
     function addBlock(element) {
    let randomNumber = Math.floor(Math.random() * 900000) + 100000;
    let newBlock = `
        <div class="row service-row">
            <label for="check-${randomNumber}" id='label-${randomNumber}'>Новый этап</label>
            <input  placeholder="Имя этапа" type="checkbox" id="check-${randomNumber}" class="create-checkbox_stage" 
                onchange="toggleElements('check-${randomNumber}', 'stage-${randomNumber}', 'counter-${randomNumber}', '.content-${randomNumber}')">
            <input placeholder="Имя этапа" type="text" id="stage-${randomNumber}" name="stage-${randomNumber}" value="" class="service-col-12">
            <span class="service-chenge content-${randomNumber}" onclick="changeThis('${randomNumber}', 'info', this, 'stage')">Изменить этап</span>
            <div class="service_wrapper" id="service_wrap-${randomNumber}" data-label='true'></div>
            <div class="service_add service-col-12 content-${randomNumber}" onclick="addService('${randomNumber}')">+</div>
        </div>`;
    let modalBody = document.querySelector('.block__modal__addblock__body');
    let block__modal__addblock = document.querySelector('.block__modal__addblock');
    block__modal__addblock.style.display = 'flex';
    modalBody.innerHTML += newBlock;
}
 // Function to close the modal
 function closeModalFunction() {
        block__modal__addblock.style.display = 'none';
    }
function addService(id) {
    let randomNumber = Math.floor(Math.random() * 900000) + 100000;
    let newBlock = `
        <div class='flex_block_links'>
            <div class="col-12 service-col-12 content-${randomNumber} content-visible">
                <label for="check-${randomNumber}" id="label-${randomNumber}">Новый сервис</label>
                <input type="checkbox" id="check-${randomNumber}" class="create-checkbox_stage" 
                    onchange="toggleElements('check-${randomNumber}', 'service-${randomNumber}', 'counter-${randomNumber}', '.content-${randomNumber}')">
                <input type="text" id="service-${randomNumber}" class="serv__create-service_input" data-price='0' value="" placeholder='Название'>
                <span class="service-change content-${randomNumber}" id='change-info-${randomNumber}' 
                    onclick="changeThis(${randomNumber},'info', this, 'service');removeDisabledSpans(this)" 
                    data-id='${id}' data-label='true'>Изменить название</span>
                <input type="text" id="price-${randomNumber}" class="serv__create-service_input content-${randomNumber} numeric-input" 
                    oninput='validateInput(this)' value="" placeholder='Цена'>
                <span class="service-change span-disabled content-${randomNumber}" id='change-price-${randomNumber}' 
                    onclick="changeThis(${randomNumber},'price', this, 'service')" data-id='${id}' data-label='false'>Изменить цену</span>
                <input type="text" id="counter-${randomNumber}" class="serv__create-service_input-data content-${randomNumber}" 
                    placeholder="Размерность" value=''>
                <span class="service-change span-disabled content-${randomNumber}" id='change-unit-${randomNumber}' 
                    onclick="changeThis(${randomNumber},'unit', this, 'service')" data-id='${id}' data-label='false'>Изменить размерность</span>
                <input type="text" id="substage-${randomNumber}" class="serv__create-service_input-data content-${randomNumber}" 
                    placeholder="подэтап" value=''>
                <span class="service-change span-disabled content-${randomNumber}" id='change-substage-${randomNumber}' 
                    onclick="changeThis(${randomNumber},'substage', this, 'service')" data-id='${id}' data-label='false'>Изменить подэтап</span>
            </div>
        </div>`;
    let serviceWrapper = document.querySelector(`#service_wrap-${id}`);
    serviceWrapper.innerHTML += newBlock;
}
    </script>
    <script>
    </script>
    <script>
 function changeThis(id, slot, element, type = null, stage = null) {
    let idParent = element.getAttribute('data-id') ? element.getAttribute('data-id') : null;
    if (type === 'service') {
        stage = document.querySelector(`#label-${idParent}`).textContent;
    }
    if (element.previousElementSibling) {
        const prevElement = element.previousElementSibling;
        const value = (slot !== "unit") ? prevElement.value : 'none';
        const unitValue = (slot === "unit") ? prevElement.value : 'none';
        const label = document.querySelector(`#label-${id}`);
        const encodedValue = encodeURIComponent(value);
        const url = `/estimate/change/${id}/${slot}/${encodedValue}/${type}/${stage}`;
        const requestData = { idParent, unitValue };
        if (label) {
            let dataLabel = element.getAttribute('data-label');
            if (dataLabel == 'true') {
                label.textContent = prevElement.value;
            }
        }
        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
            },
            body: JSON.stringify(requestData)
        })
        .then(response => {
            if (response.ok) {
                element.classList.add('changed');
                return response.json();
            } else {
                throw new Error('Ошибка при выполнении запроса');
            }
        })
        .then(data => {
            if (prevElement) {
                prevElement.setAttribute('onclick', `changeThis(${data.id},"info", this)`);
            }
            const infoEl = document.querySelector(`#change-info-${id}`);
            const priceEl = document.querySelector(`#change-price-${id}`);
            const unitEl = document.querySelector(`#change-unit-${id}`);
            const substageEl = document.querySelector(`#change-substage-${id}`);
            if (infoEl && priceEl && unitEl && substageEl) {
                infoEl.setAttribute('onclick', `changeThis(${data.id}, "info", this)`);
                priceEl.setAttribute('onclick', `changeThis(${data.id}, "price", this)`);
                unitEl.setAttribute('onclick', `changeThis(${data.id}, "unit", this)`);
                substageEl.setAttribute('onclick', `changeThis(${data.id}, "substage", this)`);
            }
        })
        .catch(error => {
            console.error('Произошла ошибка', error);
        });
    }
}
    </script>
    <script>
        function handleLinkClick(event) {
            let checkboxId = "check-<?php echo e($innerService->id); ?>";
            let serviceId = "service-<?php echo e($innerService->id); ?>";
            let counterId = "counter-<?php echo e($innerService->id); ?>";
            let contentId = null; // Здесь укажите селектор для контента, который нужно показать/скрыть
            let checkbox = document.getElementById(checkboxId);
            let service = document.getElementById(serviceId);
            let counter = document.getElementById(counterId);
            let contents = contentId ? document.querySelectorAll(contentId) : null;
            if (checkbox.checked) {
                service.classList.add('content-visible');
                if (contents) {
                    contents.forEach(content => {
                        content.classList.add('content-visible');
                    });
                }
            } else {
                service.classList.remove('content-visible');
                if (contents) {
                    contents.forEach(content => {
                        content.classList.remove('content-visible');
                    });
                }
            }
        }
    </script>
    <script>
        function handleLinkClick(event) {
            event.preventDefault();
            let label = event.target.closest('label');
            if (label) {
                let checkboxId = label.getAttribute('for');
                let checkbox = document.getElementById(checkboxId);
                if (checkbox) {
                    checkbox.checked = !checkbox.checked;
                    toggleElements(checkboxId, 'service-' + checkboxId.split('-')[1], 'counter-' + checkboxId.split('-')[1],
                        '.content-' + checkboxId.split('-')[1]);
                }
            }
        }
    </script>
    <script>
     function confirmResetServices() {
    if (!confirm('Are you sure you want to reset services to default?')) {
        event.preventDefault();
    }
}
    </script>
    <script>
       function validateInput(input) {
    input.value = input.value.replace(/[^\d.]/g, '');
}
    </script>
    <script>
    function removeDisabledSpans(element) {
    if (element) {
        let parent = element.parentNode;
        let disabledSpans = parent.querySelectorAll('.span-disabled');
        disabledSpans.forEach(element => {
            if (element.classList.contains('span-disabled')) {
                element.classList.remove('span-disabled');
            }
        });
    }
}
    </script>
<?php $__env->stopSection(); ?>
<?php /**PATH C:\OSPanel\domains\dlk\resources\views\estimate\service.blade.php ENDPATH**/ ?>