<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\OwnerContacts $model */

$this->title = 'Create Owner Contacts';
$this->params['breadcrumbs'][] = ['label' => 'Owner Contacts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="owner-contacts-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
