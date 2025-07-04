<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var common\models\Posts $model */

$this->title = $model->post_id;
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<header class="bg-white shadow-md p-2 flex items-center justify-between rounded-bl-lg">
    <div class="text-lg font-semibold text-gray-800">Xem Bản Tin Nội Bộ</div>
    <div class="relative flex items-center space-x-4">
        <button
            id="userMenuButton"
            class="w-10 h-10 bg-blue-500 hover:bg-blue-600 text-white rounded-full flex items-center justify-center shadow-md transition-colors duration-200"
            aria-haspopup="true"
            aria-expanded="false"
        >
            <i class="fas fa-user"></i>
        </button>
        <div
            id="userMenu"
            class="absolute right-0 mt-20 w-48 bg-white border border-gray-200 rounded-md shadow-lg py-1 z-10 hidden"
            role="menu"
            aria-orientation="vertical"
            aria-labelledby="userMenuButton"
        >
            <a href="<?= \yii\helpers\Url::to(['/login-version']) ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Phiên Đăng Nhập</a>
            <a href="<?= \yii\helpers\Url::to(['/change-password']) ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Đổi Mật Khẩu</a>
            <?= Html::a('Đăng Xuất', ['/site/logout'], [
                'data-method' => 'post',
                'class' => 'block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100',
                'role' => 'menuitem'
            ]) ?>
        </div>
    </div>
</header>
<main class="flex-1 p-6 overflow-auto">
    <div class="bg-white p-6 rounded-lg shadow-md mb-6">

    <p>
        <?= Html::a('Cập nhật', ['update', 'post_id' => $model->post_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Xóa', ['delete', 'post_id' => $model->post_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <br>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'post_id',
            [
                'attribute' => 'category_id',
                'value' => $model->category->category_name ?? 'N/A',
                'label' => 'Nhóm bản tin',
            ],
            'post_title',
            [
                'attribute' => 'post_content',
                'format' => 'raw',
                'value' => $model->post_content,
            ],
            'post_type',
            'post_date',
            'created_at',
            'updated_at',
            [
                'attribute' => 'is_active',
                'format' => 'boolean',
            ],
            [
                'label' => 'Tệp đính kèm',
                'format' => 'raw',
                'value' => function ($model) {
                    $attachmentsHtml = '';
                    if (!empty($model->attachments)) {
                        $attachmentsHtml .= '<ul>';
                        foreach ($model->attachments as $attachment) {
                            $attachmentsHtml .= '<li>'
                                . Html::a(
                                    '<i class="fas fa-file-alt mr-1"></i> ' . Html::encode($attachment->file_name) . ' (' . Yii::$app->formatter->asShortSize($attachment->file_size) . ')',
                                    Url::to($attachment->file_path),
                                    ['target' => '_blank']
                                )
                                . '</li>';
                        }
                        $attachmentsHtml .= '</ul>';
                    } else {
                        $attachmentsHtml = 'Không có tệp đính kèm.';
                    }
                    return $attachmentsHtml;
                },
            ],
        ],
    ]) ?>

</div>
</main>
