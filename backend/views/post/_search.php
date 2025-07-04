<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\PostSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="posts-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'post_id') ?>

    <?= $form->field($model, 'category_id') ?>

    <?= $form->field($model, 'post_title') ?>

    <?= $form->field($model, 'post_content') ?>

    <?= $form->field($model, 'post_type') ?>

    <?php // echo $form->field($model, 'post_date') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'is_active') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
