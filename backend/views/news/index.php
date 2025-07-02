<?php
use Yii;
use yii\helpers\Html;
$this->title = "Xem Bản Tin Nội Bộ";
?>
<!-- Header -->
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
        <p class="text-sm text-gray-500 mb-2">Màn hình chính / Xem Bản Tin Nội Bộ</p>
        <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-4 sm:mb-0">Nhóm Bản Tin</h2>
            <button
                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-md shadow-md flex items-center transition-colors duration-200">
                <i class="fas fa-plus mr-2"></i> Tạo Bài Viết Mới
            </button>
        </div>


        <!-- Search and Filter Section -->
        <div class="flex flex-col md:flex-row gap-4 mb-8 items-center">
            <div class="relative w-full md:w-auto flex-grow">
                <select
                    class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option>Chọn Nhóm Bản Tin</option>
                    <option>Thông báo</option>
                    <option>Tin tức nội bộ</option>
                    <option>Sự kiện</option>
                </select>
                <div
                    class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                    <i class="fas fa-chevron-down text-sm"></i>
                </div>
            </div>
            <input type="text" placeholder="Tên Bài Viết"
                class="flex-1 w-full md:w-auto px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            <button
                class="w-full md:w-auto bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-md shadow-md flex items-center justify-center transition-colors duration-200">
                <i class="fas fa-search mr-2"></i> TÌM KIẾM
            </button>
        </div>

        <!-- News Article List -->
        <div class="space-y-4">
            <!-- Sample News Article 1 (Highlight for example) -->
            <div
                class="bg-blue-50 rounded-lg p-4 flex flex-col sm:flex-row items-start sm:items-center space-y-3 sm:space-y-0 sm:space-x-4 shadow-sm">
                <div class="flex-shrink-0">
                    <img src="https://placehold.co/80x80/E0F2FE/004085?text=DOC" alt="Document icon"
                        class="rounded-md">
                </div>
                <div class="flex-grow">
                    <div class="text-sm text-gray-500 mb-1 flex items-center">
                        <i class="fas fa-calendar-alt mr-2"></i> 02-04-2024
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800">THÔNG BÁO THAY ĐỔI THỜI GIAN LÀM VIỆC</h3>
                </div>
                <div class="flex-shrink-0 flex space-x-3 mt-3 sm:mt-0">
                    <button class="text-blue-600 hover:text-blue-800" title="Chỉnh sửa">
                        <i class="fas fa-edit text-lg"></i>
                    </button>
                    <button class="text-red-600 hover:text-red-800" title="Xóa">
                        <i class="fas fa-trash-alt text-lg"></i>
                    </button>
                    <!-- View button is implied by clicking the article, but can be explicit -->
                    <button class="text-gray-600 hover:text-gray-800" title="Xem chi tiết">
                        <i class="fas fa-eye text-lg"></i>
                    </button>
                </div>
            </div>
            <!-- Sample News Article 2 -->
            <div
                class="bg-white rounded-lg p-4 flex flex-col sm:flex-row items-start sm:items-center space-y-3 sm:space-y-0 sm:space-x-4 shadow-md">
                <div class="flex-shrink-0">
                    <img src="https://placehold.co/80x80/F0F0F0/888888?text=NEWS" alt="News icon"
                        class="rounded-md">
                </div>
                <div class="flex-grow">
                    <div class="text-sm text-gray-500 mb-1 flex items-center">
                        <i class="fas fa-calendar-alt mr-2"></i> 28-03-2024
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800">CẬP NHẬT CHÍNH SÁCH HOA HỒNG MỚI NĂM 2024
                    </h3>
                </div>
                <div class="flex-shrink-0 flex space-x-3 mt-3 sm:mt-0">
                    <button class="text-blue-600 hover:text-blue-800" title="Chỉnh sửa">
                        <i class="fas fa-edit text-lg"></i>
                    </button>
                    <button class="text-red-600 hover:text-red-800" title="Xóa">
                        <i class="fas fa-trash-alt text-lg"></i>
                    </button>
                    <button class="text-gray-600 hover:text-gray-800" title="Xem chi tiết">
                        <i class="fas fa-eye text-lg"></i>
                    </button>
                </div>
            </div>
            <!-- Sample News Article 3 -->
            <div
                class="bg-white rounded-lg p-4 flex flex-col sm:flex-row items-start sm:items-center space-y-3 sm:space-y-0 sm:space-x-4 shadow-md">
                <div class="flex-shrink-0">
                    <img src="https://placehold.co/80x80/F0F0F0/888888?text=EVENT" alt="Event icon"
                        class="rounded-md">
                </div>
                <div class="flex-grow">
                    <div class="text-sm text-gray-500 mb-1 flex items-center">
                        <i class="fas fa-calendar-alt mr-2"></i> 15-03-2024
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800">THÔNG BÁO TỔ CHỨC TIỆC TẤT NIÊN CÔNG TY</h3>
                </div>
                <div class="flex-shrink-0 flex space-x-3 mt-3 sm:mt-0">
                    <button class="text-blue-600 hover:text-blue-800" title="Chỉnh sửa">
                        <i class="fas fa-edit text-lg"></i>
                    </button>
                    <button class="text-red-600 hover:text-red-800" title="Xóa">
                        <i class="fas fa-trash-alt text-lg"></i>
                    </button>
                    <button class="text-gray-600 hover:text-gray-800" title="Xem chi tiết">
                        <i class="fas fa-eye text-lg"></i>
                    </button>
                </div>
            </div>
            <!-- Add more news articles as needed -->
        </div>
    </div>
</main>