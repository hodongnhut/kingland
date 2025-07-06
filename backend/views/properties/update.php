<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Properties $model */

$this->title = 'Update Properties: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Properties', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'property_id' => $model->property_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="properties-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
