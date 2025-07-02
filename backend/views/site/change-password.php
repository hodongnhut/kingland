<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\ChangePasswordForm $model */
/** @var yii\widgets\ActiveForm $form */

$this->title = 'Đổi Mật Khẩu';
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- Header -->
<header class="bg-white shadow-md p-2 flex items-center justify-between rounded-bl-lg">
    <div class="text-lg font-semibold text-gray-800"> Thay đổi mật khẩu</div>
    <div class="relative flex items-center space-x-4">
        <button
            id="userMenuButton"
            class="w-10 h-10 bg-blue-500 hover:bg-blue-600 text-white rounded-full flex items-center justify-center shadow-md transition-colors duration-200"
            aria-haspopup="true"
            aria-expanded="false"
        >
            <i class="fas fa-user"></i>
        </button>
        <div
            id="userMenu"
            class="absolute right-0 mt-20 w-48 bg-white border border-gray-200 rounded-md shadow-lg py-1 z-10 hidden"
            role="menu"
            aria-orientation="vertical"
            aria-labelledby="userMenuButton"
        >
            <a href="<?= \yii\helpers\Url::to(['/login-version']) ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Phiên Đăng Nhập</a>
            <a href="<?= \yii\helpers\Url::to(['/change-password']) ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Đổi Mật Khẩu</a>
            <?= Html::a('Đăng Xuất', ['/site/logout'], [
                'data-method' => 'post',
                'class' => 'block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100',
                'role' => 'menuitem'
            ]) ?>
        </div>
    </div>
</header>

<main class="main-content-padding flex-1 p-6 overflow-auto">
    <div class="card-container">
        <h2 class="card-title">Thay đổi mật khẩu</h2>

        <div class="user-form bg-white p-6  mb-6 max-w-2xl mx-auto">
            <?php $form = ActiveForm::begin([
                'id' => 'change-password-form',
                'options' => ['class' => 'space-y-6'],
                'fieldConfig' => [
                    'template' => "{label}\n{input}\n{hint}\n{error}",
                    'options' => ['class' => 'mb-3'],
                    'labelOptions' => ['class' => 'form-label'],
                    'inputOptions' => ['class' => 'form-control'],
                    'errorOptions' => ['class' => 'invalid-feedback d-block'],
                    'hintOptions' => ['class' => 'form-text text-muted'],
                ],
            ]); ?>

            <?= $form->field($model, 'currentPassword')->passwordInput(['placeholder' => 'Nhập mật khẩu hiện tại']) ?>

            <?= $form->field($model, 'newPassword')->passwordInput(['placeholder' => 'Nhập mật khẩu mới']) ?>

            <?= $form->field($model, 'confirmPassword')->passwordInput(['placeholder' => 'Nhập lại mật khẩu mới']) ?>

            <div class="form-group pt-4 text-center">
                <button type="button"
                    class="px-5 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50
                                focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                    Hủy
                </button>
                <?= Html::submitButton('Lưu mật khẩu', ['class' => 'btn btn-primary px-5 py-2']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
    </main>
