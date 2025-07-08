<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Properties $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Properties', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="properties-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'property_id' => $model->property_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'property_id' => $model->property_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'property_id',
            'user_id',
            'title',
            'property_type_id',
            'selling_price',
            'has_vat_invoice',
            'house_number',
            'street_name',
            'ward_commune',
            'district_county',
            'city',
            'location_type_id',
            'compound_name',
            'area_width',
            'area_length',
            'area_total',
            'planned_width',
            'planned_length',
            'planned_construction_area',
            'usable_area',
            'direction',
            'land_type',
            'num_toilets',
            'num_bedrooms',
            'num_basements',
            'asset_type_id',
            'description:ntext',
            'has_deposit',
            'transaction_status_id',
            'transaction_description:ntext',
            'has_rental_contract',
            'is_active',
            'created_at',
            'updated_at',
            'external_id',
            'num_floors',
            'plot_number',
            'sheet_number',
            'lot_number',
            'commission_types_id',
            'commission_prices_id',
            'area_back_side',
            'wide_road',
            'planned_back_side',
            'property_images_id',
        ],
    ]) ?>

</div>
