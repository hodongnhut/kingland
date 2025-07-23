<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Properties $model */

$this->title = 'Dữ Liệu Nhà Đất: [ Mã: ' . $model->property_id .']';
?>

<?= $this->render('_form', [
    'model' => $model,
    'modelProvinces' => $modelProvinces,
    'modelDistricts' => $modelDistricts,
    'modelPropertyTypes' => $modelPropertyTypes,
    'rentalContractModel' => $rentalContractModel,
    'dataProvider' => $dataProvider,
]) ?>

