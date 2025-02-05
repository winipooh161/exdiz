<div class="smets wow fadeInLeft" data-wow-duration="1.5s" data-wow-delay="1.5s" id="smets">
    <h1>Ваши сметы</h1>
    <div class="brifs__button__create flex">
        <button onclick="window.location.href='<?php echo e(route('estimate.service')); ?>'">Услуги и цены</button>
        <button onclick="window.location.href='<?php echo e(route('estimate.create')); ?>'">Создать смету</button>
    </div>
</div>

<div class=" estimate-estimates flex wow fadeInLeft" data-wow-duration="1.5s" data-wow-delay="1.5s">
    <?php $__currentLoopData = $estimates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $estimate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="estimate_est-wrap  smet" id="wrap-<?php echo e($estimate->id); ?>">
            <?php if($estimate->info == null): ?>
                <div class="flex_title_smets red">
                    <p class="estimate_txt ">№ <?php echo e($estimate->id); ?> - Смета не закончена!</p>
                    <div class="estimate_copy"><a href="<?php echo e(route('estimate.create')); ?>/<?php echo e($estimate->id); ?>"
                            class="estimate_copy-link"><svg width="18" height="18" viewBox="0 0 18 18"
                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M17.1249 2.50436L15.5061 0.881837C15.1003 0.493524 14.5609 0.276855 13.9999 0.276855C13.4388 0.276855 12.8994 0.493524 12.4936 0.881837L1.6811 11.7133C1.60116 11.7947 1.54496 11.8966 1.5186 12.0077L0.2686 17.0194C0.242144 17.1242 0.243205 17.2341 0.271681 17.3384C0.300157 17.4427 0.355077 17.5378 0.4311 17.6145C0.4895 17.6726 0.55876 17.7185 0.634908 17.7497C0.711057 17.7809 0.792596 17.7967 0.87485 17.7962C0.924668 17.8022 0.975031 17.8022 1.02485 17.7962L6.02485 16.5433C6.13575 16.5168 6.23733 16.4605 6.3186 16.3804L17.1249 5.52388C17.3233 5.32597 17.4807 5.0907 17.5882 4.83161C17.6956 4.57252 17.7509 4.2947 17.7509 4.01412C17.7509 3.73354 17.6956 3.45573 17.5882 3.19663C17.4807 2.93754 17.3233 2.70228 17.1249 2.50436ZM3.0061 12.1581L11.4999 3.64451L14.3686 6.51995L5.87485 15.0335L3.0061 12.1581ZM2.46235 13.411L4.62485 15.5785L1.7311 16.3115L2.46235 13.411ZM16.2436 4.64058L15.2499 5.63665L12.3811 2.76121L13.3749 1.76514C13.5441 1.60569 13.7676 1.51692 13.9999 1.51692C14.2321 1.51692 14.4556 1.60569 14.6249 1.76514L16.2436 3.38767C16.4085 3.55428 16.501 3.77945 16.501 4.01412C16.501 4.2488 16.4085 4.47397 16.2436 4.64058Z"
                                    fill="white" />
                            </svg>Редактировать</a></div>
                </div>
            <?php endif; ?>
            <?php if($estimate->info !== null): ?>
                <div class="flex_title_smets">
                    <p class="estimate_txt ">№ <?php echo e($estimate->id); ?> - Смета заполнена</p>
                    <div class="estimate_copy"><a href="<?php echo e(route('estimate.create')); ?>/<?php echo e($estimate->id); ?>"
                            class="estimate_copy-link"> <svg width="18" height="18" viewBox="0 0 18 18"
                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M17.1249 2.50436L15.5061 0.881837C15.1003 0.493524 14.5609 0.276855 13.9999 0.276855C13.4388 0.276855 12.8994 0.493524 12.4936 0.881837L1.6811 11.7133C1.60116 11.7947 1.54496 11.8966 1.5186 12.0077L0.2686 17.0194C0.242144 17.1242 0.243205 17.2341 0.271681 17.3384C0.300157 17.4427 0.355077 17.5378 0.4311 17.6145C0.4895 17.6726 0.55876 17.7185 0.634908 17.7497C0.711057 17.7809 0.792596 17.7967 0.87485 17.7962C0.924668 17.8022 0.975031 17.8022 1.02485 17.7962L6.02485 16.5433C6.13575 16.5168 6.23733 16.4605 6.3186 16.3804L17.1249 5.52388C17.3233 5.32597 17.4807 5.0907 17.5882 4.83161C17.6956 4.57252 17.7509 4.2947 17.7509 4.01412C17.7509 3.73354 17.6956 3.45573 17.5882 3.19663C17.4807 2.93754 17.3233 2.70228 17.1249 2.50436ZM3.0061 12.1581L11.4999 3.64451L14.3686 6.51995L5.87485 15.0335L3.0061 12.1581ZM2.46235 13.411L4.62485 15.5785L1.7311 16.3115L2.46235 13.411ZM16.2436 4.64058L15.2499 5.63665L12.3811 2.76121L13.3749 1.76514C13.5441 1.60569 13.7676 1.51692 13.9999 1.51692C14.2321 1.51692 14.4556 1.60569 14.6249 1.76514L16.2436 3.38767C16.4085 3.55428 16.501 3.77945 16.501 4.01412C16.501 4.2488 16.4085 4.47397 16.2436 4.64058Z"
                                    fill="white" />
                            </svg>
                            Редактировать</a></div>
                </div>
            <?php endif; ?>
            <div class="block_smet_container">
                <div class="text_smet">
                    <?php if(isset($estimate->about)): ?>
                        <?php
                            $aboutArray = json_decode($estimate->about, true);
                        ?>
                        <?php if(isset($aboutArray['address'])): ?>
                            <p><?php echo e($aboutArray['address']); ?></p>
                        <?php else: ?>
                            <p>Address is not available.</p>
                        <?php endif; ?>
                    <?php else: ?>
                        <p>Адрес не известен</p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="block_smet_container">
                <?php if(isset($estimate->price)): ?>
                    <p class="estimate_txt_id"> <strong> ₽ <?php echo e($estimate->price); ?></strong></p>
                <?php else: ?>
                    <p class=" estimate_txt_id">
                        <strong>№ <?php echo e($estimate->id); ?></strong> - <?php echo e($estimate->created_at->format('Y.m.d')); ?>

                    </p>
                <?php endif; ?>
                <?php if($estimate->info !== null): ?>
                    <div class="block_smet">
                        <div class="viev_smet">
                            <a href="<?php echo e(asset('pdf/' . $user->id . '/' . $estimate->info)); ?>"
                                class="estimate_link pdf"><svg width="13" height="14" viewBox="0 0 13 14"
                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M6.26456 10.4038C6.27081 10.41 6.27768 10.4113 6.28331 10.4163C6.33664 10.4681 6.39889 10.5098 6.46706 10.5394H6.46893C6.58293 10.5863 6.70825 10.5985 6.82913 10.5743C6.95001 10.5502 7.06106 10.4909 7.14831 10.4038L10.2733 7.27879C10.3872 7.16091 10.4502 7.00304 10.4487 6.83916C10.4473 6.67529 10.3816 6.51853 10.2657 6.40265C10.1498 6.28677 9.99305 6.22104 9.82918 6.21962C9.66531 6.21819 9.50743 6.28119 9.38956 6.39504L7.33143 8.45317V1.21191C7.33143 1.04615 7.26558 0.887183 7.14837 0.769972C7.03116 0.652762 6.87219 0.586914 6.70643 0.586914C6.54067 0.586914 6.3817 0.652762 6.26449 0.769972C6.14728 0.887183 6.08143 1.04615 6.08143 1.21191V8.45317L4.02331 6.39504C3.90543 6.28119 3.74755 6.21819 3.58368 6.21962C3.41981 6.22104 3.26305 6.28677 3.14717 6.40265C3.03129 6.51853 2.96556 6.67529 2.96413 6.83916C2.96271 7.00304 3.02571 7.16091 3.13956 7.27879L6.26456 10.4038Z"
                                        fill="white" />
                                    <path
                                        d="M11.7065 9.33691V11.2119C11.7064 11.3776 11.6405 11.5365 11.5233 11.6537C11.4061 11.7708 11.2473 11.8367 11.0815 11.8369H2.33154C2.16583 11.8367 2.00696 11.7708 1.88978 11.6537C1.77261 11.5365 1.70671 11.3776 1.70654 11.2119V9.33691C1.70654 9.17115 1.6407 9.01218 1.52348 8.89497C1.40627 8.77776 1.2473 8.71191 1.08154 8.71191C0.915783 8.71191 0.756811 8.77776 0.639601 8.89497C0.522391 9.01218 0.456543 9.17115 0.456543 9.33691V11.2119C0.457039 11.709 0.654743 12.1857 1.00627 12.5372C1.35779 12.8887 1.83441 13.0864 2.33154 13.0869H11.0815C11.5787 13.0864 12.0553 12.8887 12.4068 12.5372C12.7583 12.1857 12.956 11.709 12.9565 11.2119V9.33691C12.9565 9.17115 12.8907 9.01218 12.7735 8.89497C12.6563 8.77776 12.4973 8.71191 12.3315 8.71191C12.1658 8.71191 12.0068 8.77776 11.8896 8.89497C11.7724 9.01218 11.7065 9.17115 11.7065 9.33691Z"
                                        fill="white" />
                                </svg>
                                PDF</a>
                            <a href="<?php echo e(asset('excel/' . $user->id . '/' . $estimate->excel_info)); ?>"
                                class="estimate_link excel"><svg width="13" height="14" viewBox="0 0 13 14"
                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M6.26456 10.4038C6.27081 10.41 6.27768 10.4113 6.28331 10.4163C6.33664 10.4681 6.39889 10.5098 6.46706 10.5394H6.46893C6.58293 10.5863 6.70825 10.5985 6.82913 10.5743C6.95001 10.5502 7.06106 10.4909 7.14831 10.4038L10.2733 7.27879C10.3872 7.16091 10.4502 7.00304 10.4487 6.83916C10.4473 6.67529 10.3816 6.51853 10.2657 6.40265C10.1498 6.28677 9.99305 6.22104 9.82918 6.21962C9.66531 6.21819 9.50743 6.28119 9.38956 6.39504L7.33143 8.45317V1.21191C7.33143 1.04615 7.26558 0.887183 7.14837 0.769972C7.03116 0.652762 6.87219 0.586914 6.70643 0.586914C6.54067 0.586914 6.3817 0.652762 6.26449 0.769972C6.14728 0.887183 6.08143 1.04615 6.08143 1.21191V8.45317L4.02331 6.39504C3.90543 6.28119 3.74755 6.21819 3.58368 6.21962C3.41981 6.22104 3.26305 6.28677 3.14717 6.40265C3.03129 6.51853 2.96556 6.67529 2.96413 6.83916C2.96271 7.00304 3.02571 7.16091 3.13956 7.27879L6.26456 10.4038Z"
                                        fill="white" />
                                    <path
                                        d="M11.7065 9.33691V11.2119C11.7064 11.3776 11.6405 11.5365 11.5233 11.6537C11.4061 11.7708 11.2473 11.8367 11.0815 11.8369H2.33154C2.16583 11.8367 2.00696 11.7708 1.88978 11.6537C1.77261 11.5365 1.70671 11.3776 1.70654 11.2119V9.33691C1.70654 9.17115 1.6407 9.01218 1.52348 8.89497C1.40627 8.77776 1.2473 8.71191 1.08154 8.71191C0.915783 8.71191 0.756811 8.77776 0.639601 8.89497C0.522391 9.01218 0.456543 9.17115 0.456543 9.33691V11.2119C0.457039 11.709 0.654743 12.1857 1.00627 12.5372C1.35779 12.8887 1.83441 13.0864 2.33154 13.0869H11.0815C11.5787 13.0864 12.0553 12.8887 12.4068 12.5372C12.7583 12.1857 12.956 11.709 12.9565 11.2119V9.33691C12.9565 9.17115 12.8907 9.01218 12.7735 8.89497C12.6563 8.77776 12.4973 8.71191 12.3315 8.71191C12.1658 8.71191 12.0068 8.77776 11.8896 8.89497C11.7724 9.01218 11.7065 9.17115 11.7065 9.33691Z"
                                        fill="white" />
                                </svg>
                                Excel
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <div class="button_smets">
                <div class="estimate_copy2">
                    <button createonclick="window.location.href='<?php echo e(route('estimate.copy')); ?>/<?php echo e($estimate->id); ?>'">Дублировать
                        смету</button>
                    </div>
                <div class="estimate_del" onclick="confirmDeleteEstimate(<?php echo e($estimate->id); ?>)">
                    <svg width="16" height="19" viewBox="0 0 16 19" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M13.2782 2.59644H2.72192C2.21663 2.59735 1.7323 2.79895 1.37501 3.15707C1.01771 3.5152 0.816583 4.00067 0.815674 4.50713V4.95192C0.815921 5.03491 0.848924 5.11444 0.907476 5.17313C0.966028 5.23182 1.04537 5.2649 1.12817 5.26515H14.8719C14.9547 5.2649 15.0341 5.23182 15.0926 5.17313C15.1512 5.11444 15.1842 5.03491 15.1844 4.95192V4.50713C15.1835 4.00067 14.9824 3.5152 14.6251 3.15707C14.2678 2.79895 13.7835 2.59735 13.2782 2.59644ZM10.5375 1.96998V1.76951C10.5375 1.51531 10.4368 1.27152 10.2575 1.09177C10.0781 0.912018 9.83491 0.811035 9.5813 0.811035H6.33442C6.08096 0.811532 5.83802 0.912674 5.6588 1.09232C5.47958 1.27196 5.37867 1.51546 5.37817 1.76951V1.96998H10.5375ZM1.74067 5.8916L2.60317 16.7794C2.63851 17.2068 2.83237 17.6053 3.14651 17.8964C3.46065 18.1875 3.87224 18.35 4.30005 18.3518H11.6375C12.0654 18.35 12.4769 18.1875 12.7911 17.8964C13.1052 17.6053 13.2991 17.2068 13.3344 16.7794L14.2 5.8916H1.74067ZM10.3938 11.442C10.4032 9.04582 10.4219 6.65275 10.4219 6.65275C10.4221 6.61181 10.4303 6.5713 10.4461 6.53355C10.4619 6.4958 10.485 6.46154 10.514 6.43274C10.543 6.40393 10.5774 6.38115 10.6153 6.36569C10.6531 6.35024 10.6936 6.34241 10.7344 6.34265H10.7375C10.8204 6.34373 10.8994 6.3776 10.9573 6.43688C11.0153 6.49615 11.0475 6.57601 11.0469 6.65901C11.0188 10.2361 10.9938 15.6518 11.0344 16.1718C11.0474 16.2182 11.0494 16.2671 11.0404 16.3145C11.0315 16.3619 11.0117 16.4066 10.9827 16.4451C10.9536 16.4836 10.9161 16.5149 10.8731 16.5364C10.83 16.558 10.7826 16.5694 10.7344 16.5696C10.6926 16.5691 10.6512 16.5606 10.6125 16.5445C10.375 16.4443 10.375 16.4443 10.3938 11.442ZM7.6563 6.65588C7.6563 6.57281 7.68922 6.49314 7.74783 6.4344C7.80643 6.37565 7.88592 6.34265 7.9688 6.34265C8.05168 6.34265 8.13116 6.37565 8.18977 6.4344C8.24837 6.49314 8.2813 6.57281 8.2813 6.65588V16.2563C8.2813 16.3394 8.24837 16.4191 8.18977 16.4778C8.13116 16.5366 8.05168 16.5696 7.9688 16.5696C7.88592 16.5696 7.80643 16.5366 7.74783 16.4778C7.68922 16.4191 7.6563 16.3394 7.6563 16.2563V6.65588ZM4.87817 6.65588C4.87817 6.57281 4.9111 6.49314 4.9697 6.4344C5.02831 6.37565 5.10779 6.34265 5.19067 6.34265C5.27355 6.34265 5.35304 6.37565 5.41164 6.4344C5.47025 6.49314 5.50317 6.57281 5.50317 6.65588V16.2563C5.50317 16.3394 5.47025 16.4191 5.41164 16.4778C5.35304 16.5366 5.27355 16.5696 5.19067 16.5696C5.10779 16.5696 5.02831 16.5366 4.9697 16.4778C4.9111 16.4191 4.87817 16.3394 4.87817 16.2563V6.65588Z"
                            fill="#FD1B44" />
                    </svg>
                    Удалить
                    смету
                </div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <div class="estimate_est-wrap  smet center_smets" id="">
        <a href="<?php echo e(route('estimate.create')); ?>" class="estimate-link">
            <div class="create_mets">
                <svg width="71" height="60" viewBox="0 0 71 60" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M35.5 0C35.1134 0 34.8 0.313403 34.8 0.700002V29.1031H1.09394C0.765916 29.1031 0.5 29.369 0.5 29.697C0.5 30.025 0.765915 30.291 1.09394 30.291H34.8V58.6939C34.8 59.0805 35.1134 59.3939 35.5 59.3939C35.8866 59.3939 36.2 59.0805 36.2 58.6939V30.291H69.9061C70.2341 30.291 70.5 30.025 70.5 29.697C70.5 29.369 70.2341 29.1031 69.9061 29.1031H36.2V0.7C36.2 0.313401 35.8866 0 35.5 0Z"
                        fill="#989EAB" />
                </svg>
                <p>Создать смету</p>
            </div>
        </a>
    </div>
</div>
<script>
    const confirmDeleteEstimate = (id) => {
        if (confirm("Вы уверены, что хотите удалить смету?")) {
            dell(id);
        } else {
            // Здесь можно добавить дополнительные действия, если пользователь отменяет удаление
        }
    }
    const dell = (id) => {
        // Отправка запроса на estimate.del
        fetch(`/estimate/del/${id}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                },
            })
            .then(response => {
                if (response.ok) {
                    const element = document.getElementById(`wrap-${id}`);
                    if (element) {
                        element.remove();
                    }
                }
            })
            .catch(error => {
                console.error('Ошибка при удалении элемента:', error);
            });
    }
</script>
<?php /**PATH C:\OSPanel\domains\dlk\resources\views/estimate/estimate.blade.php ENDPATH**/ ?>