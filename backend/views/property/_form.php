<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
Use common\models\Directions;
use common\models\LandType;
use common\models\Interiors;
use common\models\Advantages;
use common\models\Disadvantages;
use common\models\AssetTypes;
use common\models\CommissionTypes;

if ($model->listing_types_id === 2) {
    $interiors = Interiors::find()->all();
    $selected = array_column($model->interiors, 'interior_id');
}

$advantages = Advantages::find()->all();
$disadvantages = Disadvantages::find()->all();

$selectedAdvantages = array_column($model->advantages, 'advantage_id');
$selectedDisadvantages = array_column($model->disadvantages, 'disadvantage_id');

$assetTypes = ArrayHelper::map(AssetTypes::find()->all(), 'asset_type_id', 'type_name');

$commissionTypes = ArrayHelper::map(CommissionTypes::find()->all(), 'id', 'name');


/** @var yii\web\View $this */
/** @var common\models\Properties $model */
?>

<div class="bg-white p-6 rounded-lg shadow-md ">
    <div class="flex items-center justify-between">
        <h2 class="text-lg font-semibold text-gray-800">
            <a href="<?= \yii\helpers\Url::to(['/property']) ?>">Màn hình chính</a> / 
            Thêm Dữ Liệu Nhà Đất [Mã: <?= $model->property_id ?>]</h2>
        <div class="flex space-x-2">
            <?= Html::submitButton('Lưu Lại', [
                'onclick' => 'submitPropertyForm()',
                'class' => 'px-4 py-2 bg-orange-600 text-white rounded-md shadow-sm hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500'
            ]) ?>
            <?= Html::a('Quay lại', Yii::$app->request->referrer ?: ['index'], ['class' => 'px-4 py-2 bg-gray-200 text-gray-800 rounded-md shadow-sm hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500']) ?>
        </div>
    </div>
</div>

<div class="bg-white mt-2 p-4 shadow-md flex items-center justify-between rounded-bl-lg rounded-br-lg rounded-tr-lg rounded-tl-lg">
    <nav class="flex space-x-4">
        <button id="thong-tin-tab" class="px-4 py-2 text-orange-600 border-b-2 border-orange-600 font-medium rounded-t-md">Thông Tin</button>
        <button id="so-hong-tab" class="px-4 py-2 text-gray-600 hover:text-orange-600 hover:border-b-2 hover:border-orange-600 transition-colors duration-200 rounded-t-md">Sổ Hồng & Hình Ảnh</button>
    </nav>
    <div class="text-lg font-semibold text-gray-800">
        Địa Chỉ <span class="text-gray-500 text-sm">→ Số 17-19 Phan Đình Phùng, Phường 17, Phú Nhuận, TP.HCM</span>
    </div>
</div>

<main class="flex-1 mt-2 overflow-y-auto hide-scrollbar">
    <div id="thong-tin-content" class="tab-content">
        <?php $form = ActiveForm::begin([
            'id'=> 'property',
            'fieldConfig' => [
                'template' => "{label}\n{input}\n{hint}\n{error}",
                'labelOptions' => ['class' => 'form-label'],
                'inputOptions' => ['class' => 'form-control'],
                'errorOptions' => ['class' => 'invalid-feedback d-block'], 
                'hintOptions' => ['class' => 'form-text text-muted'],
                ],
            ]); 
        ?>
        <!-- Hiển thị thông báo flash -->
        <?php if (Yii::$app->session->hasFlash('success')): ?>
            <div class="alert alert-success">
                <?= Yii::$app->session->getFlash('success') ?>
            </div>
        <?php endif; ?>
        <?php if (Yii::$app->session->hasFlash('error')): ?>
            <div class="alert alert-danger">
                <?= Yii::$app->session->getFlash('error') ?>
            </div>
        <?php endif; ?>
         
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Column 1: Property Details -->
            <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow-md space-y-6">
                <!-- Property Type Tabs -->
                <label class="text-md font-semibold text-gray-800 required">Vị Trí BĐS</label>
                <div class="flex space-x-2 mb-4" id="location-type-buttons">
                    <button type="button" data-value="1"
                        class="location-btn px-4 py-2 text-sm font-medium rounded-full bg-gray-100 text-gray-700 hover:bg-gray-200">
                        Mặt Tiền
                    </button>
                    <button type="button" data-value="2"
                        class="location-btn px-4 py-2 text-sm font-medium rounded-full bg-gray-100 text-gray-700 hover:bg-gray-200">
                        Đường Nội Bộ
                    </button>
                    <button type="button" data-value="3"
                        class="location-btn px-4 py-2 text-sm font-medium rounded-full bg-gray-100 text-gray-700 hover:bg-gray-200">
                        Hẻm
                    </button>
                    <button type="button" data-value="4"
                        class="location-btn px-4 py-2 text-sm font-medium rounded-full bg-gray-100 text-gray-700 hover:bg-gray-200">
                        Compound
                    </button>
                </div>
                <?= $form->field($model, 'location_type_id')->hiddenInput(['id' => 'location_type_id'])->label(false) ?>

                <!-- Price Section -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-1 required">Giá</label>
                        <?= $form->field($model, 'price', [
                            'template' => '{input}{error}', // ẩn label mặc định và chỉ hiện input + lỗi
                        ])->textInput([
                            'id' => 'price',
                            'maxlength' => true,
                            'class' => 'mt-1 block w-full border rounded-md shadow-sm py-2 px-3 sm:text-sm ' .
                                ($model->hasErrors('price') 
                                    ? 'border-red-500 focus:border-red-500 focus:ring-red-500'
                                    : 'border-gray-300 focus:border-orange-500 focus:ring-orange-500'),
                        ]) ?>
                    </div>
                    <div>
                        <label for="final_price" class="block text-sm font-medium text-gray-700 mb-1">Giá Chót</label>
                        <input type="text" id="final_price" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm" value="0">
                    </div>
                </div>
                <?php if ($model->listing_types_id != 2) : ?>
                <!-- Rental Contract Checkbox -->
                <div class="flex items-center">
                    <?= $form->field($model, 'has_rental_contract', [
                        'template' => '{input}{label}{error}',
                        'labelOptions' => [
                            'for' => 'has_rental_contract',
                            'class' => 'ml-2 block text-sm text-gray-900',
                        ],
                        'options' => ['class' => 'flex items-center'],
                    ])->checkbox([
                        'id' => 'has_rental_contract',
                        'class' => 'h-4 w-4 text-orange-600 focus:ring-orange-500 border-gray-300 rounded',
                        'label' => false, 
                    ]) ?>
                    <label for="rental_contract" class="ml-2 block text-sm text-gray-900">
                        Có Hợp đồng thuê
                    </label>
                </div>
                <?php endif; ?>
                <!-- Parcel/Lot Numbers -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="plot_number" class="block text-sm font-medium text-gray-700 mb-1">Số Thửa</label>
                        <?= $form->field($model, 'plot_number', [
                            'template' => '{input}{error}',
                        ])->textInput([
                            'id' => 'plot_number',
                            'class' => 'mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm'
                        ]) ?>
                    </div>
                    <div>
                        <label for="map_sheet_number" class="block text-sm font-medium text-gray-700 mb-1">Số Tờ</label>
                        <?= $form->field($model, 'sheet_number', [
                            'template' => '{input}{error}',
                        ])->textInput([
                            'id' => 'sheet_number',
                            'class' => 'mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm'
                        ]) ?>
                    </div>
                    <div>
                        <label for="lot_number" class="block text-sm font-medium text-gray-700 mb-1">Số Lô</label>
                        <?= $form->field($model, 'lot_number', [
                            'template' => '{input}{error}',
                        ])->textInput([
                            'id' => 'lot_number',
                            'class' => 'mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm'
                        ]) ?>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="project_name" class="block text-sm font-medium text-gray-700 mb-1 required">Số Nhà</label>
                        <?= $form->field($model, 'street_name', [
                            'template' => '{input}{error}',
                        ])->textInput([
                            'id' => 'street_name',
                            'maxlength' => true,
                            'class' => 'mt-1 block w-full border rounded-md shadow-sm py-2 px-3 sm:text-sm ' .
                                ($model->hasErrors('street_name')
                                    ? 'border-red-500 focus:border-red-500 focus:ring-red-500'
                                    : 'border-gray-300 focus:border-orange-500 focus:ring-orange-500'),
                        ]) ?>
                    </div>
                    <!-- Project Name -->
                    <div>
                        <label for="region" class="block text-sm font-medium text-gray-700 mb-1">Khu vực</label>
                        <?= $form->field($model, 'region', [
                            'template' => '{input}{error}',
                        ])->textInput([
                            'id' => 'region',
                            'maxlength' => true,
                            'class' => 'mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm',
                            'placeholder' => 'Nhập tên khu vực'
                        ]) ?>
                    </div>
                </div>
                <!-- Address Details -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="province" class="block text-sm font-medium text-gray-700 mb-1 required">Tỉnh / TP</label>
                        <select id="province" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm">
                            <option>TP Hồ Chí Minh</option>
                            <option>Hà Nội</option>
                        </select>
                    </div>
                    <div>
                        <label for="district" class="block text-sm font-medium text-gray-700 mb-1 required">Quận / Huyện</label>
                        <select id="district" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm">
                            <option>Phú Nhuận</option>
                            <option>Quận 1</option>
                        </select>
                    </div>
                   
                    <div>
                        <label for="ward" class="block text-sm font-medium text-gray-700 mb-1 required">Phường / Xã</label>
                        <select id="ward" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm">
                            <option>Phường 17</option>
                            <option>Phường 1</option>
                        </select>
                    </div>
                </div>
                
                <!-- Dimensions Section -->
                <h3 class="text-md font-semibold text-gray-800 mt-6 mb-3">Diện Tích Đất</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div>
                        <label for="frontage" class="block text-sm font-medium text-gray-700 mb-1 required">Ngang</label>
                        <div class="relative mt-1 rounded-md shadow-sm">
                            <?= $form->field($model, 'area_width', options: [
                                'template' => '{input}{error}',
                                ])->textInput([
                                    'id' => 'area_width',
                                    'maxlength' => true,
                                    'class' => 'block w-full pr-10 border rounded-md py-2 px-3 sm:text-sm ' .
                                        ($model->hasErrors('area_width') 
                                            ? 'border-red-500 focus:border-red-500 focus:ring-red-500'
                                            : 'border-gray-300 focus:ring-orange-500 focus:border-orange-500'),
                                ]) 
                            ?>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">m</span>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label for="rearage" class="block text-sm font-medium text-gray-700 mb-1 required">Dài</label>
                        <div class="relative mt-1 rounded-md shadow-sm">
                            <?= $form->field($model, 'area_length', options: [
                                'template' => '{input}{error}',
                                ])->textInput([
                                    'id' => 'area_length',
                                    'maxlength' => true,
                                    'class' => 'block w-full pr-10 border rounded-md py-2 px-3 sm:text-sm ' .
                                        ($model->hasErrors('area_length') 
                                            ? 'border-red-500 focus:border-red-500 focus:ring-red-500'
                                            : 'border-gray-300 focus:ring-orange-500 focus:border-orange-500'),
                                ]) 
                            ?>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">m</span>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label for="planned_back_side" class="block text-sm font-medium text-gray-700 mb-1">Mặt Hậu</label>
                        <div class="relative mt-1 rounded-md shadow-sm">
                            <?= $form->field($model, 'planned_back_side', [
                                'template' => '{input}{error}',
                            ])->textInput([
                                'id' => 'planned_back_side',
                                'maxlength' => true,
                                'class' => 'block w-full pr-10 border border-gray-300 rounded-md py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm',
                            ]) ?>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">m²</span>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label for="planned_area" class="block text-sm font-medium text-gray-700 mb-1 required">DT Công Nhận</label>
                        <div class="relative mt-1 rounded-md shadow-sm">
                            <?= $form->field($model, 'area_total', [
                                'template' => '{input}{error}',
                            ])->textInput([
                                'id' => 'area_total',
                                'maxlength' => true,
                                'class' => 'block w-full pr-10 border border-gray-300 rounded-md py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm',
                                'placeholder' => '0.00',
                            ]) ?>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">m²</span>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if ($model->listing_types_id != 2) : ?>
                    <h3 class="text-md font-semibold text-gray-800 mt-6 mb-3">Diện Tích Quy Hoạch</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div>
                            <label for="frontage" class="block text-sm font-medium text-gray-700 mb-1">Ngang</label>
                            <div class="relative mt-1 rounded-md shadow-sm">
                                <?= $form->field($model, 'planned_width', [
                                    'template' => '{input}{error}',
                                ])->textInput([
                                    'id' => 'planned_width',
                                    'maxlength' => true,
                                    'class' => 'block w-full pr-10 border border-gray-300 rounded-md py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm',
                                    'placeholder' => '9.00',
                                ]) ?>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">m</span>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label for="rearage" class="block text-sm font-medium text-gray-700 mb-1">Dài</label>
                            <div class="relative mt-1 rounded-md shadow-sm">
                                <?= $form->field($model, 'planned_length', [
                                    'template' => '{input}{error}',
                                ])->textInput([
                                    'id' => 'planned_length',
                                    'maxlength' => true,
                                    'class' => 'block w-full pr-10 border border-gray-300 rounded-md py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm',
                                    'placeholder' => '11.00',
                                ]) ?>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">m</span>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label for="area" class="block text-sm font-medium text-gray-700 mb-1">Mặt Hậu</label>
                            <div class="relative mt-1 rounded-md shadow-sm">
                                <?= $form->field($model, 'planned_back_side', [
                                    'template' => '{input}{error}',
                                ])->textInput([
                                    'id' => 'planned_back_side',
                                    'maxlength' => true,
                                    'class' => 'block w-full pr-10 border border-gray-300 rounded-md py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm',
                                    'placeholder' => '115.00',
                                ]) ?>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">m²</span>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label for="planned_area" class="block text-sm font-medium text-gray-700 mb-1">DT Xây Dựng</label>
                            <div class="relative mt-1 rounded-md shadow-sm">
                                <?= $form->field($model, 'planned_construction_area', [
                                    'template' => '{input}{error}',
                                ])->textInput([
                                    'id' => 'planned_construction_area',
                                    'maxlength' => true,
                                    'class' => 'block w-full pr-10 border border-gray-300 rounded-md py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm',
                                    'placeholder' => '0.00',
                                ]) ?>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">m²</span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <!-- Characteristics Section -->
                <h3 class="text-md font-semibold text-gray-800 mb-3">Thông Tin Khác</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-4">
                    <div>
                        <label for="product_type" class="block text-sm font-medium text-gray-700 mb-1 required">Loại sản phẩm</label>
                        <?= $form->field($model, 'property_type_id', [
                            'template' => '{input}{error}',
                        ])->dropDownList(
                            ArrayHelper::map($modelPropertyTypes, 'property_type_id', 'type_name'),
                            [
                                'prompt' => 'Chọn loại sản phẩm',
                                'id' => 'property_type_id',
                                'class' => 'mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm'
                            ]
                        ) ?>
                    </div>
                    <div>
                        <label for="direction" class="block text-sm font-medium text-gray-700 mb-1">Hướng</label>
                        <?= $form->field($model, 'direction_id', [
                            'template' => '{input}{error}',
                        ])->dropDownList(
                            ArrayHelper::map(Directions::find()->where(['<>', 'id', 0])->all(), 'id', 'name'),
                            [
                                'id' => 'direction_id',
                                'class' => 'mt-1 block w-full border rounded-md shadow-sm py-2 px-3 sm:text-sm ' .
                                    ($model->hasErrors('direction_id') 
                                        ? 'border-red-500 focus:border-red-500 focus:ring-red-500'
                                        : 'border-gray-300 focus:border-orange-500 focus:ring-orange-500'),
                                'prompt' => 'Chọn Hướng',
                            ]
                        ) ?>
                    </div>
                    <?php if ($model->listing_types_id != 2) : ?>
                        <div>
                            <label for="direction" class="block text-sm font-medium text-gray-700 mb-1">Loại Đất</label>
                            <?= $form->field($model, 'land_type', [
                                'template' => '{input}{error}',
                            ])->dropDownList(
                                ArrayHelper::map(LandType::find()->all(), 'id', 'name'),
                                [
                                    'id' => 'land_type',
                                    'prompt' => 'Chọn loại đất',
                                    'class' => 'mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm'
                                ]
                            ) ?>
                        </div>
                    <?php endif; ?>
                    <div>
                        <label for="road_width" class="block text-sm font-medium text-gray-700 mb-1">Đường rộng</label>
                        <div class="relative mt-1 rounded-md shadow-sm">
                        <?= $form->field($model, 'wide_road', [
                            'template' => '{input}{error}',
                            ])->textInput([
                                'id' => 'wide_road',
                                'maxlength' => true,
                                'class' => 'block w-full pr-10 border border-gray-300 rounded-md py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm',
                                'placeholder' => '2',
                            ]) 
                        ?>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">m</span>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label for="usable_area" class="block text-sm font-medium text-gray-700 mb-1">DT Sử dụng</label>
                        <div class="relative mt-1 rounded-md shadow-sm">
                            <?= $form->field($model, 'usable_area', [
                                'template' => '{input}{error}',
                            ])->textInput([
                                'id' => 'usable_area',
                                'maxlength' => true,
                                'class' => 'block w-full pr-10 border border-gray-300 rounded-md py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm',
                                'placeholder' => '2'
                            ]) ?>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">m²</span>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label for="num_floors" class="block text-sm font-medium text-gray-700 mb-1">Số Tầng</label>
                        <?= $form->field($model, 'num_floors', [
                            'template' => '{input}{error}',
                        ])->textInput([
                            'id' => 'num_floors',
                            'class' => 'mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm',
                            'placeholder' => '0'
                        ]) ?>
                    </div>
                    <div>
                        <label for="num_bedrooms" class="block text-sm font-medium text-gray-700 mb-1">Số phòng ngủ</label>
                        <?= $form->field($model, 'num_bedrooms', [
                            'template' => '{input}{error}',
                        ])->textInput([
                            'id' => 'num_bedrooms',
                            'class' => 'mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm',
                            'placeholder' => '0'
                        ]) ?>
                    </div>
                    <div>
                        <label for="num_bathrooms" class="block text-sm font-medium text-gray-700 mb-1">Số WC</label>
                        <?= $form->field($model, 'num_toilets', [
                                'template' => '{input}{error}',
                            ])->textInput([
                                'id' => 'num_toilets',
                                'class' => 'mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm',
                                'placeholder' => '0',
                            ]) ?>
                    </div>
                    <div>
                        <label for="num_basements" class="block text-sm font-medium text-gray-700 mb-1">Số tầng hầm</label>
                        <?= $form->field($model, 'num_basements', [
                            'template' => '{input}{error}',
                        ])->textInput([
                            'id' => 'num_basements',
                            'class' => 'mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm',
                            'placeholder' => '0',
                        ]) ?>
                    </div>

                </div>
                <?php if ($model->listing_types_id === 2) : ?>
                    <h3 class="text-md font-semibold text-gray-800 mb-3">NỘI THẤT</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-x-8 gap-y-2 text-sm text-gray-700">
                    <?php foreach ($interiors as $interior): ?>
                        <label class="flex items-center">
                            <input 
                                type="checkbox"
                                name="interiors[]" 
                                value="<?= $interior->interior_id ?>"
                                class="form-checkbox h-4 w-4 text-orange-600 rounded"
                                <?= in_array($interior->interior_id, $selected) ? 'checked' : '' ?>
                            >
                            <span class="ml-2"><?= htmlspecialchars($interior->name) ?></span>
                        </label>
                    <?php endforeach; ?>
                </div>  
                <?php endif; ?>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-2 text-sm text-gray-700">
                    <!-- Column 1: Ưu Điểm -->
                    <div>
                        <h3 class="text-md font-semibold text-gray-800 mb-3">Ưu Điểm</h3>
                        <?php foreach ($advantages as $advantage): ?>
                            <label class="flex items-center mb-2">
                                <input 
                                    type="checkbox" 
                                    class="form-checkbox h-4 w-4 text-orange-600 rounded" 
                                    name="advantages[]" 
                                    value="<?= $advantage->advantage_id ?>"
                                    <?= in_array($advantage->advantage_id, $selectedAdvantages) ? 'checked' : '' ?>>
                                <span class="ml-2"><?= htmlspecialchars($advantage->name) ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                    <!-- Column 2: Nhược Điểm -->
                    <div>
                        <h3 class="text-md font-semibold text-gray-800 mb-3">Nhược Điểm</h3>

                        <?php foreach ($disadvantages as $disadvantag): ?>
                        <label class="flex items-center mb-2">
                            <input 
                                type="checkbox" 
                                class="form-checkbox h-4 w-4 text-orange-600 rounded" 
                                name="disadvantages[]" 
                                value="<?= $disadvantag->disadvantage_id ?>"
                                <?= in_array($disadvantag->disadvantage_id, $selectedDisadvantages) ? 'checked' : '' ?>>
                            <span class="ml-2"><?= htmlspecialchars($disadvantag->disadvantage_name) ?></span>
                        </label>
                    <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <!-- Column 2: Asset Type, Commission, Status, Advantages/Disadvantages, and Features -->
            <div class="lg:col-span-1 bg-white p-6 rounded-lg shadow-md space-y-6">
                <!-- Asset Type Section -->
                <div>
                    <label class="text-md font-semibold text-gray-800 mb-3 required">Loại Tài Sản</label>
                    <div class="flex flex-wrap gap-2">
                    <?= $form->field($model, 'asset_type_id', [
                         'template' => '{input}{error}',
                    ])->radioList(
                            $assetTypes,
                            [
                                'item' => function($index, $label, $name, $checked, $value) {
                                    return '<label class="inline-flex items-center mr-4">' .
                                        '<input type="radio" class="form-radio text-orange-600 h-4 w-4" name="' . $name . '" value="' . $value . '" ' . ($checked ? 'checked' : '') . '>' .
                                        '<span class="ml-2 text-sm text-gray-700">' . htmlspecialchars($label) . '</span>' .
                                    '</label>';
                                },
                                'separator' => '',
                            ]
                        ) ?>
                    </div>
                    <p class="text-xs text-gray-500 mt-3 mb-2">Nếu bạn có thông tin liên hệ chủ nhà thì hãy điền vào đây.</p>
                    <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm" placeholder="Nhập thông tin liên hệ...">
                </div>
                <!-- Commission Type Section -->
                <div>
                    <h3 class="text-md font-semibold text-gray-800 mb-3">Loại Hoa Hồng</h3>
                    <div class="flex space-x-4 mb-2">
                    <?php foreach ($commissionTypes as $id => $name): ?>
                        <label class="inline-flex items-center">
                            <input 
                                type="radio" 
                                class="form-radio text-orange-600 h-4 w-4" 
                                name="Properties[commission_types_id]" 
                                value="<?= $id ?>" 
                                <?= $model->commission_types_id == $id ? 'checked' : '' ?>>
                            <span class="ml-2 text-sm text-gray-700"><?= Html::encode($name) ?></span>
                        </label>
                    <?php endforeach; ?>
                    </div>
                    <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm" placeholder="Tên">
                    <input type="text" class="mt-3 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm" placeholder="Phần trăm">
                </div>
                <!-- Status Section -->
                <div>
                    <h3 class="text-md font-semibold text-gray-800 mb-3">Trạng Thái</h3>
                    <div class="flex flex-wrap gap-2 mb-2">
                        <label class="inline-flex items-center">
                        <input type="radio" class="form-radio text-orange-600 h-4 w-4" name="status" value="trading" checked>
                        <span class="ml-2 text-sm text-gray-700">Đang Giao Dịch</span>
                        </label>
                        <label class="inline-flex items-center">
                        <input type="radio" class="form-radio text-orange-600 h-4 w-4" name="status" value="stopped">
                        <span class="ml-2 text-sm text-gray-700">Ngừng Giao Dịch</span>
                        </label>
                        <label class="inline-flex items-center">
                        <input type="radio" class="form-radio text-orange-600 h-4 w-4" name="status" value="traded">
                        <span class="ml-2 text-sm text-gray-700">Đã Giao Dịch</span>
                        </label>
                        <label class="inline-flex items-center">
                        <input type="radio" class="form-radio text-orange-600 h-4 w-4" name="status" value="deposited">
                        <span class="ml-2 text-sm text-gray-700">Đã Cọc</span>
                        </label>
                    </div>
                    <textarea class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm" rows="2" placeholder="Nhập Thông Tin Mô Tả"></textarea>
                </div>
            </div>
         </div>
        <?php ActiveForm::end(); ?>
    </div>
    <div id="so-hong-content" class="tab-content hidden bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-md font-semibold text-gray-800 mb-3">Hình ảnh đã tải lên</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white rounded-lg border border-gray-200 p-4">
                <div class="flex items-center mb-4">
                    <div class="bg-purple-600 text-white p-2 rounded-md mr-3 flex-shrink-0">
                        <i class="fas fa-file-alt text-lg"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800">SỔ HỒNG | GIẤY TỜ PHÁP LÝ</h3>
                </div>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center text-gray-500 hover:border-blue-400 hover:text-blue-600 cursor-pointer transition duration-200 ease-in-out">
                    <i class="fas fa-cloud-upload-alt text-4xl mb-2"></i>
                    <p>Chọn hoặc kéo thả</p>
                    <p class="text-xs">File: pdf, jpg, png, jpeg, webp, heic!</p>
                    <input type="file" multiple class="hidden">
                </div>
            </div>
            <div class="bg-white rounded-lg border border-gray-200 p-4">
                <div class="flex items-center mb-4">
                    <div class="bg-blue-600 text-white p-2 rounded-md mr-3 flex-shrink-0">
                        <i class="fas fa-images text-lg"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800">HÌNH ẢNH BỔ SUNG</h3>
                </div>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center text-gray-500 hover:border-blue-400 hover:text-blue-600 cursor-pointer transition duration-200 ease-in-out">
                    <i class="fas fa-cloud-upload-alt text-4xl mb-2"></i>
                    <p>Chọn hoặc kéo thả</p>
                    <p class="text-xs">File: pdf, jpg, png, jpeg, webp, heic!</p>
                    <input type="file" multiple class="hidden">
                </div>
            </div>
        </div>
        <br>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <!-- Placeholder for uploaded images -->
            <div class="relative group aspect-w-1 aspect-h-1 w-full rounded-lg overflow-hidden border border-gray-200">
                <img src="https://placehold.co/150x150/e0e0e0/555555?text=Image+1" alt="Placeholder Image 1" class="object-cover w-full h-full">
                <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                    <button class="text-white bg-red-500 hover:bg-red-600 p-2 rounded-full">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="relative group aspect-w-1 aspect-h-1 w-full rounded-lg overflow-hidden border border-gray-200">
                <img src="https://placehold.co/150x150/d0d0d0/444444?text=Image+2" alt="Placeholder Image 2" class="object-cover w-full h-full">
                <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                    <button class="text-white bg-red-500 hover:bg-red-600 p-2 rounded-full">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="relative group aspect-w-1 aspect-h-1 w-full rounded-lg overflow-hidden border border-gray-200">
                <img src="https://placehold.co/150x150/e0e0e0/555555?text=Image+1" alt="Placeholder Image 1" class="object-cover w-full h-full">
                <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                    <button class="text-white bg-red-500 hover:bg-red-600 p-2 rounded-full">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</main>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const thongTinTab = document.getElementById('thong-tin-tab');
        const soHongTab = document.getElementById('so-hong-tab');
        const thongTinContent = document.getElementById('thong-tin-content');
        const soHongContent = document.getElementById('so-hong-content');
    
        function activateTab(tabButton, contentDiv) {
            document.querySelectorAll('.tab-content').forEach(content => content.classList.add('hidden'));
            document.querySelectorAll('nav button').forEach(button => {
                button.classList.remove('text-orange-600', 'border-orange-600');
                button.classList.add('text-gray-600', 'hover:text-orange-600', 'hover:border-orange-600');
            });
    
            tabButton.classList.add('text-orange-600', 'border-b-2', 'border-orange-600');
            tabButton.classList.remove('text-gray-600', 'hover:text-orange-600', 'hover:border-orange-600');
            contentDiv.classList.remove('hidden');
        }
    
        thongTinTab.addEventListener('click', function() {
            activateTab(thongTinTab, thongTinContent);
        });
    
        soHongTab.addEventListener('click', function() {
            activateTab(soHongTab, soHongContent);
        });
    
        activateTab(thongTinTab, thongTinContent);


        // handler button Vị trí BDS
        const buttons = document.querySelectorAll('#location-type-buttons .location-btn');
        const hiddenInput = document.getElementById('location_type_id');

        buttons.forEach(btn => {
            btn.addEventListener('click', () => {

                buttons.forEach(b => {
                    b.classList.remove('bg-orange-100', 'text-orange-700');
                    b.classList.add('bg-gray-100', 'text-gray-700');
                });


                btn.classList.remove('bg-gray-100', 'text-gray-700');
                btn.classList.add('bg-orange-100', 'text-orange-700');

                // Gán giá trị vào input ẩn
                hiddenInput.value = btn.dataset.value;
            });
        });

        // Gán nút active khi đã có giá trị sẵn từ model
        const currentVal = hiddenInput.value;
        if (currentVal) {
            const activeBtn = [...buttons].find(b => b.dataset.value === currentVal);
            if (activeBtn) activeBtn.click();
        }
    });

    function submitPropertyForm() {
        const form = document.getElementById('property');
        if (form) {
            form.submit();
        }
    }
</script>

