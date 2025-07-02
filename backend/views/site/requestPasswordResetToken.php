<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \frontend\models\PasswordResetRequestForm $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Quên mật khẩu?';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="w-full max-w-md bg-white rounded-lg shadow-xl p-8 space-y-6 md:p-10">
    <div class="text-center">
        <div
            class="mx-auto h-16 w-16 bg-blue-600 rounded-full flex items-center justify-center text-white mb-4 shadow-md">
            <i class="fas fa-lock text-3xl"></i>
        </div>
        <h2 class="text-3xl font-extrabold text-gray-900 mb-2"><?= Html::encode($this->title) ?></h2>
        <p class="text-sm text-gray-500">Yêu cầu cấp lại mật khẩu</p>
    </div>

    <?php $form = ActiveForm::begin([
            'id' => 'request-password-reset-form',
            'options' => ['class' => 'space-y-6'],
            'fieldConfig' => [
                'options' => ['class' => 'mb-3'], 
                'inputOptions' => ['class' => 'form-control'], 
                'labelOptions' => ['class' => 'form-label'],
            ],
        ]); ?>

        <?= $form->field($model, 'email', [
            'template' => "{label}\n<div class=\"input-group\">"
                          . "<span class=\"input-group-text\"><i class=\"fas fa-envelope\"></i></span>"
                          . "{input}</div>\n{hint}\n{error}",
            'inputOptions' => [
                'autofocus' => true,
                'placeholder' => 'your.email@example.com',
            ],
        ])->label('Email') ?>

        <div class="form-group">
            <?= Html::submitButton('Gửi Yêu Cầu', ['class' => 'btn btn-primary w-100 py-2', 'name' => 'login-button']) ?>
        </div>
        <div class="form-group">
            <?= Html::button('Quay lại đăng nhập', ['class' => 'btn btn-primary w-100 py-2', 'onclick' => 'window.history.back();']) ?>
        </div>

    <?php ActiveForm::end(); ?>

</div>
