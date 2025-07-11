<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\PropertyImages;

/** @var yii\web\View $this */
/** @var common\models\Properties $model */

$this->title = "Xem Dữ Liệu Nhà Đất [". $model->property_id . "]";
$this->params['breadcrumbs'][] = ['label' => 'Properties', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<header class="bg-white shadow-md p-2 flex items-center justify-between rounded-bl-lg">
    <div class="text-lg font-semibold text-gray-800">Dữ Liệu Nhà Đất</div>
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


<main class="flex-1 p-6 overflow-y-auto hide-scrollbar">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Left Column: Main Property Details -->
        <div id="thong-tin-content" class="tab-content lg:col-span-2 space-y-6">
            <!-- Basic Property Info -->
            <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Mã BĐS: <span class="font-semibold text-gray-800">49565</span></p>
                    <p class="text-sm text-gray-500">Ngày Nhập: <span class="font-semibold text-gray-800">5 năm 10 tháng Trước (30-08-2019)</span></p>
                </div>
                <div class="flex items-center space-x-2">
                    <img src="https://placehold.co/40x40/f0f0f0/555555?text=Logo" alt="Người Nhập Logo" class="w-10 h-10 rounded-full">
                    <div>
                        <p class="text-sm text-gray-500">Người Nhập:</p>
                        <p class="font-semibold text-gray-800">Toàn Cầu Admin <i class="fas fa-info-circle text-gray-400 text-xs"></i></p>
                    </div>
                </div>
            </div>

            <!-- "Bán" Section - Prominent Card -->
            <div class="bg-white p-6 rounded-lg shadow-md border-orange-600-custom">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-2">
                        <span class="text-lg font-bold text-orange-600">Bán</span>
                        <span class="px-2 py-1 bg-green-100 text-green-700 text-xs font-medium rounded-full">Đang Giao Dịch</span>
                    </div>
                    <img src="https://placehold.co/24x24/transparent/000000?text=🌍" alt="World Map Icon" class="w-6 h-6">
                </div>
                <p class="text-xl font-bold text-gray-800 mb-2">SỐ 25 Nguyễn Hữu Cầu, P. Tân Định, Quận 1</p>
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <p class="text-sm text-gray-500">Mức giá</p>
                        <p class="text-lg font-bold text-gray-800">100 Tỷ VNĐ</p>
                        <p class="text-xs text-gray-500">~ 1.25 Tỷ/m2</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Diện tích</p>
                        <p class="text-lg font-bold text-gray-800">80 m2</p>
                        <p class="text-xs text-gray-500">(4 x 20)</p>
                    </div>
                </div>
                <div class="flex items-center text-blue-600 font-medium">
                    <i class="fas fa-user mr-2"></i>
                    <span>Chủ Thông ••••••.968</span>
                    <span class="ml-2 px-2 py-1 bg-blue-100 text-blue-700 text-xs rounded-full">Chủ nhà</span>
                </div>
            </div>

            <!-- Tabs for Vị Trí Mặt Tiền / Loại Tài Sản Cá Nhân -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <nav class="flex space-x-4 mb-4">
                    <button class="tab-sub-button px-4 py-2 text-sm font-medium rounded-full bg-orange-100 text-orange-700" data-target="vi-tri-mat-tien">Vị Trí Mặt Tiền</button>
                    <button class="tab-sub-button px-4 py-2 text-sm font-medium rounded-full bg-gray-100 text-gray-700 hover:bg-gray-200" data-target="loai-tai-san-ca-nhan">Loại Tài Sản Cá Nhân</button>
                </nav>

                <!-- Content for Vị Trí Mặt Tiền -->
                <div id="vi-tri-mat-tien" class="tab-sub-content space-y-4">
                    <div class="flex items-start justify-between">
                        <p class="text-gray-700">Nhà có diện tích 4x20, khu trung tâm kinh doanh buôn bán ,tiện kinh doanh đa ngành nghề</p>
                        <button class="ml-4 text-gray-500 hover:text-gray-700 flex items-center text-sm">
                            <i class="far fa-copy mr-1"></i> Copy
                        </button>
                    </div>
                    <p class="text-gray-700">50 tỷ (4.00 x 20.00)</p>
                    <button class="px-4 py-2 bg-red-100 text-red-700 text-sm font-medium rounded-full hover:bg-red-200">Đánh dấu Hot</button>
                </div>

                <!-- Content for Loại Tài Sản Cá Nhân (initially hidden) -->
                <div id="loai-tai-san-ca-nhan" class="tab-sub-content hidden space-y-4">
                    <p class="text-gray-700">Thông tin chi tiết về loại tài sản cá nhân sẽ được hiển thị tại đây.</p>
                    <!-- Add more specific fields for personal asset type if needed -->
                </div>
            </div>
        </div>

        <!-- Right Column: Sidebar Details -->
        <div class="lg:col-span-1 space-y-6">
            <!-- User Info Card -->
            <div class="bg-white p-6 rounded-lg shadow-md space-y-4">
                <p class="text-sm text-gray-500">17 Phút Trước | Admin 3 | NV0186 | 0901.893.180</p>
                <button class="w-full py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 flex items-center justify-center space-x-2">
                    <i class="fas fa-address-book"></i>
                    <span>Thêm Thông Tin Liên Hệ</span>
                </button>
                <div class="flex items-center text-blue-600 font-medium">
                    <i class="fas fa-user mr-2"></i>
                    <span>Chủ Thông ••••••.968</span>
                    <span class="ml-2 px-2 py-1 bg-blue-100 text-blue-700 text-xs rounded-full">Chủ nhà</span>
                </div>
            </div>

            <!-- Loại Tài Sản Card -->
            <div class="bg-white p-6 rounded-lg shadow-md space-y-4">
                <p class="text-sm text-gray-500">Loại Tài Sản: <span class="font-semibold text-gray-800">Cá Nhân</span></p>
                <p class="text-sm text-gray-500">Đánh dấu: <span class="font-semibold text-green-700">Đang Giao Dịch</span></p>
                <p class="text-sm text-gray-500">Mức giá: <span class="font-bold text-gray-800">100 Tỷ VNĐ</span> <i class="fas fa-arrow-up text-green-500 ml-1"></i></p>
                <p class="text-sm text-gray-500">Giá trên m2: <span class="font-bold text-gray-800">1.25 - Tỷ VNĐ</span></p>
                <button class="px-4 py-2 bg-green-100 text-green-700 text-sm font-medium rounded-full hover:bg-green-200 flex items-center space-x-2">
                    <i class="fas fa-check-circle"></i>
                    <span>Xác minh bởi</span>
                    <span class="font-semibold">NV0186</span>
                </button>
            </div>

            <!-- Another similar section (TIN GÓC) -->
            <div class="bg-white p-6 rounded-lg shadow-md space-y-4">
                <p class="text-sm text-gray-500">5 năm 10 tháng Trước (30-08-2019) | Toàn Cầu Admin <i class="fas fa-info-circle text-gray-400 text-xs"></i></p>
                <div class="flex items-center space-x-2">
                    <span class="px-2 py-1 bg-red-100 text-red-700 text-xs font-medium rounded-full">TIN GÓC</span>
                    <span class="text-sm text-gray-600">được đăng đầu tiên</span>
                </div>
                <div class="flex items-start justify-between">
                    <p class="text-gray-700">Nhà có diện tích 4x20, khu trung tâm kinh doanh buôn bán ,tiện kinh doanh đa ngành nghề</p>
                    <button class="ml-4 text-gray-500 hover:text-gray-700 flex items-center text-sm">
                        <i class="far fa-copy mr-1"></i> Copy
                    </button>
                </div>
                <p class="text-gray-700">50 tỷ (4.00 x 20.00)</p>
                <button class="w-full py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 flex items-center justify-center space-x-2">
                    <i class="fas fa-address-book"></i>
                    <span>Thêm Thông Tin Liên Hệ</span>
                </button>
                <div class="flex items-center text-blue-600 font-medium">
                    <i class="fas fa-user mr-2"></i>
                    <span>CN ••••••.222</span>
                    <span class="ml-2 px-2 py-1 bg-blue-100 text-blue-700 text-xs rounded-full">Chủ nhà</span>
                </div>
                <nav class="flex space-x-4 mt-4">
                    <button class="tab-sub-button px-4 py-2 text-sm font-medium rounded-full bg-orange-100 text-orange-700" data-target="vi-tri-mat-tien-2">Vị Trí Mặt Tiền</button>
                    <button class="tab-sub-button px-4 py-2 text-sm font-medium rounded-full bg-gray-100 text-gray-700 hover:bg-gray-200" data-target="loai-tai-san-ca-nhan-2">Loại Tài Sản Cá Nhân</button>
                </nav>
                <p class="text-sm text-gray-500">Đánh dấu: <span class="font-semibold text-green-700">Đang Giao Dịch</span></p>
                <p class="text-sm text-gray-500">Set Loại sản phẩm: <span class="font-semibold text-gray-800">Bất động sản khác</span></p>
            </div>
        </div>
    </div>

    <!-- Lịch sử tương tác Content Section (Initially Hidden) -->
    <div id="lich-su-content" class="tab-content hidden bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Lịch sử tương tác</h2>
        <p class="text-gray-600">Nội dung lịch sử tương tác sẽ được hiển thị tại đây.</p>
        <!-- Add more content for interaction history if needed -->
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    const thongTinTab = document.getElementById('thong-tin-tab');
    const lichSuTab = document.getElementById('lich-su-tab');
    const thongTinContent = document.getElementById('thong-tin-content');
    const lichSuContent = document.getElementById('lich-su-content');

    const subTabButtons = document.querySelectorAll('.tab-sub-button');
    const subTabContents = document.querySelectorAll('.tab-sub-content');

    // Function to activate a main tab
    function activateMainTab(tabButton, contentDiv) {
        // Deactivate all main tabs and hide all main content
        document.querySelectorAll('.tab-content').forEach(content => content.classList.add('hidden'));
        document.querySelectorAll('header nav button').forEach(button => {
            button.classList.remove('text-orange-600', 'border-orange-600');
            button.classList.add('text-gray-600', 'hover:text-orange-600', 'hover:border-orange-600');
        });

        // Activate the selected main tab and show its content
        tabButton.classList.add('text-orange-600', 'border-b-2', 'border-orange-600');
        tabButton.classList.remove('text-gray-600', 'hover:text-orange-600', 'hover:border-orange-600');
        contentDiv.classList.remove('hidden');
    }

    // Function to activate a sub-tab
    function activateSubTab(tabButton) {
        // Hide all sub-tab contents within the same parent
        tabButton.closest('nav').nextElementSibling.querySelectorAll('.tab-sub-content').forEach(content => {
            content.classList.add('hidden');
        });

        // Deactivate all sub-tab buttons within the same parent
        tabButton.closest('nav').querySelectorAll('.tab-sub-button').forEach(button => {
            button.classList.remove('bg-orange-100', 'text-orange-700');
            button.classList.add('bg-gray-100', 'text-gray-700', 'hover:bg-gray-200');
        });

        // Activate the selected sub-tab button and show its content
        tabButton.classList.add('bg-orange-100', 'text-orange-700');
        tabButton.classList.remove('bg-gray-100', 'text-gray-700', 'hover:bg-gray-200');
        document.getElementById(tabButton.dataset.target).classList.remove('hidden');
    }

    // Event listeners for main tab clicks
    thongTinTab.addEventListener('click', function() {
        activateMainTab(thongTinTab, thongTinContent);
    });

    lichSuTab.addEventListener('click', function() {
        activateMainTab(lichSuTab, lichSuContent);
    });

    // Event listeners for sub-tab clicks
    subTabButtons.forEach(button => {
        button.addEventListener('click', function() {
            activateSubTab(this);
        });
    });

    // Initially activate the "Thông Tin" main tab
    activateMainTab(thongTinTab, thongTinContent);

    // Initially activate the first sub-tab in each section if any
    document.querySelectorAll('.tab-sub-button[data-target="vi-tri-mat-tien"]').forEach(button => {
        activateSubTab(button);
    });
    document.querySelectorAll('.tab-sub-button[data-target="vi-tri-mat-tien-2"]').forEach(button => {
        activateSubTab(button);
    });
});
</script>
