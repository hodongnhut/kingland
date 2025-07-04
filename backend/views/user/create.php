<?php

use yii\helpers\Html;
use common\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
/** @var yii\web\View $this */
/** @var common\models\User $model */

$this->title = 'Create User';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
