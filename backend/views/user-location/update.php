<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\UserLocations $model */

$this->title = 'Update User Locations: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'User Locations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-locations-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
