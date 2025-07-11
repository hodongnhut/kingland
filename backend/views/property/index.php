<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use common\widgets\CustomLinkPager;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;


/** @var yii\web\View $this */
/** @var common\models\PropertiesSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Dữ Liệu Nhà Đất';
$this->params['breadcrumbs'][] = $this->title;
$csrfToken = Yii::$app->request->getCsrfToken();
?>
<header class="bg-white shadow-md p-2 flex items-center justify-between rounded-bl-lg">
    <div class="text-lg font-semibold text-gray-800">Dữ Liệu Nhà Đất</div>
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

    <div class="flex space-x-2 mb-6">   
        <a href="<?= \yii\helpers\Url::to(['/property']) ?>" class="px-6 py-3 rounded-lg bg-white text-blue-600 shadow-md flex items-center space-x-2">
            <i class="fas fa-database"></i>
            <span>Dữ Liệu Nhà Đất</span>
        </a>
        <a href="<?= \yii\helpers\Url::to(['/property-folder']) ?>"
            class="px-6 py-3 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 transition-colors duration-200 flex items-center space-x-2">
            <i class="fas fa-file-alt"></i>
            <span>Quản Lý Tệp</span>
        </a>
        <div class="flex space-x-3">
            <button id="openDialog" class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-md shadow-md flex items-center transition-colors duration-200">
                <i class="fas fa-plus mr-2"></i> TẠO MỚI
            </button>
        </div>
    </div>

    <?php
        echo $this->render('_search', [
            'model' => $searchModel, 
            'listingTypes' => $modelListingTypes, 
            'locationTypes' => $modelLocationTypes, 
            'propertyTypes' => $modelPropertyTypes, 
            'assetTypes' => $modelAssetTypes, 
            'advantages' => $modelAdvantages, 
            'disadvantages' => $modelDisadvantages, 
            'directions' => $modelDirections
        ]); 
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'layout' => "{items}\n",
        'summaryOptions' => [
            'class' => 'text-sm text-gray-700',
            'id' => 'DataTables_Table_0_info',
        ],
        'summary' => 'Hiển thị từ {begin} đến {end} trong tổng số {totalCount} mục',
        'tableOptions' => [
            'class' => 'min-w-full divide-y divide-gray-200',
        ],
        'headerRowOptions' => [
            'class' => 'bg-gray-50',
        ],
        'options' => [
            'class' => 'bg-white rounded-lg shadow-md overflow-x-auto',
        ],
        'columns' => [
            // Serial Column (#)
            [
                'class' => 'yii\grid\DataColumn',
                'label' => '#',
                'contentOptions' => ['class' => 'px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900'],
                'format' => 'raw',
                'value' => function ($model, $key, $index, $column) use ($dataProvider) {
                    $pagination = $dataProvider->getPagination();
                    $page = $pagination->getPage();
                    $pageSize = $pagination->pageSize;
                    $rowNumber = $index + 1 + ($page * $pageSize);
                    return Html::tag('div', $rowNumber, ['class' => 'flex items-center space-x-2']);
                },
            ],
            [
                'attribute' => 'title',
                'label' => 'Số Nhà',
                'contentOptions' => ['class' => 'px-6 py-4 whitespace-nowrap text-sm text-gray-900'],
                'headerOptions' => ['class' => 'px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider'],
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::tag('div', $model->listingType->name, ['class' => 'font-semibold']) .
                        Html::tag('div', $model->propertyType->type_name, ['class' => 'text-xs text-gray-600']) .
                        Html::tag('div', $model->house_number).
                        ($model->plot_number ? Html::tag('div', 'Thửa: '. $model->plot_number) : '').
                        ($model->sheet_number ? Html::tag('div', 'Tờ: '.$model->sheet_number): '');
                },
            ],
            // Đường Phố (Street)
            [
                'attribute' => 'street_name',
                'label' => 'Đường Phố',
                'contentOptions' => ['class' => 'px-6 py-4 whitespace-nowrap text-sm text-gray-900'],
                'headerOptions' => ['class' => 'px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider'],
                'format' => 'raw',
                'value' => function ($model) {
                    $localtionType = $model->locationType ? Html::tag('span', $model->locationType->type_name, [
                        'class' => 'text-xs font-medium px-2.5 py-0.5 rounded-full bg-gray-100 text-gray-800',
                    ]) : " ";
                    $treet = Html::tag('div', $model->street_name, ['class' => 'font-semibold']);
                    return $localtionType . $treet;
                },
            ],
            // Phường/Xã (Ward/Commune)
            [
                'attribute' => 'ward_commune',
                'label' => 'Phường/Xã',
                'contentOptions' => ['class' => 'px-6 py-4 whitespace-nowrap text-sm text-gray-900'],
                'headerOptions' => ['class' => 'px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider'],
            ],
            // Quận/Huyện (District/County)
            [
                'attribute' => 'district_county',
                'label' => 'Quận/Huyện',
                'contentOptions' => ['class' => 'px-6 py-4 whitespace-nowrap text-sm text-gray-900'],
                'headerOptions' => ['class' => 'px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider'],
            ],
            // Giá (Price)
            [
                'attribute' => 'price',
                'label' => 'Giá',
                'contentOptions' => ['class' => 'px-6 py-4 whitespace-nowrap text-sm text-gray-900'],
                'headerOptions' => ['class' => 'px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider'],
                'format' => 'raw',
                'value' => function ($model) {
                    // Format price (assuming price is in VND and stored as numeric value)
                    $price = number_format($model->price / 1e9, 1) . ' Tỷ VNĐ';
                    // Calculate price per m² (check for null or zero to avoid division by zero)
                    $pricePerM2 = (!empty($model->area_total) && $model->area_total > 0) 
                        ? number_format($model->price / $model->area_total / 1e6, 0) . ' Triệu/m2' 
                        : '-';
                    return Html::tag('div', $price, ['class' => 'font-semibold text-red-600']) .
                        Html::tag('div', '-' . $pricePerM2, ['class' => 'text-xs text-gray-600']);
                },
            ],
            // Diện Tích (Area)
            [
                'attribute' => 'area_total',
                'label' => 'Diện Tích',
                'contentOptions' => ['class' => 'px-6 py-4 whitespace-nowrap text-sm text-gray-900'],
                'headerOptions' => ['class' => 'px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider'],
                'format' => 'raw',
                'value' => function ($model) {
                    $dimensions = ($model->area_width && $model->area_length) 
                        ? "({$model->area_width}m × {$model->area_length}m)" 
                        : '';
                    return Html::tag('div', $model->area_total . ' m2', ['class' => 'font-semibold']) .
                        Html::tag('div', $dimensions, ['class' => 'text-xs text-gray-600']);
                },
            ],
            // Kết Cấu (Structure, empty)
            [
                'label' => 'Kết Cấu',
                'contentOptions' => ['class' => 'px-6 py-4 whitespace-nowrap text-sm text-gray-900'],
                'headerOptions' => ['class' => 'px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider'],
                'value' => function () { return ''; },
            ],
            // HĐ Thuê (Lease Contract, empty)
            [
                'label' => 'HĐ Thuê',
                'contentOptions' => ['class' => 'px-6 py-4 whitespace-nowrap text-sm text-gray-900'],
                'headerOptions' => ['class' => 'px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider'],
                'value' => function () { return ''; },
            ],
            // Lưu (Favorite Icon)
            [
                'label' => 'Lưu',
                'contentOptions' => ['class' => 'px-6 py-4 whitespace-nowrap text-sm text-gray-900'],
                'headerOptions' => ['class' => 'px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider'],
                'format' => 'raw',
                'value' => function () {
                    return Html::tag('i', '', ['class' => 'far fa-heart text-gray-400']);
                },
            ],
            // Cập nhật (Transaction Status and Update Time)
            [
                'attribute' => 'transaction_status_id',
                'label' => 'Cập nhật',
                'contentOptions' => ['class' => 'px-6 py-4 whitespace-nowrap text-sm text-gray-900'],
                'headerOptions' => ['class' => 'px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider'],
                'format' => 'raw',
                'value' => function ($model) {
                    $statusBadge = $model->transactionStatus ? Html::tag('span', $model->transactionStatus->status_name, [
                        'class' => 'text-xs font-medium px-2.5 py-0.5 rounded-full ' . $model->transactionStatus->class_css,
                    ]) : " ";
                    // Format updated_at (assuming it's a timestamp)
                    $updateTime = Yii::$app->formatter->asDatetime($model->updated_at, 'php:H:i \t\g\i\ứ d/m/Y');
                    $updateTimeDiv = Html::tag('div', 'Hôm Qua lúc ' . $updateTime, ['class' => 'text-xs text-gray-500 mt-1']);
                    // Add edit button for rows with "Sản Phẩm Mới" (assuming a condition, e.g., is_new = 1)
                    $editButton = $model->is_new ?? false ? Html::a(
                        '<i class="fas fa-pencil-alt mr-1"></i>Sản Phẩm Mới',
                        ['update', 'property_id' => $model->property_id],
                        ['class' => 'mt-2 text-blue-600 hover:text-blue-800 text-xs flex items-center']
                    ) : '';
                    return $statusBadge . $updateTimeDiv . $editButton;
                },
            ],
            // Action Column
            [
                'class' => 'yii\grid\ActionColumn',
                'contentOptions' => ['class' => 'px-6 py-4 whitespace-nowrap text-sm text-gray-900'],
                'headerOptions' => ['class' => 'px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider'],
                'urlCreator' => function ($action, $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'property_id' => $model->property_id]);
                },
                'template' => '{view} {update}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<i class="fas fa-eye"></i>', $url, [
                            'class' => 'text-blue-600 hover:text-blue-800 mx-1',
                            'title' => 'View',
                        ]);
                    },
                    'update' => function ($url, $model) {
                        return Html::a('<i class="fas fa-pencil-alt"></i>', $url, [
                            'class' => 'text-blue-600 hover:text-blue-800 mx-1',
                            'title' => 'Update',
                        ]);
                    },
                ],
            ],
        ],
    ]);

    echo CustomLinkPager::widget([
        'pagination' => $dataProvider->pagination,
        'options' => ['class' => ''],
        'view' => '@backend/views/pagination/pagination.php',
        'maxButtonCount' => 5,
        'firstPageLabel' => false,
        'lastPageLabel' => false,
        'prevPageLabel' => '<i class="fas fa-chevron-left"></i>',
        'nextPageLabel' => '<i class="fas fa-chevron-right"></i>',
    ]);
?>

<div id="dialog" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl">
            <div class="flex justify-between items-center p-4 border-b">
                <h2 class="text-xl font-semibold text-gray-800">DỮ LIỆU NHÀ ĐẤT</h2>
                <button id="cancelIcon" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times-circle text-2xl"></i>
                </button>
            </div>

            <?php $form = ActiveForm::begin([
                'id' => 'property-form',
                'action' => ['property/create'], 
                'method' => 'post',
                'enableAjaxValidation' => false, 
                'enableClientValidation' => true,
                'fieldConfig' => [
                    'errorOptions' => ['class' => 'invalid-feedback d-block'], 
                ], 
            ]); ?>

                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">

                    <div>
                        <?= $form->field($model, 'listing_types_id', [
                            'options' => ['class' => ''], // No extra div for this field
                        ])->radioList([
                            1 => 'Bán', 
                            2 => 'Cho Thuê', 
                        ], [
                            'item' => function ($index, $label, $name, $checked, $value) {
                                $check = $checked ? 'checked' : '';
                                return "<label class='inline-flex items-center'>" .
                                    "<input type='radio' class='form-radio text-blue-600' name='{$name}' value='{$value}' {$check}>" .
                                    "<span class='ml-2 text-gray-700'>{$label}</span>" .
                                    "</label>";
                            }
                        ])->label('<span class="text-red-500">*</span> Loại Giao Dịch') ?>
                    </div>

                    <div>
                        <?= $form->field($model, 'property_type_id')->dropDownList(
                            ArrayHelper::map($modelPropertyTypes, 'property_type_id', 'type_name'),
                            [
                                'prompt' => 'Chọn Loại BĐS',
                                'class' => 'shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline'
                            ]
                        )->label('<span class="text-red-500">*</span> Loại BĐS') 
                        ?>
                    </div>

                    <div>
                        <?= $form->field($model, 'provinces')->dropDownList(
                           ArrayHelper::map($modelProvinces, 'id', 'Name'),
                            [
                                'prompt' => 'Chọn Tỉnh Thành', 
                                'class' => 'shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline'
                                ]
                        )->label('<span class="text-red-500">*</span> Tỉnh Thành') ?>
                    </div>

                    <div>
                        <?= $form->field($model, 'districts')->dropDownList(
                            ArrayHelper::map($modelDistricts, 'id', 'Name'),
                            [
                                'prompt' => 'Chọn Quận Huyện...', 
                                'class' => 'shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline']
                        )->label('<span class="text-red-500">*</span> Quận Huyện') ?>
                    </div>

                    <div>
                        <?= $form->field($model, 'wards')->dropDownList(
                            [], // Populate dynamically based on district
                            [
                                'prompt' => 'Chọn Phường / Xã', 
                                'class' => 'shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline']
                        )->label('<span class="text-red-500">*</span> Phường / Xã') ?>
                    </div>

                    <div>
                        <?= $form->field($model, 'streets')->dropDownList(
                            [], // Populate dynamically based on ward
                            [
                                'prompt' => 'Chọn Đường', 
                                'class' => 'shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline'
                                ]
                        )->label('<span class="text-red-500">*</span> Đường') ?>
                    </div>

                    <div>
                        <?= $form->field($model, 'house_number')->textInput([
                            'class' => 'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline'
                        ]) ?>
                    </div>

                    <div>
                        <?= $form->field($model, 'plot_number')->textInput([
                            'class' => 'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline'
                        ]) ?>
                    </div>

                    <div>
                        <?= $form->field($model, 'sheet_number')->textInput([
                            'class' => 'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline'
                        ]) ?>
                    </div>

                    <div>
                        <?= $form->field($model, 'lot_number')->textInput([
                            'class' => 'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline'
                        ]) ?>
                    </div>

                    <div class="md:col-span-2">
                        <?= $form->field($model, 'region')->textInput([
                            'placeholder' => 'Ví dụ: CityLand, Trung Sơn, Cư Xá Phú Lâm...',
                            'class' => 'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline'
                        ]) ?>
                    </div>

                </div>

                <div class="p-6 flex justify-center space-x-4 border-t">
                    <?= Html::submitButton('<i class="fas fa-arrow-right mr-2"></i> TIẾP TỤC', ['id'=> 'createButton',  'class' => 'bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-md inline-flex items-center']) ?>
                    <?= Html::button('<i class="fas fa-times mr-2"></i> HỦY', ['id' => 'cancelButton', 'class' => 'bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-md inline-flex items-center']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<script>
    const openDialogButton = document.getElementById('openDialog');
    const dialog = document.getElementById('dialog');
    const cancelButton = document.getElementById('cancelButton');
    const cancelIcon = document.getElementById('cancelIcon');
    const createButton = document.getElementById('createButton');
    const inputField = document.getElementById('inputField');

    // Open dialog
    openDialogButton.addEventListener('click', () => {
      dialog.classList.remove('hidden');
    });

    // Close dialog on cancel
    cancelButton.addEventListener('click', () => {
      dialog.classList.add('hidden');
      inputField.value = ''; // Reset input
    });

    cancelIcon.addEventListener('click', () => {
      dialog.classList.add('hidden');
      inputField.value = ''; // Reset input
    });

    // Handle Tạo mới button click
    createButton.addEventListener('click', () => {
      const inputValue = inputField.value;
      if (inputValue.trim()) {
        alert(`Đã tạo mới với thông tin: ${inputValue}`);
        dialog.classList.add('hidden');
        inputField.value = ''; // Reset input
      } else {
        alert('Vui lòng nhập thông tin!');
      }
    });

    // Close dialog when clicking outside
    dialog.addEventListener('click', (e) => {
      if (e.target === dialog) {
        dialog.classList.add('hidden');
        inputField.value = ''; // Reset input
      }
    });
  </script>
</main>

<?php
$script = <<< JS
$('#propertiesfrom-provinces').on('change', function() {
    var provinceId = $(this).val();
    $.ajax({
        url: '/address/districts',
        type: 'GET',
        data: { ProvinceId: provinceId },
        headers: {
            'X-CSRF-Token': '$csrfToken'
        },
        success: function(data) {
            $('select[name="PropertiesFrom[districts]"]').html(data);
        },
        error: function(xhr, status, error) {
            console.error('AJAX error:', error);
        }
    });
});
JS;
$this->registerJs($script);
?>

<?php
$script = <<< JS
$('#propertiesfrom-districts').on('change', function() {
    var districtId = $(this).val();
    $.ajax({
        url: '/address/wards',
        type: 'GET',
        data: { DistrictId: districtId },
        headers: {
            'X-CSRF-Token': '$csrfToken'
        },
        success: function(data) {
            $('select[name="PropertiesFrom[wards]"]').html(data);
        },
        error: function(xhr, status, error) {
            console.error('AJAX error:', error);
        }
    });
    $.ajax({
        url: '/address/streets',
        type: 'GET',
        data: { DistrictId: districtId },
        headers: {
            'X-CSRF-Token': '$csrfToken'
        },
        success: function(data) {
            $('select[name="PropertiesFrom[streets]"]').html(data);
        },
        error: function(xhr, status, error) {
            console.error('AJAX error:', error);
        }
    });
});
JS;
$this->registerJs($script);
?>