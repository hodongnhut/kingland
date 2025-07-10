<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Properties $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="properties-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'property_type_id')->textInput() ?>

    <?= $form->field($model, 'listing_types_id')->textInput() ?>

    <?= $form->field($model, 'price_unit')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'currency_id')->textInput() ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'has_vat_invoice')->textInput() ?>

    <?= $form->field($model, 'house_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'street_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ward_commune')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'district_county')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'location_type_id')->textInput() ?>

    <?= $form->field($model, 'compound_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'area_width')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'area_length')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'area_total')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'planned_width')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'planned_length')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'planned_construction_area')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'usable_area')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'direction_id')->textInput() ?>

    <?= $form->field($model, 'land_type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'num_toilets')->textInput() ?>

    <?= $form->field($model, 'num_bedrooms')->textInput() ?>

    <?= $form->field($model, 'num_basements')->textInput() ?>

    <?= $form->field($model, 'asset_type_id')->textInput() ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'has_deposit')->textInput() ?>

    <?= $form->field($model, 'transaction_status_id')->textInput() ?>

    <?= $form->field($model, 'transaction_description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'has_rental_contract')->textInput() ?>

    <?= $form->field($model, 'is_active')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'external_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'num_floors')->textInput() ?>

    <?= $form->field($model, 'plot_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sheet_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lot_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'commission_types_id')->textInput() ?>

    <?= $form->field($model, 'commission_prices_id')->textInput() ?>

    <?= $form->field($model, 'area_back_side')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'wide_road')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'planned_back_side')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'property_images_id')->textInput() ?>

    <?= $form->field($model, 'region')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
