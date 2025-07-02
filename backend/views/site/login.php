<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \common\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Đăng Nhập';
?>
<div class="w-full max-w-md bg-white rounded-lg shadow-xl p-8 space-y-6 md:p-10">
    <div class="text-center">
        <div
            class="mx-auto h-16 w-16 bg-blue-600 rounded-full flex items-center justify-center text-white mb-4 shadow-md">
            <i class="fas fa-lock text-3xl"></i>
        </div>
        <h2 class="text-3xl font-extrabold text-gray-900 mb-2"><?= Html::encode($this->title) ?></h2>
        <p class="text-sm text-gray-500">Truy cập vào tài khoản của bạn</p>
    </div>


    <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            'options' => ['class' => 'space-y-6'],
            'fieldConfig' => [
                'options' => ['class' => 'mb-3'], 
                'inputOptions' => ['class' => 'form-control'], 
                'labelOptions' => ['class' => 'form-label'],
            ],
        ]); ?>

        <?= $form->field($model, 'usernameOrEmail', [
            'template' => "{label}\n<div class=\"input-group\">"
                          . "<span class=\"input-group-text\"><i class=\"fas fa-envelope\"></i></span>"
                          . "{input}</div>\n{hint}\n{error}",
            'inputOptions' => [
                'autofocus' => true,
                'placeholder' => 'your.email@example.com',
            ],
        ])->label('Email Hoặc Mã') ?>

        <?= $form->field($model, 'password', [
            'template' => "{label}\n<div class=\"input-group\">"
                          . "<span class=\"input-group-text\"><i class=\"fas fa-key\"></i></span>"
                          . "{input}</div>\n{hint}\n{error}",
            'inputOptions' => [
                'placeholder' => '********',
            ],
        ])->label('Mật khẩu') ?>

        <div class="d-flex justify-content-between align-items-center mb-3">

                <?= $form->field($model, 'rememberMe')->checkbox([
                    'class' => 'form-check-input',
                    'labelOptions' => ['class' => 'form-check-label ms-2'],
                ])->label('Ghi nhớ đăng nhập') ?>
 

            <div class="text-sm">
                <a href="/site/request-password-reset" class="text-decoration-none text-primary">
                    Quên mật khẩu?
                </a>
            </div>
        </div>

        <div class="form-group">
            <?= Html::submitButton('Đăng Nhập', ['class' => 'btn btn-primary w-100 py-2', 'name' => 'login-button']) ?>
        </div>

        <?php ActiveForm::end(); ?>

</div>
