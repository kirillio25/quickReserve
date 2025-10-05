<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Vue Laravel App</title>

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body>
<div id="app"></div>

<script type="module" src="<?php echo e(Vite::asset('resources/js/app.js')); ?>"></script>
</body>
</html>
<?php /**PATH /var/www/laravel/resources/views/welcome.blade.php ENDPATH**/ ?>