<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Categories;
use yii\helpers\Url;
use dosamigos\ckeditor\CKEditor;

/** @var yii\web\View $this */
/** @var common\models\Posts $model */
/** @var yii\widgets\ActiveForm $form */
/** @var common\models\Attachments[] $attachments // Passed from controller for existing attachments */

$categories = \yii\helpers\ArrayHelper::map(Categories::find()->all(), 'category_id', 'category_name');
?>

<div class="card-container">
    <div class="user-form bg-white p-6 mb-6 max-w-2xl mx-auto">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

        <?= $form->field($model, 'post_title')->textInput(['maxlength' => true]) ?>

        <br>
        <?= $form->field($model, 'category_id')->dropDownList(
            ['' => 'Chọn Nhóm Bản Tin'] + (isset($categories) ? $categories : []),
        )->label('Chọn Nhóm Bản Tin') ?>
        <br>

        <?= $form->field($model, 'post_content')->widget(CKEditor::class, [
            'options' => ['rows' => 6],
            'preset' => 'custom',
                'clientOptions' => [
                'extraPlugins' => 'codesnippet',
                'codeSnippet_theme' => 'monokai_sublime',
                'toolbar' => [
                    ['name' => 'clipboard', 'items' => ['Cut', 'Copy', 'Paste', '-', 'Undo', 'Redo']],
                    ['name' => 'editing', 'items' => ['Find', 'Replace', '-', 'SelectAll']],
                    ['name' => 'insert', 'items' => ['Image', 'Table', 'HorizontalRule', 'SpecialChar', 'CodeSnippet']],
                    ['name' => 'basicstyles', 'items' => ['Bold', 'Italic', 'Underline', 'Strike', '-', 'RemoveFormat', 'CopyFormatting']],
                    ['name' => 'paragraph', 'items' => ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent']],
                    ['name' => 'links', 'items' => ['Link', 'Unlink']],
                    ['name' => 'styles', 'items' => ['Format']],
                    ['name' => 'tools', 'items' => ['Maximize']],
                ],
                'height' => 300,
            ]
        ]) ?>

        <?= $form->field($model, 'post_type')->dropDownList([
            'DOC' => 'DOC',
            'NEWS' => 'NEWS',
            'EVENT' => 'EVENT',
        ], ['prompt' => 'Chọn Loại Bài Viết']) ?>

        <br>
        <?= $form->field($model, 'post_date')->widget(\yii\jui\DatePicker::class, [
            'dateFormat' => 'yyyy-MM-dd', // Or 'dd-MM-yyyy' if preferred
            'options' => ['class' => 'form-control'],
            'clientOptions' => [
                'changeMonth' => true,
                'changeYear' => true,
                'showButtonPanel' => true,
                'yearRange' => '1900:2099', // Adjust as needed
            ],
        ]) ?>

        <br>
        <?= $form->field($model, 'is_active')->checkbox() // Changed to checkbox for boolean ?>

        <hr class="my-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-3">Tệp đính kèm</h3>

        <?= $form->field(new \common\models\Attachments(), 'file[]')->fileInput(['multiple' => true])->label('Upload Files') ?>
        <p class="text-sm text-gray-500 mt-1">Định dạng hỗ trợ: JPG, PNG, GIF, PDF, DOC, DOCX, XLS, XLSX (Tối đa 5MB/tệp, 10 tệp)</p>

        <?php if (!$model->isNewRecord && !empty($model->attachments)): // Display existing attachments for update ?>
            <div class="mt-4">
                <p class="text-md font-medium text-gray-700">Tệp đã đính kèm:</p>
                <ul class="list-disc list-inside">
                    <?php foreach ($model->attachments as $attachment): ?>
                        <li class="flex items-center justify-between py-1">
                            <a href="<?= Url::to($attachment->file_path) ?>" target="_blank" class="text-blue-600 hover:underline">
                                <i class="fas fa-file-alt mr-2"></i><?= Html::encode($attachment->file_name) ?> (<?= Yii::$app->formatter->asShortSize($attachment->file_size) ?>)
                            </a>
                            <?= Html::a('<i class="fas fa-times text-red-500 hover:text-red-700"></i>', ['attachments/delete', 'attachment_id' => $attachment->attachment_id], [
                                'title' => 'Xóa tệp đính kèm',
                                'data' => [
                                    'confirm' => 'Bạn có chắc chắn muốn xóa tệp này?',
                                    'method' => 'post',
                                ],
                            ]) ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>


        <div class="flex justify-end space-x-4 pt-4">
            <?= Html::submitButton('Lưu Lại', ['class' => 'bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded']) ?>
            <?= Html::a('Quay lại', Yii::$app->request->referrer ?: ['index'], ['class' => 'ml-4 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
