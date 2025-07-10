<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\OwnerContacts $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="owner-contacts-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'property_id')->textInput() ?>

    <?= $form->field($model, 'contact_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'role_id')->textInput() ?>

    <?= $form->field($model, 'gender_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
