<?php

/** @var yii\web\View $this */
use yii\helpers\Html;
$this->title = 'King Land Group';
?>
<!-- Top Header / Navbar -->
<header class="bg-white shadow-md p-2 flex items-center justify-between rounded-bl-lg">
    <div class="text-lg font-semibold text-gray-800">Xem Dữ Liệu Nhà Đất</div>
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
            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Phiên Đăng Nhập</a>
            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Đổi Mật Khẩu</a>
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
                <button class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-md shadow-md flex items-center transition-colors duration-200">
                    <i class="fas fa-plus mr-2"></i> TẠO MỚI
                </button>
                <button class="bg-gray-400 hover:bg-gray-500 text-white px-5 py-2 rounded-md shadow-md flex items-center transition-colors duration-200">
                    <i class="fas fa-trash-alt mr-2"></i> THÙNG RÁC (0)
                </button>
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

        <!-- File List Table -->
        <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-sm">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tên Tệp</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ghi Chú</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <!-- Sample File Row -->
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">1</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">NhaDat</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"></td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button class="text-blue-600 hover:text-blue-800 mr-3" title="Xem">
                                <i class="fas fa-eye text-lg"></i>
                            </button>
                            <button class="text-green-600 hover:text-green-800 mr-3" title="Chỉnh sửa">
                                <i class="fas fa-edit text-lg"></i>
                            </button>
                            <button class="text-red-600 hover:text-red-800" title="Xóa">
                                <i class="fas fa-trash-alt text-lg"></i>
                            </button>
                        </td>
                    </tr>
                    <!-- Add more file rows as needed -->
                </tbody>
            </table>
        </div>
    </div>
</main>