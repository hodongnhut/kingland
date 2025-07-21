<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView; // Nếu bạn muốn dùng GridView
use yii\widgets\ListView; // Hoặc ListView cho hiển thị linh hoạt hơn
use yii\data\ActiveDataProvider; // Đảm bảo đã import

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Tài sản yêu thích của tôi';
$this->params['breadcrumbs'][] = $this->title;
?>
<header class="bg-white shadow-md p-2 flex items-center justify-between rounded-bl-lg">
    <div class="text-lg font-semibold text-gray-800">
        <div class="flex space-x-2">
            <a href="<?= Url::to(['/property']) ?>" class="px-4 py-2 rounded-lg bg-white text-blue-600 shadow-md flex items-center space-x-1.5 text-sm">
                <i class="fas fa-database fa-sm"></i>
                <span>Dữ Liệu Nhà Đất</span>
            </a>
            <a href="<?= Url::to(['/property/my-favorites']) ?>" class="px-4 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 transition-colors duration-200 flex items-center space-x-1.5 text-sm">
                <i class="fas fa-heart fa-sm"></i>
                <span>BĐS Đã Lưu</span>
            </a>
        </div>
    </div>
    <div class="relative flex items-center space-x-4">
        <div class="flex space-x-2">
            <button id="openDialog" class="px-3 py-1.5 rounded-lg bg-red-600 hover:bg-red-700 text-white shadow-md flex items-center space-x-1.5 text-sm transition-colors duration-200">
                <i class="fas fa-plus fa-sm mr-1"></i>
                <span>TẠO MỚI</span>
            </button>
        </div>
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
            <a href="<?= Url::to(['/login-version']) ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Phiên Đăng Nhập</a>
            <a href="<?= Url::to(['/change-password']) ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Đổi Mật Khẩu</a>
            <?= Html::a('Đăng Xuất', ['/site/logout'], [
                'data-method' => 'post',
                'class' => 'block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100',
                'role' => 'menuitem'
            ]) ?>
        </div>
    </div>
</header>
<main class="flex-1 p-6 overflow-auto">
    <div class="my-favorites-index">
        <?php
        echo ListView::widget([
            'dataProvider' => $dataProvider,
            'layout' => "{items}\n{summary}",
            'itemView' => '_favorite_item',
            'summary' => 'Hiển thị {begin}-{end} trên tổng số {totalCount} tài sản yêu thích.',
            'emptyText' => 'Bạn chưa có tài sản yêu thích nào.',
            'options' => [
                'class' => 'list-view',
            ],
            'itemOptions' => [
                'class' => 'item',
            ],
        ]);
        ?>
    </div>
</main>
