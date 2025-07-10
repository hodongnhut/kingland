<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\OwnerContacts $model */

$this->title = 'Update Owner Contacts: ' . $model->contact_id;
$this->params['breadcrumbs'][] = ['label' => 'Owner Contacts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->contact_id, 'url' => ['view', 'contact_id' => $model->contact_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="owner-contacts-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
