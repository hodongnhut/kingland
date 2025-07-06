<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use common\models\Properties;
use yii\widgets\LinkPager;

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
            <button class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-md shadow-md flex items-center transition-colors duration-200">
                <i class="fas fa-plus mr-2"></i> TẠO MỚI
            </button>
        </div>
    </div>

    <?php echo $this->render('_search', ['model' => $searchModel, 'listingTypes' => $modelListingTypes, 'locationTypes' => $modelLocationTypes, 'propertyTypes' => $modelPropertyTypes, 'assetTypes' => $modelAssetTypes, 'advantages' => $modelAdvantages, 'disadvantages' => $modelDisadvantages, 'directions' => $modelDirections]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'layout' => "{items}\n{summary}",
        'summaryOptions' =>
        [
            'id' => 'DataTables_Table_0_info'
        ],
        'summary' => 'Hiển thị từ {begin} đến {end} trong tổng số {totalCount} mục',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'title',
            'property_type_id',
            'price',
            'currency_id',
            //'has_vat_invoice',
            //'house_number',
            //'street_name',
            //'ward_commune',
            //'district_county',
            //'city',
            //'location_type_id',
            //'compound_name',
            //'area_width',
            //'area_length',
            //'area_total',
            //'planned_width',
            //'planned_length',
            //'planned_construction_area',
            //'usable_area',
            //'direction',
            //'land_type',
            //'num_toilets',
            //'num_bedrooms',
            //'num_basements',
            //'asset_type_id',
            //'description:ntext',
            //'has_deposit',
            //'transaction_status_id',
            //'transaction_description:ntext',
            //'has_rental_contract',
            //'is_active',
            //'created_at',
            //'updated_at',
            //'external_id',
            //'num_floors',
            //'plot_number',
            //'sheet_number',
            //'lot_number',
            //'commission_types_id',
            //'commission_prices_id',
            //'area_back_side',
            //'wide_road',
            //'planned_back_side',
            //'property_images_id',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Properties $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'property_id' => $model->property_id]);
                 }
            ],
        ],
    ]); ?>
    <?= LinkPager::widget([
        'pagination' => $dataProvider->pagination,
        'options' => ['class' => 'pagination justify-content-end'],
        'linkContainerOptions' => ['class' => 'page-item'],
        'linkOptions' => ['class' => 'page-link'],
        'disabledListItemSubTagOptions' => ['tag' => 'a', 'class' => 'page-link', 'href' => '#', 'tabindex' => '-1', 'aria-disabled' => 'true'],
        'prevPageLabel' => 'Trước',
        'nextPageLabel' => 'Sau',
        'maxButtonCount' => 5,
    ]) ?>


</main>