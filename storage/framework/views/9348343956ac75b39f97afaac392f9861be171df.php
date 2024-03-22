<?php $__env->startSection('title', __('Вы пытаетесь')); ?>
<?php //$__env->startSection('code', '500'); ?>
<?php $__env->startSection('message', __('Вы пытаетесь зарегистрировать пользователя, который уже существует в системе!')); ?>

<?php echo $__env->make('errors::minimal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vendor/laravel/framework/src/Illuminate/Foundation/Exceptions/views/500.blade.php ENDPATH**/ ?>
