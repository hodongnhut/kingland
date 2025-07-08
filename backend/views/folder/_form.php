<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Folders;
use yii\helpers\ArrayHelper;
$userFolders = Folders::find()
            ->select(['id', 'name_folder'])
            ->where(['create_by' => Yii::$app->user->id])
            ->asArray()
            ->all();
$userFoldersFormatted = ArrayHelper::map($userFolders, 'id', 'name_folder'); 
/** @var yii\web\View $this */
/** @var common\models\Folders $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="card-container">
    <div class="user-form bg-white p-6 mb-6 max-w-2xl mx-auto">

        <?php $form = ActiveForm::begin(
            [
                'fieldConfig' => [
                        'template' => "{label}\n{input}\n{hint}\n{error}",
                        'options' => ['class' => 'mb-3'],
                        'labelOptions' => ['class' => 'form-label'],
                        'inputOptions' => ['class' => 'form-control'],
                        'errorOptions' => ['class' => 'invalid-feedback d-block'], 
                        'hintOptions' => ['class' => 'form-text text-muted'],
                    ],
                ],
            ); ?>

        <?= $form->field($model, 'name_folder')->textInput(['maxlength' => true]) ?>


        <?= $form->field($model, 'parent_folder_id')->dropDownList(
            $userFoldersFormatted,
            ['prompt' => 'Chọn thư mục cha (tùy chọn)'] 
        ) ?>

        <?= $form->field($model, 'noted')->textarea(['rows' => 6]) ?>

        <div class="flex justify-end space-x-4 pt-4">
            <?= Html::submitButton('Lưu Lại', ['class' => 'bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded']) ?>
            <?= Html::a('Quay lại', Yii::$app->request->referrer ?: ['index'], ['class' => 'ml-4 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
