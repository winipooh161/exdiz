<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title>Экспресс Дизайн | Смета</title>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="description"
        content='Студия Экспресс Дизайнов №1 в России и СНГ. Уже более четырех лет воплощает в реальность "Экспресс-Дизайн" проекты. Нашу основу составляет творческая команда, реализующая "Экспресс-Дизайн" проекты по всей России и СНГ. Проекты от 19.900 рублей за 10 дней. Гарантия качества результата! Более 4000 довольных клиентов. Замеры в день обращения. Закупки материалов мебели&nbsp;под&nbsp;ключ.'>
    <meta name="author" content="kwol.ru">
    <meta name="copyright" content="kwol.ru">
    <meta name="robots" content="index, follow">
    <link rel="icon" href="<?php echo e(asset('favicon.ico')); ?>" type="image/x-icon">
    
    
    
    
    
    
    
    <style type="text/css">
        * {
            /*font-family: Helvetica, sans-serif;*/
            font-family: "DejaVu Sans", sans-serif;
            font-size: 14px;
        }
        h2 {
            font-size: 12px
        }
        .logo {
            height: auto;
            width: 300px;
            margin-right: 50px;
        }
        p {
            margin: 0;
            padding: 0;
        }
        .logo img {
            width: 100%;
            height: auto;
        }
        header.header {
            width: 100%;
            display: flex;
            height: 230px;
        }
        .info p {
            margin: 0;
            padding: 0;
        }
        th {
            padding: 10px;
            border: 1px solid #000;
        }
        .info {
            width: 100%;
            position: absolute;
            top: 40px;
            text-align: right;
            left: 15px;
            color: #000;
            text-align: left;
            font-size: 20px;
            font-style: normal;
            font-weight: 400;
            line-height: normal;
        }
        h2 {
            color: #000;
            text-align: center;
            font-size: 25px;
            font-style: normal;
            font-weight: 600;
            margin: 0 0 10px 0;
            line-height: normal;
        }
        .sub_title {
            color: #000;
            text-align: center;
            font-size: 18px;
            font-style: normal;
            font-weight: 300;
            line-height: normal;
        }
        .header_tablle {
            background: #00A3FF;
            color: #fff;
        }
        td {
            padding: 5px;
            border: 1px solid #000;
        }
        .result {
            color: #000;
            font-size: 30px;
            font-family: "DejaVu Sans", sans-serif;
            margin: 50px 0;
        }
        .result.result-discount {
            font-size: 20px;
            margin: -50px 0 50px 0;
        }
        .block_info {
            color: #000;
            font-size: 20px;
            font-style: normal;
            font-weight: 400;
            line-height: normal;
        }
        .smeta_estimate {
            padding: 10px 30px;
            border: none;
            border-radius: 15px;
            margin: 10px;
            color: #fff;
            font-weight: 700;
            background: #00a3ff;
        }
        .table-subtitle {
            background: #a8ffb3;
            font-weight: 700;
        }
        .table_substage {
            font-weight: 700;
        }
        .table_result {
            background: #a8e6ff;
            font-weight: 700;
        }
        .table_result_all {
            background: #a8e6ff;
            font-weight: 700;
            text-transform: uppercase;
        }
        .summ-end-table {
            font-weight: 700;
        }
        .subscribers {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
            position: relative;
        }
        .table_subscribers-wrap {
            max-width: 300px;
            width: 100%;
        }
        .table_subscribers-wrap-right {
            max-width: 300px;
            width: 100%;
            position: absolute;
            right: 0;
            top: 0;
        }
        .subscribers_title {
            font-weight: 700
        }
        .subscribers-line {
            width: 100%;
            height: 30px;
            border-bottom: 2px solid #000;
        }
        .subscribers-info {
            font-size: 12px
        }
        .info-wrap {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
            position: relative;
            flex-direction: column
        }
        .info-wrap-left {
            max-width: 300px;
            width: 100%;
            position: absolute;
            right: 0;
            top: 0;
        }
        .table-title {
            font-weight: 700
        }
    </style>
</head>
<body>
    <div class="container create-container">
        <header class="header">
            <div class="logo">
                <img src="<?php echo e(asset('assets/logo/logo.png')); ?>" alt="Описание изображения" style="" alt="2323">
            </div>
            <div class="info">
                <div class="info-wrap">
                    <p>№ Сметы: <?php echo e($estimate->id); ?></p>
                    <p>Составил: <?php echo e($user->name); ?> </p>
                    
                    <p>Телефон: <?php echo e($user->phone); ?></p>
                    <p>Почта: <?php echo e($user->email); ?></p>
                    <div class="info-wrap-left">
                        <p class="<?php echo \Illuminate\Support\Arr::toCssClasses('summ-end-table'); ?>">Сумма со скидкой: <?php echo e($summEnd); ?> &#8381;</p>
                        <p>Сумма без скидки: <?php echo e($summNoDiscount); ?> &#8381;</p>
                    </div>
                </div>
            </div>
        </header>
        
        <form action="<?php echo e(route('estimate.pdf')); ?>/<?php echo e($estimate->id); ?>" class="create-step_2-form" method="POST">
            <?php if($isGeneratingPdf == false): ?>
                <button type="submit" class="smeta_estimate" id="createButton" onclick="removeButton()">Сохранить
                    смету</button>
            <?php endif; ?>
            <?php echo csrf_field(); ?>
            <table>
                <thead>
                    <tr class="table-title">
                        <?php
                            $dateEstimate = $estimate->updated_at;
                            $dateEstimate = \Carbon\Carbon::parse($estimate->updated_at)->format('d.m.Y');
                        ?>
                        <th colspan="6">СМЕТА от <?php echo e($dateEstimate); ?> г.</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $counterTabel = 1;
                    ?>
                    <?php $__currentLoopData = $estimateData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($key !== 'price'): ?>
                            <tr class="table-subtitle">
                                <td></td>
                                <td>Итого. <?php echo e($key); ?></td>
                                <td>Ед. изм.</td>
                                <td>Кол. </td>
                                <td>Цена</td>
                                <td>Сумма</td>
                            </tr>
                            <?php if(is_array($data)): ?>
                                <?php
                                    $counterSubTabel = 1;
                                    $prewSubstage = null;
                                    $peiceCountStage = 0;
                                ?>
                                <?php $__currentLoopData = $data['info']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subKey => $subData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $substage = $subData['substage'];
                                        $EndElementPrice = $subData['count'] * $subData['price'];
                                        $peiceCountStage += $EndElementPrice;
                                    ?>
                                    <?php if($subData['count'] > 0): ?> <!-- Добавлено условие -->
                                        <?php if($substage != $prewSubstage): ?>
                                            <tr>
                                                <td class="table_substage" colspan="6"><?php echo e($subData['substage']); ?></td>
                                            </tr>
                                        <?php endif; ?>
                                        <tr>
                                            <td><?php echo e($subData['substage']); ?></td>
                                            <td><?php echo e(str_replace('_', ' ', explode(',', $subKey)[0])); ?></td>
                                            <td><?php echo e(str_replace('_', ' ', explode(',', $subKey)[1])); ?></td>
                                            <td><?php echo e($subData['count']); ?></td>
                                            <td><?php echo e(number_format($subData['price'], 2, ',', '.')); ?>&nbsp;&#8381;</td>
                                            <td><?php echo e(number_format($EndElementPrice, 2, ',', '.')); ?>&nbsp;&#8381;</td>
                                        </tr>
                                    <?php endif; ?>
                                    <?php
                                        $counterSubTabel++;
                                        $prewSubstage = $subData['substage'];
                                    ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                            <tr class="table_result">
                                <td colspan="5">Итого по разделу. (<?php echo e($key); ?>)</td>
                                <td><?php echo e($peiceCountStage); ?>&nbsp;&#8381;</td>
                            </tr>
                        <?php endif; ?>
                        <?php
                            $counterTabel++;
                        ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <tr class="table_result_all">
                        <td colspan="5">Итого по помещению. Стоимость работ</td>
                        <td><?php echo e($summEnd); ?>&nbsp;&#8381;</td>
                    </tr>
                </tbody>
            </table>
            <div class="subscribers">
                <div class="table_subscribers-wrap">
                    <p class="subscribers_title">Составили:</p>
                    <p class="subscribers-line"></p>
                    <p class="subscribers-line"></p>
                    <p class="subscribers-info">Расшифровка подписи</p>
                </div>
                <div class="table_subscribers-wrap-right">
                    <p class="subscribers_title">Составили:</p>
                    <p class="subscribers-line"></p>
                    <p class="subscribers-line"></p>
                    <p class="subscribers-info">Расшифровка подписи</p>
                </div>
            </div>
        </form>
    </div>
    <script>
        // Получение всех элементов с классом "example-class"
        var elements = document.querySelectorAll(".example-class");
        // Проход по каждому найденному элементу
        elements.forEach(function(element) {
            // Ваш код для работы с каждым элементом
            console.log(element.textContent);
        });
    </script>
</body>
<?php /**PATH C:\OSPanel\domains\dlk\resources\views\estimate\preview.blade.php ENDPATH**/ ?>