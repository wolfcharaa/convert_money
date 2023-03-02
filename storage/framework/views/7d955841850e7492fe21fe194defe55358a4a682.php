        <!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href='css/Style.css'>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<h1>Конвертация валют</h1>
<p>Выберите валюту и суммы, чтобы получить обменный курс</p>
<form action="/main" method="POST">
    <?php echo csrf_field(); ?>
<div class="container">
    <div class="currency">
        <select id="currency-one" name="from" required>
            <?php $__currentLoopData = $currencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currency => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value=<?php echo e($currency); ?>><?php echo e($currency); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <input name="count" type="number" id="amount-one" placeholder="0"/>
    </div>

    <div class="swap-rate-container">

        <div class="rate">
            <button type="submit" class="btn" id="swap">
                Рассчитать️
            </button></div>
    </div>

    <div class="currency">
        <select id="currency-two" name="to" required>
            <?php $__currentLoopData = $currencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currency => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value=<?php echo e($currency); ?>><?php echo e($currency); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <input type="number" id="amount-two" placeholder="0" value="<?php echo e($result); ?>" />
    </div>
</div>
</form>
</body>
</html>
<?php /**PATH /home/wolfchara/project/www/convert_money/resources/views/main.blade.php ENDPATH**/ ?>