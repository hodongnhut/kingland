<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\OwnerContacts $model */

$this->title = $model->contact_id;
$this->params['breadcrumbs'][] = ['label' => 'Owner Contacts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="owner-contacts-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'contact_id' => $model->contact_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'contact_id' => $model->contact_id], [
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
            'contact_id',
            'property_id',
            'contact_name',
            'phone_number',
            'role_id',
            'gender_id',
        ],
    ]) ?>

</div>
