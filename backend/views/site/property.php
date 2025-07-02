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
    <!-- Tabs -->
    <div class="flex space-x-2 mb-6">
        <a href="<?= \yii\helpers\Url::to(['/property']) ?>" class="px-6 py-3 rounded-lg bg-white text-blue-600 shadow-md flex items-center space-x-2">
            <i class="fas fa-database"></i>
            <span>Dữ Liệu Nhà Đất</span>
        </a>
        <a href="<?= \yii\helpers\Url::to(['/property-folder']) ?>" 
            class="px-6 py-3 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 transition-colors duration-200 flex items-center space-x-2">
            <i class="fas fa-file-alt"></i>
            <span>Quản Lý Tệp</span>
        </a>
    </div>

    <!-- Filter Section -->
    <div class="bg-white p-6 rounded-lg shadow-md mb-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-4 mb-4">
            <!-- Row 1 Filters -->
            <select
                class="form-select border border-gray-300 rounded-lg p-2 focus:ring-blue-500 focus:border-blue-500">
                <option>Chọn Vị Trí</option>
            </select>
            <select
                class="form-select border border-gray-300 rounded-lg p-2 focus:ring-blue-500 focus:border-blue-500">
                <option>Chọn Loại Sản Phẩm</option>
            </select>
            <select
                class="form-select border border-gray-300 rounded-lg p-2 focus:ring-blue-500 focus:border-blue-500">
                <option>Chọn Giao Dịch</option>
            </select>
            <input type="text" placeholder="Số Thửa"
                class="form-input border border-gray-300 rounded-lg p-2 focus:ring-blue-500 focus:border-blue-500">
            <input type="text" placeholder="Số Tờ"
                class="form-input border border-gray-300 rounded-lg p-2 focus:ring-blue-500 focus:border-blue-500">
            <input type="text" placeholder="Hồ Chí Minh"
                class="form-input border border-gray-300 rounded-lg p-2 focus:ring-blue-500 focus:border-blue-500">

            <!-- Row 2 Filters -->
            <select
                class="form-select border border-gray-300 rounded-lg p-2 focus:ring-blue-500 focus:border-blue-500">
                <option>Chọn Quận/Huyện</option>
            </select>
            <select
                class="form-select border border-gray-300 rounded-lg p-2 focus:ring-blue-500 focus:border-blue-500">
                <option>Chọn Phường/Xã</option>
            </select>
            <select
                class="form-select border border-gray-300 rounded-lg p-2 focus:ring-blue-500 focus:border-blue-500">
                <option>Chọn Đường Phố</option>
            </select>
            <div class="flex items-center space-x-2">
                <input type="text" placeholder="Giá từ"
                    class="form-input border border-gray-300 rounded-lg p-2 w-1/2 focus:ring-blue-500 focus:border-blue-500">
                <span>đến</span>
                <input type="text" placeholder="Giá đến"
                    class="form-input border border-gray-300 rounded-lg p-2 w-1/2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="flex items-center space-x-2">
                <input type="text" placeholder="Diện Tích từ"
                    class="form-input border border-gray-300 rounded-lg p-2 w-1/2 focus:ring-blue-500 focus:border-blue-500">
                <span>đến</span>
                <input type="text" placeholder="Diện Tích đến"
                    class="form-input border border-gray-300 rounded-lg p-2 w-1/2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="flex space-x-2">
                <button
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow-md flex items-center justify-center transition-colors duration-200">
                    <i class="fas fa-search mr-2"></i> TÌM
                </button>
                <button
                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg shadow-md flex items-center justify-center transition-colors duration-200">
                    <i class="fas fa-sync-alt"></i>
                </button>
            </div>
        </div>

        <!-- Status Buttons -->
        <div class="flex flex-wrap items-center gap-2 mb-4">
            <button
                class="flex items-center bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-medium">
                <i class="fas fa-tag mr-1 text-blue-500"></i>
                Tài Sản Đầu Giá
            </button>
            <button
                class="flex items-center bg-gray-200 text-gray-700 px-3 py-1 rounded-full text-sm font-medium">
                <i class="fas fa-star mr-1 text-yellow-500"></i>
                Sản Phẩm Mới
            </button>
            <button
                class="flex items-center bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-medium">
                <i class="fas fa-handshake mr-1 text-green-500"></i>
                Đang Giao Dịch
            </button>
            <button
                class="flex items-center bg-orange-100 text-orange-700 px-3 py-1 rounded-full text-sm font-medium">
                <i class="fas fa-comments mr-1 text-orange-500"></i>
                Ngừng Giao Dịch
            </button>
            <button
                class="flex items-center bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-sm font-medium">
                <i class="fas fa-money-check-alt mr-1 text-purple-500"></i>
                Đã Đặt Cọc
            </button>
            <button
                class="flex items-center bg-pink-100 text-pink-700 px-3 py-1 rounded-full text-sm font-medium">
                <i class="fas fa-file-invoice mr-1 text-pink-500"></i>
                Có HĐ Thuê
            </button>
            <button
                class="flex items-center bg-teal-100 text-teal-700 px-3 py-1 rounded-full text-sm font-medium">
                <i class="fas fa-search-location mr-1 text-teal-500"></i>
                Động Tư Trạch
            </button>
            <button
                class="flex items-center bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full text-sm font-medium">
                <i class="fas fa-exchange-alt mr-1 text-indigo-500"></i>
                Tẩy Trạch
            </button>
            <button
                class="flex items-center bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm font-medium">
                <i class="fas fa-arrow-alt-circle-up mr-1 text-red-500"></i>
                Tăng giá
            </button>
            <button
                class="flex items-center bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm font-medium">
                <i class="fas fa-arrow-alt-circle-down mr-1 text-gray-500"></i>
                Giảm giá
            </button>
        </div>

        <div class="flex items-center gap-2 text-sm text-gray-500">
            <i class="fas fa-exclamation-triangle text-orange-500"></i>
            <span>Đã Xem Hôm Nay</span>
        </div>
    </div>

    <!-- Data Table -->
    <div class="bg-white p-6 rounded-lg shadow-md overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Số Nhà</th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Đường Phố</th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Phường/Xã</th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Quận/Huyện</th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Giá</th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Diện Tích</th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Kết Cấu</th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        HĐ Thuê</th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Lưu</th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Cập nhật</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <!-- Sample Row 1 -->
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        <div class="flex items-center space-x-2">
                            <span>1</span>
                            <input type="checkbox" class="form-checkbox h-4 w-4 text-blue-600 rounded">
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold">BÁN</div>
                        <div class="text-xs text-gray-600">Nhà phố</div>
                        <div>291A</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold">Võ Văn Tần</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">P.3</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Q.3</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold text-red-600">69 Tỷ VNĐ</div>
                        <div class="text-xs text-gray-600">-238 Triệu/m2</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold">290 m2</div>
                        <div class="text-xs text-gray-600">(7.4m × 20m)</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <i class="far fa-heart text-gray-400"></i>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <span
                            class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Đang
                            Giao Dịch</span>
                        <div class="text-xs text-gray-500 mt-1">Hôm Qua lúc 11 giờ 30</div>
                        <button class="mt-2 text-blue-600 hover:text-blue-800 text-xs flex items-center">
                            <i class="fas fa-pencil-alt mr-1"></i>
                            Sản Phẩm Mới
                        </button>
                    </td>
                </tr>
                <!-- Sample Row 2 -->
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        <div class="flex items-center space-x-2">
                            <span>2</span>
                            <input type="checkbox" class="form-checkbox h-4 w-4 text-blue-600 rounded">
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold">BÁN</div>
                        <div class="text-xs text-gray-600">Nhà phố</div>
                        <div>225/17</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold">Đường nội bộ</div>
                        <div>Lê Văn Sỹ</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">P.1</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Tân Bình</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold text-red-600">28 Tỷ VNĐ</div>
                        <div class="text-xs text-gray-600">-233 Triệu/m2</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold">120 m2</div>
                        <div class="text-xs text-gray-600">(7.0m × 20m)</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <i class="far fa-heart text-gray-400"></i>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <span
                            class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Đang
                            Giao Dịch</span>
                        <div class="text-xs text-gray-500 mt-1">Hôm Qua lúc 11 giờ 30</div>
                        <button class="mt-2 text-blue-600 hover:text-blue-800 text-xs flex items-center">
                            <i class="fas fa-pencil-alt mr-1"></i>
                            Sản Phẩm Mới
                        </button>
                    </td>
                </tr>
                <!-- Sample Row 3 -->
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        <div class="flex items-center space-x-2">
                            <span>3</span>
                            <input type="checkbox" class="form-checkbox h-4 w-4 text-blue-600 rounded">
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold">BÁN</div>
                        <div class="text-xs text-gray-600">Nhà phố</div>
                        <div>185A</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold">Hà Huy Giáp</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Thạnh Lộc</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Q.12</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold text-red-600">16.5 Tỷ VNĐ</div>
                        <div class="text-xs text-gray-600">-330 Triệu/m2</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold">50 m2</div>
                        <div class="text-xs text-gray-600">(5.5m × 9.5m)</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <i class="far fa-heart text-gray-400"></i>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <span
                            class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Đang
                            Giao Dịch</span>
                        <div class="text-xs text-gray-500 mt-1">Hôm Qua lúc 06 giờ 27</div>
                    </td>
                </tr>
                <!-- Sample Row 4 -->
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        <div class="flex items-center space-x-2">
                            <span>4</span>
                            <input type="checkbox" class="form-checkbox h-4 w-4 text-blue-600 rounded">
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold">BÁN</div>
                        <div class="text-xs text-gray-600">Biệt thự</div>
                        <div>108/107</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold">Đoàn Thị Điểm</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">An Khạnh</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Thủ Đức</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold text-red-600">65 Tỷ VNĐ</div>
                        <div class="text-xs text-gray-600">-250 Triệu/m2</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold">260 m2</div>
                        <div class="text-xs text-gray-600">(10m × 25m)</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <i class="far fa-heart text-gray-400"></i>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <span
                            class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Đang
                            Giao Dịch</span>
                        <div class="text-xs text-gray-500 mt-1">Hôm Qua lúc 09 giờ 15</div>
                    </td>
                </tr>
                <!-- Sample Row 5 -->
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        <div class="flex items-center space-x-2">
                            <span>5</span>
                            <input type="checkbox" class="form-checkbox h-4 w-4 text-blue-600 rounded">
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold">BÁN</div>
                        <div class="text-xs text-gray-600">Đất</div>
                        <div>234/15</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold">Trần Duy Hưng</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Phú Nhuận</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold text-red-600">31 Tỷ VNĐ</div>
                        <div class="text-xs text-gray-600">-150 Triệu/m2</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold">200 m2</div>
                        <div class="text-xs text-gray-600">(8.0m × 25m)</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <i class="far fa-heart text-gray-400"></i>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <span
                            class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Ngừng
                            Giao Dịch</span>
                        <div class="text-xs text-gray-500 mt-1">Hôm Qua lúc 08 giờ 45</div>
                    </td>
                </tr>
                <!-- Sample Row 6 -->
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        <div class="flex items-center space-x-2">
                            <span>6</span>
                            <input type="checkbox" class="form-checkbox h-4 w-4 text-blue-600 rounded">
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold">BÁN</div>
                        <div class="text-xs text-gray-600">Nhà phố</div>
                        <div>173 Nguyễn Thị Minh Khai</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold">Nguyễn Thị Minh Khai</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Phú Nhuận</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Q.1</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold text-red-600">65 Tỷ VNĐ</div>
                        <div class="text-xs text-gray-600">-450 Triệu/m2</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold">150 m2</div>
                        <div class="text-xs text-gray-600">(5.0m × 30m)</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <i class="far fa-heart text-gray-400"></i>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <span
                            class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Đang
                            Giao Dịch</span>
                        <div class="text-xs text-gray-500 mt-1">Hôm Qua lúc 07 giờ 00</div>
                    </td>
                </tr>
                <!-- Sample Row 7 -->
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        <div class="flex items-center space-x-2">
                            <span>7</span>
                            <input type="checkbox" class="form-checkbox h-4 w-4 text-blue-600 rounded">
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold">BÁN</div>
                        <div class="text-xs text-gray-600">Chung cư</div>
                        <div>216 Trường Chinh</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold">Trường Chinh</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Tân Phú</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold text-red-600">43 Tỷ VNĐ</div>
                        <div class="text-xs text-gray-600">-180 Triệu/m2</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold">240 m2</div>
                        <div class="text-xs text-gray-600">(10m × 18m)</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <i class="far fa-heart text-gray-400"></i>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <span
                            class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Đang
                            Giao Dịch</span>
                        <div class="text-xs text-gray-500 mt-1">Hôm Qua lúc 05 giờ 30</div>
                    </td>
                </tr>
                <!-- Sample Row 8 -->
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        <div class="flex items-center space-x-2">
                            <span>8</span>
                            <input type="checkbox" class="form-checkbox h-4 w-4 text-blue-600 rounded">
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold">BÁN</div>
                        <div class="text-xs text-gray-600">Đất</div>
                        <div>99 Hậu Giang</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold">Hậu Giang</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Quận 6</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold text-red-600">51 Tỷ VNĐ</div>
                        <div class="text-xs text-gray-600">-190 Triệu/m2</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold">270 m2</div>
                        <div class="text-xs text-gray-600">(9m × 30m)</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <i class="far fa-heart text-gray-400"></i>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <span
                            class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Đang
                            Giao Dịch</span>
                        <div class="text-xs text-gray-500 mt-1">Hôm Qua lúc 04 giờ 00</div>
                    </td>
                </tr>
                <!-- Sample Row 9 -->
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        <div class="flex items-center space-x-2">
                            <span>9</span>
                            <input type="checkbox" class="form-checkbox h-4 w-4 text-blue-600 rounded">
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold">BÁN</div>
                        <div class="text-xs text-gray-600">Biệt thự</div>
                        <div>88 Nguyễn Văn Linh</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold">Nguyễn Văn Linh</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Tân Thuận</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Quận 7</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold text-red-600">120 Tỷ VNĐ</div>
                        <div class="text-xs text-gray-600">-300 Triệu/m2</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold">400 m2</div>
                        <div class="text-xs text-gray-600">(12m × 30m)</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <i class="far fa-heart text-gray-400"></i>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <span
                            class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Đang
                            Giao Dịch</span>
                        <div class="text-xs text-gray-500 mt-1">Hôm Qua lúc 03 giờ 00</div>
                    </td>
                </tr>
                <!-- Sample Row 10 -->
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        <div class="flex items-center space-x-2">
                            <span>10</span>
                            <input type="checkbox" class="form-checkbox h-4 w-4 text-blue-600 rounded">
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold">BÁN</div>
                        <div class="text-xs text-gray-600">Đất</div>
                        <div>21A Nguyễn Thái Sơn</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold">Nguyễn Thái Sơn</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Gò Vấp</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Tân Bình</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold text-red-600">115 Tỷ VNĐ</div>
                        <div class="text-xs text-gray-600">-280 Triệu/m2</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold">410 m2</div>
                        <div class="text-xs text-gray-600">(17m × 18m)</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <i class="far fa-heart text-gray-400"></i>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <span
                            class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Đang
                            Giao Dịch</span>
                        <div class="text-xs text-gray-500 mt-1">Hôm Qua lúc 02 giờ 22</div>
                    </td>
                </tr>
                <!-- Sample Row 11 -->
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        <div class="flex items-center space-x-2">
                            <span>11</span>
                            <input type="checkbox" class="form-checkbox h-4 w-4 text-blue-600 rounded">
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold">BÁN</div>
                        <div class="text-xs text-gray-600">Đất</div>
                        <div>745 Bến Vân Đồn</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold">Bến Vân Đồn</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Quận 4</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold text-red-600">120 Tỷ VNĐ</div>
                        <div class="text-xs text-gray-600">-300 Triệu/m2</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold">400 m2</div>
                        <div class="text-xs text-gray-600">(12m × 30m)</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <i class="far fa-heart text-gray-400"></i>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <span
                            class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Đang
                            Giao Dịch</span>
                        <div class="text-xs text-gray-500 mt-1">Hôm Qua lúc 01 giờ 15</div>
                    </td>
                </tr>
                <!-- Sample Row 12 -->
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        <div class="flex items-center space-x-2">
                            <span>12</span>
                            <input type="checkbox" class="form-checkbox h-4 w-4 text-blue-600 rounded">
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold">BÁN</div>
                        <div class="text-xs text-gray-600">Nhà phố</div>
                        <div>123 Nguyễn Văn Cừ</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold">Nguyễn Văn Cừ</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Nguyễn Cư Trinh</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Quận 1</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold text-red-600">110 Tỷ VNĐ</div>
                        <div class="text-xs text-gray-600">-350 Triệu/m2</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold">300 m2</div>
                        <div class="text-xs text-gray-600">(10m × 30m)</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <i class="far fa-heart text-gray-400"></i>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <span
                            class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Đang
                            Giao Dịch</span>
                        <div class="text-xs text-gray-500 mt-1">Hôm Qua lúc 00 giờ 00</div>
                    </td>
                </tr>
                <!-- Sample Row 13 -->
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        <div class="flex items-center space-x-2">
                            <span>13</span>
                            <input type="checkbox" class="form-checkbox h-4 w-4 text-blue-600 rounded">
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold">BÁN</div>
                        <div class="text-xs text-gray-600">Nhà phố</div>
                        <div>82B Đào Duy Từ</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold">Đào Duy Từ</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Quận 10</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold text-red-600">85 Tỷ VNĐ</div>
                        <div class="text-xs text-gray-600">-250 Triệu/m2</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold">340 m2</div>
                        <div class="text-xs text-gray-600">(10m × 34m)</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <i class="far fa-heart text-gray-400"></i>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <span
                            class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Đang
                            Giao Dịch</span>
                        <div class="text-xs text-gray-500 mt-1">Hôm Qua lúc 23 giờ 00</div>
                    </td>
                </tr>
                <!-- Sample Row 14 -->
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        <div class="flex items-center space-x-2">
                            <span>14</span>
                            <input type="checkbox" class="form-checkbox h-4 w-4 text-blue-600 rounded">
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold">BÁN</div>
                        <div class="text-xs text-gray-600">Đất</div>
                        <div>15 Võ Văn Tần</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold">Võ Văn Tần</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">P.1</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Quận 1</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold text-red-600">120 Tỷ VNĐ</div>
                        <div class="text-xs text-gray-600">-280 Triệu/m2</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold">430 m2</div>
                        <div class="text-xs text-gray-600">(15m × 28m)</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <i class="far fa-heart text-gray-400"></i>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <span
                            class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Đang
                            Giao Dịch</span>
                        <div class="text-xs text-gray-500 mt-1">Hôm Qua lúc 22 giờ 00</div>
                    </td>
                </tr>
                <!-- Sample Row 15 -->
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        <div class="flex items-center space-x-2">
                            <span>15</span>
                            <input type="checkbox" class="form-checkbox h-4 w-4 text-blue-600 rounded">
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold">BÁN</div>
                        <div class="text-xs text-gray-600">Nhà phố</div>
                        <div>291 Nguyễn Văn Cừ</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold">Nguyễn Văn Cừ</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">P.1</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Quận 5</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold text-red-600">170 Tỷ VNĐ</div>
                        <div class="text-xs text-gray-600">-300 Triệu/m2</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold">560 m2</div>
                        <div class="text-xs text-gray-600">(20m × 28m)</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <i class="far fa-heart text-gray-400"></i>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <span
                            class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Đang
                            Giao Dịch</span>
                        <div class="text-xs text-gray-500 mt-1">Hôm Qua lúc 21 giờ 00</div>
                    </td>
                </tr>
                <!-- Sample Row 16 -->
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        <div class="flex items-center space-x-2">
                            <span>16</span>
                            <input type="checkbox" class="form-checkbox h-4 w-4 text-blue-600 rounded">
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold">BÁN</div>
                        <div class="text-xs text-gray-600">Nhà phố</div>
                        <div>29/1 Nguyễn Văn Lương</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold">Nguyễn Văn Lương</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Gò Vấp</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold text-red-600">120 Tỷ VNĐ</div>
                        <div class="text-xs text-gray-600">-280 Triệu/m2</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold">430 m2</div>
                        <div class="text-xs text-gray-600">(15m × 28m)</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <i class="far fa-heart text-gray-400"></i>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <span
                            class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Đang
                            Giao Dịch</span>
                        <div class="text-xs text-gray-500 mt-1">Hôm Qua lúc 20 giờ 00</div>
                    </td>
                </tr>
                <!-- Sample Row 17 -->
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        <div class="flex items-center space-x-2">
                            <span>17</span>
                            <input type="checkbox" class="form-checkbox h-4 w-4 text-blue-600 rounded">
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold">BÁN</div>
                        <div class="text-xs text-gray-600">Nhà phố</div>
                        <div>16 Nguyễn Văn Lượng</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold">Nguyễn Văn Lượng</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Quận 6</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold text-red-600">98 Tỷ VNĐ</div>
                        <div class="text-xs text-gray-600">-380 Triệu/m2</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold">280 m2</div>
                        <div class="text-xs text-gray-600">(8m × 35m)</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <i class="far fa-heart text-gray-400"></i>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <span
                            class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Đang
                            Giao Dịch</span>
                        <div class="text-xs text-gray-500 mt-1">Hôm Qua lúc 19 giờ 00</div>
                    </td>
                </tr>
                <!-- Sample Row 18 -->
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        <div class="flex items-center space-x-2">
                            <span>18</span>
                            <input type="checkbox" class="form-checkbox h-4 w-4 text-blue-600 rounded">
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold">BÁN</div>
                        <div class="text-xs text-gray-600">Nhà phố</div>
                        <div>36 Nguyễn Trãi</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold">Nguyễn Trãi</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">P.1</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Quận 1</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold text-red-600">500 Tỷ VNĐ</div>
                        <div class="text-xs text-gray-600">-280 Triệu/m2</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold">1800 m2</div>
                        <div class="text-xs text-gray-600">(30m × 60m)</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <i class="far fa-heart text-gray-400"></i>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <span
                            class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Đang
                            Giao Dịch</span>
                        <div class="text-xs text-gray-500 mt-1">Hôm Qua lúc 18 giờ 00</div>
                    </td>
                </tr>
                <!-- Sample Row 19 -->
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        <div class="flex items-center space-x-2">
                            <span>19</span>
                            <input type="checkbox" class="form-checkbox h-4 w-4 text-blue-600 rounded">
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold">BÁN</div>
                        <div class="text-xs text-gray-600">Đất</div>
                        <div>152 Lê Lợi</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold">Lê Lợi</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">P.1</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Quận 1</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold text-red-600">180 Tỷ VNĐ</div>
                        <div class="text-xs text-gray-600">-300 Triệu/m2</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold">600 m2</div>
                        <div class="text-xs text-gray-600">(20m × 30m)</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <i class="far fa-heart text-gray-400"></i>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <span
                            class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Đang
                            Giao Dịch</span>
                        <div class="text-xs text-gray-500 mt-1">Hôm Qua lúc 17 giờ 00</div>
                    </td>
                </tr>
                <!-- Sample Row 20 -->
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        <div class="flex items-center space-x-2">
                            <span>20</span>
                            <input type="checkbox" class="form-checkbox h-4 w-4 text-blue-600 rounded">
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold">BÁN</div>
                        <div class="text-xs text-gray-600">Nhà phố</div>
                        <div>59 Lý Văn Sỹ</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold">Lý Văn Sỹ</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">P.1</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Quận 3</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold text-red-600">24 Tỷ VNĐ</div>
                        <div class="text-xs text-gray-600">-190 Triệu/m2</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="font-semibold">120 m2</div>
                        <div class="text-xs text-gray-600">(6m × 20m)</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <i class="far fa-heart text-gray-400"></i>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <span
                            class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Đang
                            Giao Dịch</span>
                        <div class="text-xs text-gray-500 mt-1">Hôm Qua lúc 16 giờ 00</div>
                    </td>
                </tr>
            </tbody>
        </table>
        <!-- Pagination -->
        <div class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6 mt-4">
            <div class="flex flex-1 justify-between sm:hidden">
                <a href="#"
                    class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Previous</a>
                <a href="#"
                    class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Next</a>
            </div>
            <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm text-gray-700">
                        Tổng <span class="font-medium">125.427</span> Trang <span
                            class="font-medium">2/8772</span>
                    </p>
                </div>
                <div>
                    <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                        <a href="#"
                            class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                            <span class="sr-only">Previous</span>
                            <i class="fas fa-chevron-left"></i>
                        </a>
                        <a href="#" aria-current="page"
                            class="relative z-10 inline-flex items-center bg-blue-600 px-4 py-2 text-sm font-semibold text-white focus:z-20 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">1</a>
                        <a href="#"
                            class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">2</a>
                        <a href="#"
                            class="relative hidden items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0 md:inline-flex">3</a>
                        <span
                            class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-700 ring-1 ring-inset ring-gray-300 focus:outline-offset-0">...</span>
                        <a href="#"
                            class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                            <span class="sr-only">Next</span>
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</main>
        
