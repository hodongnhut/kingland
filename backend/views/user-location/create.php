<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\UserLocations $model */

$this->title = 'Create User Locations';
$this->params['breadcrumbs'][] = ['label' => 'User Locations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-locations-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
