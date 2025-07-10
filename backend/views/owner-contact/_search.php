<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\OwnerContactSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="owner-contacts-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'contact_id') ?>

    <?= $form->field($model, 'property_id') ?>

    <?= $form->field($model, 'contact_name') ?>

    <?= $form->field($model, 'phone_number') ?>

    <?= $form->field($model, 'role_id') ?>

    <?php // echo $form->field($model, 'gender_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
