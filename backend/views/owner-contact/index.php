<?php

use common\models\OwnerContacts;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\OwnerContactSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Owner Contacts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="owner-contacts-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Owner Contacts', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'contact_id',
            'property_id',
            'contact_name',
            'phone_number',
            'role_id',
            //'gender_id',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, OwnerContacts $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'contact_id' => $model->contact_id]);
                 }
            ],
        ],
    ]); ?>


</div>
