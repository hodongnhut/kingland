<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\JobTitles;
use common\models\Departments;
use yii\helpers\ArrayHelper;
$jobTitleMap = ArrayHelper::map(JobTitles::find()->all(), 'job_title_id', 'title_name');
$departmentMap = ArrayHelper::map(Departments::find()->all(), 'department_id', 'department_name');


/** @var yii\web\View $this */
/** @var common\models\User $model */
/** @var yii\widgets\ActiveForm $form */
?>
<!-- Header -->
<header class="bg-white shadow-md p-2 flex items-center justify-between rounded-bl-lg">
    <div class="text-lg font-semibold text-gray-800"> Tài Khoản</div>
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
        <h2 class="card-title">Tạo/Chỉnh sửa Người dùng</h2>

        <div class="user-form bg-white p-6  mb-6 max-w-2xl mx-auto">
            <?php $form = ActiveForm::begin([
                'id' => 'user-form',
                'options' => ['class' => 'form-spacing'],
                'fieldConfig' => [
                    'template' => "{label}\n{input}\n{hint}\n{error}",
                    'options' => ['class' => 'mb-3'],
                    'labelOptions' => ['class' => 'form-label'],
                    'inputOptions' => ['class' => 'form-control'],
                    'errorOptions' => ['class' => 'invalid-feedback d-block'], 
                    'hintOptions' => ['class' => 'form-text text-muted'],
                ],
            ]); ?>

            <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'type' => 'email']) ?>

            <?= $form->field($model, 'full_name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

            <?php if ($model->isNewRecord): ?>
                <?= $form->field($model, 'password')->passwordInput(['maxlength' => true])
                    ->hint('Mật khẩu người dùng') ?>
            <?php endif; ?>

            <?= $form->field($model, 'job_title_id')->dropDownList(
                        $jobTitleMap,
                        ['prompt' => 'Chọn chức vụ...']
                    ) ?>

            <?= $form->field($model, 'department_id')->dropDownList(
                $departmentMap,
                ['prompt' => 'Chọn phòng ban...']
            ) ?>

            <?= $form->field($model, 'status')->hiddenInput()->label(false) ?>

            <div class="flex justify-end space-x-4 pt-4">
                <?= Html::a('Quay lại', Yii::$app->request->referrer ?: ['index'], ['class' => 'px-5 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50
                                focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200 btn btn-primary px-5 py-2']) ?>
                <button type="submit"
                    class="px-5 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700
                                focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                    <i class="fas fa-plus mr-2"></i> Tạo nhân viên
                </button>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</main>
