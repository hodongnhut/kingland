<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use common\models\Properties;
use common\widgets\CustomLinkPager;


/** @var yii\web\View $this */
/** @var common\models\PropertiesSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Dữ Liệu Nhà Đất';
$this->params['breadcrumbs'][] = $this->title;
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

    <?php echo $this->render('_search', ['model' => $searchModel, 'listingTypes' => $modelListingTypes, 'locationTypes' => $modelLocationTypes, 'propertyTypes' => $modelPropertyTypes, 'assetTypes' => $modelAssetTypes, 'advantages' => $modelAdvantages, 'disadvantages' => $modelDisadvantages, 'directions' => $modelDirections]); ?>

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
                'headerOptions' => ['class' => 'px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider'],
                'format' => 'raw',
                'value' => function ($model, $key, $index, $column) use ($dataProvider) {
                    $pagination = $dataProvider->getPagination();
                    $page = $pagination->getPage();
                    $pageSize = $pagination->pageSize;
                    $rowNumber = $index + 1 + ($page * $pageSize);
                    return Html::tag('div', $rowNumber . Html::checkbox('selection[]', false, [
                        'class' => 'form-checkbox h-4 w-4 text-blue-600 rounded ml-2',
                    ]), ['class' => 'flex items-center space-x-2']);
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
                        Html::tag('div', $model->title);
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
                    return Html::tag('div', $model->street_name, ['class' => 'font-semibold']);
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
                    $statusBadge = Html::tag('span', $model->transactionStatus->status_name, [
                        'class' => 'text-xs font-medium px-2.5 py-0.5 rounded-full ' . $model->transactionStatus->class_css,
                    ]);
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

            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        <span class="text-red-500">*</span> Loại Giao Dịch
                    </label>
                    <div class="flex space-x-4">
                        <label class="inline-flex items-center">
                            <input type="radio" class="form-radio text-blue-600" name="transactionType" value="ban" checked>
                            <span class="ml-2 text-gray-700">Bán</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" class="form-radio text-blue-600" name="transactionType" value="cho_thue">
                            <span class="ml-2 text-gray-700">Cho Thuê</span>
                        </label>
                    </div>
                </div>

                <div>
                    <label for="propertyType" class="block text-gray-700 text-sm font-bold mb-2">
                        <span class="text-red-500">*</span> Loại BĐS
                    </label>
                    <select id="propertyType" name="propertyType" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="">Chọn Loại BĐS</option>
                        </select>
                </div>

                <div>
                    <label for="province" class="block text-gray-700 text-sm font-bold mb-2">
                        <span class="text-red-500">*</span> Tỉnh Thành
                    </label>
                    <select id="province" name="province" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="ho_chi_minh">Hồ Chí Minh</option>
                        </select>
                </div>

                <div>
                    <label for="district" class="block text-gray-700 text-sm font-bold mb-2">
                        <span class="text-red-500">*</span> Quận Huyện
                    </label>
                    <select id="district" name="district" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="">Chọn Quận Huyện...</option>
                        </select>
                </div>

                <div>
                    <label for="ward" class="block text-gray-700 text-sm font-bold mb-2">
                        <span class="text-red-500">*</span> Phường / Xã
                    </label>
                    <select id="ward" name="ward" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="">Chọn Phường / Xã</option>
                        </select>
                </div>

                <div>
                    <label for="street" class="block text-gray-700 text-sm font-bold mb-2">
                        <span class="text-red-500">*</span> Đường
                    </label>
                    <select id="street" name="street" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="">Chọn Đường</option>
                        </select>
                </div>

                <div>
                    <label for="houseNumber" class="block text-gray-700 text-sm font-bold mb-2">
                        Số Nhà
                    </label>
                    <input type="text" id="houseNumber" name="houseNumber" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <div>
                    <label for="parcelNumber" class="block text-gray-700 text-sm font-bold mb-2">
                        Số Thửa
                    </label>
                    <input type="text" id="parcelNumber" name="parcelNumber" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <div>
                    <label for="sheetNumber" class="block text-gray-700 text-sm font-bold mb-2">
                        Số Tờ
                    </label>
                    <input type="text" id="sheetNumber" name="sheetNumber" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <div>
                    <label for="lotNumber" class="block text-gray-700 text-sm font-bold mb-2">
                        Số Lô
                    </label>
                    <input type="text" id="lotNumber" name="lotNumber" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <div class="md:col-span-2">
                    <label for="areaDescription" class="block text-gray-700 text-sm font-bold mb-2">
                        Khu Vực
                    </label>
                    <input type="text" id="areaDescription" name="areaDescription" placeholder="Ví dụ: CityLand, Trung Sơn, Cư Xá Phú Lâm..." class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

            </div>

            <div class="p-6 flex justify-center space-x-4 border-t">
                <a id="createButton" href="/property/create" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-md inline-flex items-center">
                    <i class="fas fa-arrow-right mr-2"></i> TIẾP TỤC
                </a>
                <button id="cancelButton" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-md inline-flex items-center">
                    <i class="fas fa-times mr-2"></i> HỦY
                </button>
            </div>
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