<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\PropertiesSearch $searchModel */
/** @var yii\widgets\ActiveForm $form */

?>

<div class="bg-white p-6 rounded-lg shadow-md mb-6">
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => ['data-pjax' => true],
        'fieldConfig' => [
            'template' => '{input}',
            'inputOptions' => [
                'class' => 'form-input border border-gray-300 rounded-lg p-2 focus:ring-blue-500 focus:border-blue-500 w-full'
            ],
        ],
    ]); ?>

    <!-- Filters Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-4 mb-4">
        <?= $form->field($searchModel, 'city')->textInput(['placeholder' => 'Hồ Chí Minh']) ?>
        <?= $form->field($searchModel, 'district_county')->textInput(['placeholder' => 'Chọn Quận/Huyện']) ?>
        <?= $form->field($searchModel, 'ward_commune')->textInput(['placeholder' => 'Chọn Phường/Xã']) ?>
        <?= $form->field($searchModel, 'street_name')->textInput(['placeholder' => 'Chọn Đường Phố']) ?>
        <?= $form->field($searchModel, 'plot_number')->textInput(['placeholder' => 'Số Thửa']) ?>
        <?= $form->field($searchModel, 'sheet_number')->textInput(['placeholder' => 'Số Tờ']) ?>

        <?= $form->field($searchModel, 'property_type_id')->dropDownList($propertyTypes, [
            'prompt' => 'Chọn Loại Sản Phẩm',
            'class' => 'form-select border border-gray-300 rounded-lg p-2 focus:ring-blue-500 focus:border-blue-500 w-full'
        ]) ?>

        <?= $form->field($searchModel, 'listing_type_id')->dropDownList($listingTypes, [
            'prompt' => 'Chọn Giao Dịch',
            'class' => 'form-select border border-gray-300 rounded-lg p-2 focus:ring-blue-500 focus:border-blue-500 w-full'
        ]) ?>

        <!-- Price Range -->
        <div class="flex items-center space-x-2">
            <?= Html::activeTextInput($searchModel, 'price_from', [
                'placeholder' => 'Giá từ',
                'class' => 'form-input border border-gray-300 rounded-lg p-2 w-1/2 focus:ring-blue-500 focus:border-blue-500'
            ]) ?>
            <span>đến</span>
            <?= Html::activeTextInput($searchModel, 'price_to', [
                'placeholder' => 'Giá đến',
                'class' => 'form-input border border-gray-300 rounded-lg p-2 w-1/2 focus:ring-blue-500 focus:border-blue-500'
            ]) ?>
        </div>

        <!-- Area Range -->
        <div class="flex items-center space-x-2">
            <?= Html::activeTextInput($searchModel, 'area_from', [
                'placeholder' => 'Diện Tích từ',
                'class' => 'form-input border border-gray-300 rounded-lg p-2 w-1/2 focus:ring-blue-500 focus:border-blue-500'
            ]) ?>
            <span>đến</span>
            <?= Html::activeTextInput($searchModel, 'area_to', [
                'placeholder' => 'Diện Tích đến',
                'class' => 'form-input border border-gray-300 rounded-lg p-2 w-1/2 focus:ring-blue-500 focus:border-blue-500'
            ]) ?>
        </div>

        <!-- Submit & Reset -->
        <div class="flex space-x-2">
            <?= Html::submitButton('<i class="fas fa-search mr-2"></i> TÌM', [
                'class' => 'bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow-md flex items-center justify-center transition-colors duration-200'
            ]) ?>
            <?= Html::a('<i class="fas fa-sync-alt"></i>', ['index'], [
                'class' => 'bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg shadow-md flex items-center justify-center transition-colors duration-200'
            ]) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

    <!-- Status Buttons -->
    <div class="flex flex-wrap items-center gap-2 mb-4">
        <button class="flex items-center bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-medium">
            <i class="fas fa-tag mr-1 text-blue-500"></i> Tài Sản Đầu Giá
        </button>
        <button class="flex items-center bg-gray-200 text-gray-700 px-3 py-1 rounded-full text-sm font-medium">
            <i class="fas fa-star mr-1 text-yellow-500"></i> Sản Phẩm Mới
        </button>
        <button class="flex items-center bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-medium">
            <i class="fas fa-handshake mr-1 text-green-500"></i> Đang Giao Dịch
        </button>
        <button class="flex items-center bg-orange-100 text-orange-700 px-3 py-1 rounded-full text-sm font-medium">
            <i class="fas fa-comments mr-1 text-orange-500"></i> Ngừng Giao Dịch
        </button>
        <button class="flex items-center bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-sm font-medium">
            <i class="fas fa-money-check-alt mr-1 text-purple-500"></i> Đã Đặt Cọc
        </button>
        <button class="flex items-center bg-pink-100 text-pink-700 px-3 py-1 rounded-full text-sm font-medium">
            <i class="fas fa-file-invoice mr-1 text-pink-500"></i> Có HĐ Thuê
        </button>
        <button class="flex items-center bg-teal-100 text-teal-700 px-3 py-1 rounded-full text-sm font-medium">
            <i class="fas fa-search-location mr-1 text-teal-500"></i> Động Tư Trạch
        </button>
        <button class="flex items-center bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full text-sm font-medium">
            <i class="fas fa-exchange-alt mr-1 text-indigo-500"></i> Tẩy Trạch
        </button>
        <button class="flex items-center bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm font-medium">
            <i class="fas fa-arrow-alt-circle-up mr-1 text-red-500"></i> Tăng giá
        </button>
        <button class="flex items-center bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm font-medium">
            <i class="fas fa-arrow-alt-circle-down mr-1 text-gray-500"></i> Giảm giá
        </button>
    </div>

    <div class="flex items-center gap-2 text-sm text-gray-500">
        <i class="fas fa-exclamation-triangle text-orange-500"></i>
        <span>Đã Xem Hôm Nay</span>
    </div>
</div>
