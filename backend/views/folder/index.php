<?php

use common\models\Folders;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\FolderSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Folders';
$this->params['breadcrumbs'][] = $this->title;
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
        <p class="text-sm text-gray-500 mb-2">Màn hình chính / Xem Quản Lý Tệp</p>
        <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-4 sm:mb-0">Quản Lý Tệp</h2>
            <div class="flex space-x-3">
                <a href="<?= \yii\helpers\Url::to(['folder/create']) ?>" class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-md shadow-md flex items-center transition-colors duration-200">
                    <i class="fas fa-plus mr-2"></i> TẠO MỚI
                 </a>
            </div>
        </div>

        <!-- Tabs -->
        <div class="flex space-x-2 mb-6 border-b border-gray-200">
            <a href="<?= \yii\helpers\Url::to(['/property']) ?>" class="px-6 py-3 rounded-t-lg bg-gray-200 text-gray-700 hover:bg-gray-300 transition-colors duration-200 flex items-center space-x-2">
                <i class="fas fa-database"></i>
                <span>Dữ Liệu Nhà Đất</span>
            </a>
            <a href="#" class="px-6 py-3 rounded-t-lg bg-white text-blue-600 shadow-md flex items-center space-x-2 border-t border-l border-r border-gray-200 -mb-px">
                <i class="fas fa-folder"></i>
                <span>Quản Lý Tệp</span>
            </a>
        </div>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'layout' => "{items}\n{summary}",
            'summaryOptions' =>
            [
                'id' => 'DataTables_Table_0_info'
            ],
            'summary' => 'Hiển thị từ {begin} đến {end} trong tổng số {totalCount} mục',
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'name_folder',
                [
                    'attribute' => 'parentFolderName',
                    'label' => 'Thư mục cha', // Custom label for the column
                    'value' => function ($model) {
                        return $model->parentFolder->name_folder ?? '--- Thư mục gốc ---';
                    },
                ],
                'noted:ntext',
                'created_at',
                //'updated_at',
                //'create_by',
                [
                    'class' => ActionColumn::className(),
                    'urlCreator' => function ($action, Folders $model, $key, $index, $column) {
                        return Url::toRoute([$action, 'id' => $model->id]);
                    }
                ],
            ],
        ]); ?>


    </div>
</main>
