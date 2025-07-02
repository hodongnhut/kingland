<?php
use yii\helpers\Html;
$this->title = "Danh sách thiết bị";
?>

<header class="bg-white shadow-md p-2 flex items-center justify-between rounded-bl-lg">
    <div class="text-lg font-semibold text-gray-800"> Danh sách thiết bị</div>
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

<!-- Content Body -->
<main class="flex-1 p-6 overflow-auto">
    <div class="bg-white p-6 rounded-lg shadow-md mb-6">
        <p class="text-sm text-gray-500 mb-2">Màn hình chính / Xem Danh sách thiết bị</p>
        <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-4 sm:mb-0">Danh sách thiết bị</h2>
        </div>

        <!-- Device List Table -->
        <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-sm">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Thiết bị</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phương thức</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hoạt động gần nhất</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Thao tác gần nhất</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Đăng nhập lần đầu</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phiên hiện tại</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">TK Đăng nhập bằng</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Đăng xuất</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <!-- Sample Device Row 1 (Thiết bị hiện tại) -->
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">1</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <div class="font-semibold">Máy Tính</div>
                            <div class="text-xs text-gray-600">Linux</div>
                            <div class="text-xs text-gray-600">2163E44F9B82C3</div>
                            <div class="text-blue-600 text-xs font-semibold mt-1">Thiết bị hiện tại</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Chrome</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Vừa xong</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Đăng Nhập</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <div class="text-gray-900">1 ngày trước</div>
                            <div class="text-xs text-gray-600">(30-06) Lúc: 14:12</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Tìm</span>
                            <div class="text-xs text-gray-600 mt-1">KH012</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Tìm</span>
                            <div class="text-xs text-gray-600 mt-1">KH012</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <button class="text-red-600 hover:text-red-800" title="Đăng xuất">
                                <i class="fas fa-sign-out-alt text-lg"></i>
                            </button>
                        </td>
                    </tr>
                    <!-- Sample Device Row 2 (Another device) -->
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">2</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <div class="font-semibold">Điện thoại</div>
                            <div class="text-xs text-gray-600">Android</div>
                            <div class="text-xs text-gray-600">ABC123XYZ456</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Firefox</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">1 giờ trước</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Xem</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <div class="text-gray-900">5 ngày trước</div>
                            <div class="text-xs text-gray-600">(25-06) Lúc: 10:00</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Tìm</span>
                            <div class="text-xs text-gray-600 mt-1">KH012</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Tìm</span>
                            <div class="text-xs text-gray-600 mt-1">KH012</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <button class="text-red-600 hover:text-red-800" title="Đăng xuất">
                                <i class="fas fa-sign-out-alt text-lg"></i>
                            </button>
                        </td>
                    </tr>
                    <!-- Add more device rows as needed -->
                </tbody>
            </table>
        </div>
    </div>
</main>