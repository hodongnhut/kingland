<?php

use common\models\Properties;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\PropertiesSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Properties';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="properties-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Properties', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo $this->render('_search', ['model' => $searchModel, 'listingTypes' => $modelListingTypes, 'locationTypes' => $modelLocationTypes, 'propertyTypes' => $modelPropertyTypes, 'assetTypes' => $modelAssetTypes, 'advantages' => $modelAdvantages, 'disadvantages' => $modelDisadvantages, 'directions' => $modelDirections]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
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


</div>
