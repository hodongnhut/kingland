<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Categories; 
$role_code = Yii::$app->user->identity->jobTitle->role_code;
$this->title = "Xem Bản Tin Nội Bộ";

$categories = \yii\helpers\ArrayHelper::map(Categories::find()->all(), 'category_id', 'category_name');
?>

<header class="bg-white shadow-md p-2 flex items-center justify-between rounded-bl-lg">
    <div class="text-lg font-semibold text-gray-800">Xem Bản Tin Nội Bộ</div>
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
<main class="flex-1 p-6 overflow-auto">
    <div class="bg-white p-6 rounded-lg shadow-md mb-6">
        <p class="text-sm text-gray-500 mb-2">Màn hình chính / Xem Bản Tin Nội Bộ</p>
        <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-4 sm:mb-0"> Thông Báo</h2>
            <? if ($role_code === 'manager' ||  $role_code == 'super_admin'):  ?>
                <?= Html::a('<i class="fas fa-plus mr-2"></i> Tạo Bài Viết Mới', ['create'], ['class' => 'bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-md shadow-md flex items-center transition-colors duration-200']) ?>
            <?php endif; ?>    
        </div>

        <?php $form = ActiveForm::begin([
            'action' => ['index'],
            'method' => 'get',
            'options' => ['class' => 'flex flex-col md:flex-row gap-4 mb-8 items-center'],
            'fieldConfig' => [
                'template' => '{input}',
                'options' => ['class' => 'relative w-full md:w-auto flex-grow'],
            ],
        ]); ?>

            <div class="relative w-full md:w-auto flex-grow">
                <?= $form->field($searchModel, 'category_id')->dropDownList(
                    ['' => 'Chọn Nhóm Bản Tin'] + (isset($categories) ? $categories : []),
                    ['class' => 'block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm']
                )->label(false) ?>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                    <i class="fas fa-chevron-down text-sm"></i>
                </div>
            </div>

            <?= $form->field($searchModel, 'post_title')->textInput([
                'placeholder' => 'Tên Bài Viết',
                'class' => 'flex-1 w-full md:w-auto px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm'
            ])->label(false) ?>

            <?= Html::submitButton('<i class="fas fa-search mr-2"></i> TÌM KIẾM', [
                'class' => 'w-full md:w-auto bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-md shadow-md flex items-center justify-center transition-colors duration-200'
            ]) ?>

        <?php ActiveForm::end(); ?>

        <div class="space-y-4">
            <?php if ($dataProvider->getModels()): ?>
                <?php foreach ($dataProvider->getModels() as $model): ?>
                    <?php
                    $iconText = '';
                    $bgColor = 'bg-white';
                    $textColor = 'text-gray-800'; 
                    $shadow = 'shadow-md';

                    switch ($model->post_type) {
                        case 'DOC':
                            $iconText = 'DOC';
                            $bgColor = 'bg-blue-50'; 
                            $textColor = 'text-gray-800';
                            $shadow = 'shadow-sm'; 
                            break;
                        case 'NEWS':
                            $iconText = 'NEWS';
                            $bgColor = 'bg-white';
                            $textColor = 'text-gray-800';
                            $shadow = 'shadow-md';
                            break;
                        case 'EVENT':
                            $iconText = 'EVENT';
                            $bgColor = 'bg-white';
                            $textColor = 'text-gray-800';
                            $shadow = 'shadow-md';
                            break;
                        default:
                            $iconText = 'GEN'; 
                            $bgColor = 'bg-white';
                            $textColor = 'text-gray-800';
                            $shadow = 'shadow-md';
                            break;
                    }
                    $imgSrc = "https://placehold.co/80x80/F0F0F0/888888?text={$iconText}";
                    if ($model->post_type === 'DOC') {
                         $imgSrc = "https://placehold.co/80x80/E0F2FE/004085?text={$iconText}";
                    }
                    ?>
                    <div class="<?= $bgColor ?> rounded-lg p-4 flex flex-col sm:flex-row items-start sm:items-center space-y-3 sm:space-y-0 sm:space-x-4 <?= $shadow ?>">
                        <div class="flex-shrink-0">
                            <img src="<?= $imgSrc ?>" alt="<?= $iconText ?> icon" class="rounded-md">
                        </div>
                        <div class="flex-grow">
                            <div class="text-sm text-gray-500 mb-1 flex items-center">
                                <i class="fas fa-calendar-alt mr-2"></i> <?= Yii::$app->formatter->asDate($model->post_date, 'php:d-m-Y') ?>
                            </div>
                            <h3 class="text-lg font-semibold <?= $textColor ?>"><?= Html::encode($model->post_title) ?></h3>
                        </div>
                        <div class="flex-shrink-0 flex space-x-3 mt-3 sm:mt-0">
                            <? if ($role_code === 'manager' ||  $role_code == 'super_admin'):  ?>
                                <?= Html::a('<i class="fas fa-edit text-lg"></i>', ['update', 'post_id' => $model->post_id], ['class' => 'text-blue-600 hover:text-blue-800', 'title' => 'Chỉnh sửa']) ?>
                                <?= Html::a('<i class="fas fa-trash-alt text-lg"></i>', ['delete', 'post_id' => $model->post_id], [
                                    'class' => 'text-red-600 hover:text-red-800',
                                    'title' => 'Xóa',
                                    'data' => [
                                        'confirm' => 'Bạn có chắc chắn muốn xóa bài viết này?',
                                        'method' => 'post',
                                    ],
                                ]) ?>
                                <?= Html::a('<i class="fas fa-eye text-lg"></i>', ['view', 'post_id' => $model->post_id], ['class' => 'text-gray-600 hover:text-gray-800', 'title' => 'Xem chi tiết']) ?>
                            <?php endif; ?>    
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center text-gray-500">Không tìm thấy bài viết nào.</p>
            <?php endif; ?>
        </div>

        <?php
        echo \yii\widgets\LinkPager::widget([
            'pagination' => $dataProvider->getPagination(),
            'options' => ['class' => 'flex justify-center mt-8 space-x-2'],
            'linkContainerOptions' => ['class' => 'inline-block'],
            'linkOptions' => ['class' => 'px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-100'],
            'activePageCssClass' => 'bg-blue-500 text-white hover:bg-blue-600',
            'disabledListItemSubTagOptions' => ['tag' => 'span', 'class' => 'px-4 py-2 border border-gray-300 rounded-md text-gray-400'],
        ]);
        ?>
    </div>
</main>
