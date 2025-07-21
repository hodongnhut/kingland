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
                <span>BĐS Yêu Thích</span>
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
<div class="my-favorites-index p-4">

<h1 class="text-2xl font-bold mb-6 text-gray-800"><?= Html::encode($this->title) ?></h1>

<div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SỐ NHÀ</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ĐƯỜNG PHỐ</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">QUẬN/HUYỆN</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">GIÁ</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">DIỆN TÍCH</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">KẾT CẤU</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">HĐ THUÊ</th>
                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">LƯU</th>
                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">XEM THÊM</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            <?= ListView::widget([
                'dataProvider' => $dataProvider,
                'itemView' => '_favorite_item', // File view từng mục yêu thích
                'summary' => false, // Ẩn tóm tắt để bảng gọn gàng hơn
                'emptyText' => '<tr><td colspan="10" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">Bạn chưa có tài sản yêu thích nào.</td></tr>',
                'options' => [
                    'tag' => false, // Không bọc ListView trong một thẻ div phụ
                ],
                'itemOptions' => [
                    'tag' => false, // _favorite_item.php sẽ render thẻ <tr>
                ],
                'layout' => "{items}\n{pager}", // Chỉ hiển thị các mục và phân trang
            ]);
            ?>
        </tbody>
    </table>
</div>

</div>
</main>
