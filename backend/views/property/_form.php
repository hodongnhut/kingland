<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/** @var yii\web\View $this */
/** @var common\models\Properties $model */
?>

<div class="bg-white p-6 rounded-lg shadow-md ">
    <div class="flex items-center justify-between">
        <h2 class="text-lg font-semibold text-gray-800">Màn hình chính / Thêm Dữ Liệu Nhà Đất [<?= $model->property_id ?>]</h2>
        <div class="flex space-x-2">
            <?= Html::submitButton('Lưu Lại', ['class' => 'px-4 py-2 bg-orange-600 text-white rounded-md shadow-sm hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500']) ?>
            <?= Html::a('Quay lại', Yii::$app->request->referrer ?: ['index'], ['class' => 'px-4 py-2 bg-gray-200 text-gray-800 rounded-md shadow-sm hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500']) ?>
        </div>
    </div>
</div>

<header class="bg-white mt-2 p-4 shadow-md flex items-center justify-between rounded-bl-lg rounded-br-lg rounded-tr-lg rounded-tl-lg">
    <nav class="flex space-x-4">
        <button id="thong-tin-tab" class="px-4 py-2 text-orange-600 border-b-2 border-orange-600 font-medium rounded-t-md">Thông Tin</button>
        <button id="so-hong-tab" class="px-4 py-2 text-gray-600 hover:text-orange-600 hover:border-b-2 hover:border-orange-600 transition-colors duration-200 rounded-t-md">Sổ Hồng & Hình Ảnh</button>
    </nav>
    <div class="text-lg font-semibold text-gray-800">
        Địa Chỉ <span class="text-gray-500 text-sm">→ Số 17-19 Phan Đình Phùng, Phường 17, Phú Nhuận, TP.HCM</span>
    </div>
</header>

<main class="flex-1 mt-2 overflow-y-auto hide-scrollbar">
    <div id="thong-tin-content" class="tab-content">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Column 1: Property Details -->
            <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow-md space-y-6">
                <!-- Property Type Tabs -->
                <h3 class="text-md font-semibold text-gray-800 mb-3">Vị Trí BĐS</h3>
                <div class="flex space-x-2 mb-4">
                    <button class="px-4 py-2 text-sm font-medium rounded-full bg-gray-100 text-gray-700 hover:bg-gray-200">Mặt Tiền</button>
                    <button class="px-4 py-2 text-sm font-medium rounded-full bg-orange-100 text-orange-700">Đường Nội Bộ</button>
                    <button class="px-4 py-2 text-sm font-medium rounded-full bg-gray-100 text-gray-700 hover:bg-gray-200">Hẻm</button>
                    <button class="px-4 py-2 text-sm font-medium rounded-full bg-gray-100 text-gray-700 hover:bg-gray-200">Compound</button>
                </div>

                <!-- Price Section -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Giá</label>
                        <input type="text" id="price" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm" value="13.000.000.000">
                    </div>
                    <div>
                        <label for="final_price" class="block text-sm font-medium text-gray-700 mb-1">Giá Chót</label>
                        <input type="text" id="final_price" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm" value="0">
                    </div>
                </div>
                <!-- Rental Contract Checkbox -->
                <div class="flex items-center mt-4">
                    <input id="rental_contract" name="rental_contract" type="checkbox" class="h-4 w-4 text-orange-600 focus:ring-orange-500 border-gray-300 rounded">
                    <label for="rental_contract" class="ml-2 block text-sm text-gray-900">
                    Có Hợp đồng thuê
                    </label>
                </div>
                <!-- Parcel/Lot Numbers -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                    <div>
                        <label for="parcel_number" class="block text-sm font-medium text-gray-700 mb-1">Số Thửa</label>
                        <input type="text" id="parcel_number" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm">
                    </div>
                    <div>
                        <label for="map_sheet_number" class="block text-sm font-medium text-gray-700 mb-1">Số Tờ</label>
                        <input type="text" id="map_sheet_number" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm">
                    </div>
                    <div>
                        <label for="lot_number" class="block text-sm font-medium text-gray-700 mb-1">Số Lô</label>
                        <input type="text" id="lot_number" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm">
                    </div>
                </div>
                <!-- Address Details -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                    <div>
                        <label for="ward" class="block text-sm font-medium text-gray-700 mb-1">Phường / Xã</label>
                        <select id="ward" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm">
                            <option>Phường 17</option>
                            <option>Phường 1</option>
                        </select>
                    </div>
                    <div>
                        <label for="district" class="block text-sm font-medium text-gray-700 mb-1">Quận / Huyện</label>
                        <select id="district" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm">
                            <option>Phú Nhuận</option>
                            <option>Quận 1</option>
                        </select>
                    </div>
                    <div>
                        <label for="province" class="block text-sm font-medium text-gray-700 mb-1">Tỉnh / TP</label>
                        <select id="province" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm">
                            <option>TP Hồ Chí Minh</option>
                            <option>Hà Nội</option>
                        </select>
                    </div>
                </div>
                <!-- Project Name -->
                <div class="mt-4">
                    <label for="project_name" class="block text-sm font-medium text-gray-700 mb-1">Dự án</label>
                    <input type="text" id="project_name" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm" value="Viduc CityLand, Trung Sơn, Cư">
                </div>
                <!-- Dimensions Section -->
                <h3 class="text-md font-semibold text-gray-800 mt-6 mb-3">Diện Tích Đất</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div>
                        <label for="frontage" class="block text-sm font-medium text-gray-700 mb-1">Ngang</label>
                        <div class="relative mt-1 rounded-md shadow-sm">
                            <input type="text" id="frontage" class="block w-full pr-10 border border-gray-300 rounded-md py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm" value="9.00">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">m</span>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label for="rearage" class="block text-sm font-medium text-gray-700 mb-1">Dài</label>
                        <div class="relative mt-1 rounded-md shadow-sm">
                            <input type="text" id="rearage" class="block w-full pr-10 border border-gray-300 rounded-md py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm" value="11.00">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">m</span>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label for="area" class="block text-sm font-medium text-gray-700 mb-1">Mặt Hậu</label>
                        <div class="relative mt-1 rounded-md shadow-sm">
                            <input type="text" id="area" class="block w-full pr-10 border border-gray-300 rounded-md py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm" value="155.00">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">m²</span>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label for="planned_area" class="block text-sm font-medium text-gray-700 mb-1">Diện Tích Công Nhận</label>
                        <div class="relative mt-1 rounded-md shadow-sm">
                            <input type="text" id="planned_area" class="block w-full pr-10 border border-gray-300 rounded-md py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm" value="0.00">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">m²</span>
                            </div>
                        </div>
                    </div>
                </div>
                <h3 class="text-md font-semibold text-gray-800 mt-6 mb-3">Diện Tích Quy Hoạch</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div>
                        <label for="frontage" class="block text-sm font-medium text-gray-700 mb-1">Ngang</label>
                        <div class="relative mt-1 rounded-md shadow-sm">
                            <input type="text" id="frontage" class="block w-full pr-10 border border-gray-300 rounded-md py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm" value="9.00">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">m</span>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label for="rearage" class="block text-sm font-medium text-gray-700 mb-1">Dài</label>
                        <div class="relative mt-1 rounded-md shadow-sm">
                            <input type="text" id="rearage" class="block w-full pr-10 border border-gray-300 rounded-md py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm" value="11.00">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">m</span>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label for="area" class="block text-sm font-medium text-gray-700 mb-1">Mặt Hậu</label>
                        <div class="relative mt-1 rounded-md shadow-sm">
                            <input type="text" id="area" class="block w-full pr-10 border border-gray-300 rounded-md py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm" value="155.00">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">m²</span>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label for="planned_area" class="block text-sm font-medium text-gray-700 mb-1">Diện Tích Xây Dựng</label>
                        <div class="relative mt-1 rounded-md shadow-sm">
                            <input type="text" id="planned_area" class="block w-full pr-10 border border-gray-300 rounded-md py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm" value="0.00">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">m²</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Characteristics Section -->
                <h3 class="text-md font-semibold text-gray-800 mb-3">Thông Tin Khác</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-4">
                   
                    <div>
                        <label for="product_type" class="block text-sm font-medium text-gray-700 mb-1">Loại sản phẩm</label>
                        <select id="product_type" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm">
                            <option>Khác</option>
                            <option>Nhà phố</option>
                        </select>
                    </div>
                    <div>
                        <label for="direction" class="block text-sm font-medium text-gray-700 mb-1">Hướng</label>
                        <select id="direction" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm">
                            <option>Chọn Hướng</option>
                            <option>Đông</option>
                        </select>
                    </div>
                    <div>
                        <label for="direction" class="block text-sm font-medium text-gray-700 mb-1">Loại Đất</label>
                        <select id="direction" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm">
                            <option>Chọn Hướng</option>
                            <option>Đông</option>
                        </select>
                    </div>
                    <div>
                        <label for="road_width" class="block text-sm font-medium text-gray-700 mb-1">Đường rộng</label>
                        <div class="relative mt-1 rounded-md shadow-sm">
                            <input type="text" id="road_width" class="block w-full pr-10 border border-gray-300 rounded-md py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm" value="2">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">m</span>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label for="usable_area" class="block text-sm font-medium text-gray-700 mb-1">DT Sử dụng</label>
                        <div class="relative mt-1 rounded-md shadow-sm">
                            <input type="text" id="usable_area" class="block w-full pr-10 border border-gray-300 rounded-md py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm" value="2">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">m²</span>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label for="num_floors" class="block text-sm font-medium text-gray-700 mb-1">Số Tầng</label>
                        <input type="text" id="num_floors" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm" value="0">
                    </div>
                    <div>
                        <label for="num_bedrooms" class="block text-sm font-medium text-gray-700 mb-1">Số phòng ngủ</label>
                        <input type="text" id="num_bedrooms" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm" value="0">
                    </div>
                    <div>
                        <label for="num_bathrooms" class="block text-sm font-medium text-gray-700 mb-1">Số WC</label>
                        <input type="text" id="num_bathrooms" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm" value="0">
                    </div>
                    <div>
                        <label for="num_basements" class="block text-sm font-medium text-gray-700 mb-1">Số tầng hầm</label>
                        <input type="text" id="num_basements" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm" value="0">
                    </div>
                </div>
            </div>
            <!-- Column 2: Asset Type, Commission, Status, Advantages/Disadvantages, and Features -->
            <div class="lg:col-span-1 bg-white p-6 rounded-lg shadow-md space-y-6">
                <!-- Asset Type Section -->
                <div>
                    <h3 class="text-md font-semibold text-gray-800 mb-3">Loại Tài Sản</h3>
                    <div class="flex flex-wrap gap-2">
                        <label class="inline-flex items-center">
                        <input type="radio" class="form-radio text-orange-600 h-4 w-4" name="asset_type" value="apartment">
                        <span class="ml-2 text-sm text-gray-700">Căn hộ</span>
                        </label>
                        <label class="inline-flex items-center">
                        <input type="radio" class="form-radio text-orange-600 h-4 w-4" name="asset_type" value="company" checked>
                        <span class="ml-2 text-sm text-gray-700">Công ty</span>
                        </label>
                        <label class="inline-flex items-center">
                        <input type="radio" class="form-radio text-orange-600 h-4 w-4" name="asset_type" value="inheritance">
                        <span class="ml-2 text-sm text-gray-700">Thừa Kế</span>
                        </label>
                        <label class="inline-flex items-center">
                        <input type="radio" class="form-radio text-orange-600 h-4 w-4" name="asset_type" value="divorce">
                        <span class="ml-2 text-sm text-gray-700">Vợ Chồng Ly Hôn</span>
                        </label>
                        <label class="inline-flex items-center">
                        <input type="radio" class="form-radio text-orange-600 h-4 w-4" name="asset_type" value="sample">
                        <span class="ml-2 text-sm text-gray-700">Phân Mẫu</span>
                        </label>
                        <label class="inline-flex items-center">
                        <input type="radio" class="form-radio text-orange-600 h-4 w-4" name="asset_type" value="auction">
                        <span class="ml-2 text-sm text-gray-700">Đấu Giá</span>
                        </label>
                        <label class="inline-flex items-center">
                        <input type="radio" class="form-radio text-orange-600 h-4 w-4" name="asset_type" value="mortgage">
                        <span class="ml-2 text-sm text-gray-700">Thế Chấp</span>
                        </label>
                    </div>
                    <p class="text-xs text-gray-500 mt-3 mb-2">Nếu bạn có thông tin liên hệ chủ nhà thì hãy điền vào đây.</p>
                    <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm" placeholder="Nhập thông tin liên hệ...">
                </div>
                <!-- Commission Type Section -->
                <div>
                    <h3 class="text-md font-semibold text-gray-800 mb-3">Loại Hoa Hồng</h3>
                    <div class="flex space-x-4 mb-2">
                        <label class="inline-flex items-center">
                        <input type="radio" class="form-radio text-orange-600 h-4 w-4" name="commission_type" value="percentage" checked>
                        <span class="ml-2 text-sm text-gray-700">Phần trăm</span>
                        </label>
                        <label class="inline-flex items-center">
                        <input type="radio" class="form-radio text-orange-600 h-4 w-4" name="commission_type" value="month">
                        <span class="ml-2 text-sm text-gray-700">Tháng</span>
                        </label>
                    </div>
                    <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm" placeholder="Tên">
                    <input type="text" class="mt-3 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm" placeholder="Phần trăm">
                </div>
                <!-- Status Section -->
                <div>
                    <h3 class="text-md font-semibold text-gray-800 mb-3">Trạng Thái</h3>
                    <div class="flex flex-wrap gap-2 mb-2">
                        <label class="inline-flex items-center">
                        <input type="radio" class="form-radio text-orange-600 h-4 w-4" name="status" value="trading" checked>
                        <span class="ml-2 text-sm text-gray-700">Đang Giao Dịch</span>
                        </label>
                        <label class="inline-flex items-center">
                        <input type="radio" class="form-radio text-orange-600 h-4 w-4" name="status" value="stopped">
                        <span class="ml-2 text-sm text-gray-700">Ngừng Giao Dịch</span>
                        </label>
                        <label class="inline-flex items-center">
                        <input type="radio" class="form-radio text-orange-600 h-4 w-4" name="status" value="traded">
                        <span class="ml-2 text-sm text-gray-700">Đã Giao Dịch</span>
                        </label>
                        <label class="inline-flex items-center">
                        <input type="radio" class="form-radio text-orange-600 h-4 w-4" name="status" value="deposited">
                        <span class="ml-2 text-sm text-gray-700">Đã Cọc</span>
                        </label>
                    </div>
                    <textarea class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-orange-500 focus:border-orange-500 sm:text-sm" rows="2" placeholder="Nhập Thông Tin Mô Tả"></textarea>
                </div>
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md mt-6">
                <!-- Features Checklist -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-2 text-sm text-gray-700">
                    <!-- Column 1: Ưu Điểm -->
                    <div>
                        <h3 class="text-md font-semibold text-gray-800 mb-3">Ưu Điểm</h3>
                        <label class="flex items-center">
                        <input type="checkbox" class="form-checkbox h-4 w-4 text-orange-600 rounded">
                        <span class="ml-2">Nhà Mới Xây</span>
                        </label>
                        <label class="flex items-center">
                        <input type="checkbox" class="form-checkbox h-4 w-4 text-orange-600 rounded">
                        <span class="ml-2">Giá Rẻ</span>
                        </label>
                        <label class="flex items-center">
                        <input type="checkbox" class="form-checkbox h-4 w-4 text-orange-600 rounded">
                        <span class="ml-2">Bề Ngang Lớn</span>
                        </label>
                        <label class="flex items-center">
                        <input type="checkbox" class="form-checkbox h-4 w-4 text-orange-600 rounded">
                        <span class="ml-2">Nhà Kế Bên Có Bán, Có Thể Mua Gộp</span>
                        </label>
                        <label class="flex items-center">
                        <input type="checkbox" class="form-checkbox h-4 w-4 text-orange-600 rounded">
                        <span class="ml-2">Vị Trí Đẹp Nhất Trên Con Đường</span>
                        </label>
                        <label class="flex items-center">
                        <input type="checkbox" class="form-checkbox h-4 w-4 text-orange-600 rounded">
                        <span class="ml-2">Căn Góc, có hẻm bên hông</span>
                        </label>
                        <label class="flex items-center">
                        <input type="checkbox" class="form-checkbox h-4 w-4 text-orange-600 rounded">
                        <span class="ml-2">Căn Góc, 2 Mặt Đường Chính</span>
                        </label>
                        <label class="flex items-center">
                        <input type="checkbox" class="form-checkbox h-4 w-4 text-orange-600 rounded">
                        <span class="ml-2">Nhà 2 Mặt Đường Trước và Sau</span>
                        </label>
                        <label class="flex items-center">
                        <input type="checkbox" class="form-checkbox h-4 w-4 text-orange-600 rounded">
                        <span class="ml-2">Có Hẻm Sau Nhà</span>
                        </label>
                        <label class="flex items-center">
                        <input type="checkbox" class="form-checkbox h-4 w-4 text-orange-600 rounded">
                        <span class="ml-2">Hẻm Thông</span>
                        </label>
                        <label class="flex items-center">
                        <input type="checkbox" class="form-checkbox h-4 w-4 text-orange-600 rounded">
                        <span class="ml-2">Gần Công Viên,Siêu Thị,Trung Tâm Thương Mại</span>
                        </label>
                        <label class="flex items-center">
                        <input type="checkbox" class="form-checkbox h-4 w-4 text-orange-600 rounded">
                        <span class="ml-2">Tầng Full Nội Thất</span>
                        </label>
                        <label class="flex items-center">
                        <input type="checkbox" class="form-checkbox h-4 w-4 text-orange-600 rounded">
                        <span class="ml-2">Nội Thất Cao Cấp</span>
                        </label>
                        <label class="flex items-center">
                        <input type="checkbox" class="form-checkbox h-4 w-4 text-orange-600 rounded">
                        <span class="ml-2">Quy Hoạch Mở Đường</span>
                        </label>
                        <label class="flex items-center">
                        <input type="checkbox" class="form-checkbox h-4 w-4 text-orange-600 rounded">
                        <span class="ml-2">Gần Siêu Dự Án Đang Xây</span>
                        </label>
                        <label class="flex items-center">
                        <input type="checkbox" class="form-checkbox h-4 w-4 text-orange-600 rounded">
                        <span class="ml-2">Chủ nhà thiện chí</span>
                        </label>
                        <label class="flex items-center">
                        <input type="checkbox" class="form-checkbox h-4 w-4 text-orange-600 rounded">
                        <span class="ml-2">Có Hệ thống PCCC</span>
                        </label>
                        <label class="flex items-center">
                        <input type="checkbox" class="form-checkbox h-4 w-4 text-orange-600 rounded">
                        <span class="ml-2">Khuôn Đất Vuông Vức</span>
                        </label>
                        <label class="flex items-center">
                        <input type="checkbox" class="form-checkbox h-4 w-4 text-orange-600 rounded">
                        <span class="ml-2">Giá /m2 rẻ</span>
                        </label>
                        <label class="flex items-center">
                        <input type="checkbox" class="form-checkbox h-4 w-4 text-orange-600 rounded">
                        <span class="ml-2">Nhà đẹp có sẵn nội thất</span>
                        </label>
                        <label class="flex items-center">
                        <input type="checkbox" class="form-checkbox h-4 w-4 text-orange-600 rounded">
                        <span class="ml-2">Gần mặt tiền đường</span>
                        </label>
                        <label class="flex items-center">
                        <input type="checkbox" class="form-checkbox h-4 w-4 text-orange-600 rounded">
                        <span class="ml-2">Nhà cũ tiện xây mới</span>
                        </label>
                        <label class="flex items-center">
                        <input type="checkbox" class="form-checkbox h-4 w-4 text-orange-600 rounded">
                        <span class="ml-2">Nhà nhiều phòng</span>
                        </label>
                        <label class="flex items-center">
                        <input type="checkbox" class="form-checkbox h-4 w-4 text-orange-600 rounded">
                        <span class="ml-2">Nhà cho thuê giá cao</span>
                        </label>
                    </div>
                    <!-- Column 2: Nhược Điểm -->
                    <div>
                        <h3 class="text-md font-semibold text-gray-800 mb-3">Nhược Điểm</h3>
                        <label class="flex items-center">
                        <input type="checkbox" class="form-checkbox h-4 w-4 text-orange-600 rounded">
                        <span class="ml-2">Đất Tốp Hậu</span>
                        </label>
                        <label class="flex items-center">
                        <input type="checkbox" class="form-checkbox h-4 w-4 text-orange-600 rounded">
                        <span class="ml-2">Đường Hoặc Hẻm Đâm Vào Nhà</span>
                        </label>
                        <label class="flex items-center">
                        <input type="checkbox" class="form-checkbox h-4 w-4 text-orange-600 rounded">
                        <span class="ml-2">Đất Không Được Vuông</span>
                        </label>
                        <label class="flex items-center">
                        <input type="checkbox" class="form-checkbox h-4 w-4 text-orange-600 rounded">
                        <span class="ml-2">Có Cống Trước Nhà</span>
                        </label>
                        <label class="flex items-center">
                        <input type="checkbox" class="form-checkbox h-4 w-4 text-orange-600 rounded">
                        <span class="ml-2">Có Trụ Điện Trước Nhà</span>
                        </label>
                        <label class="flex items-center">
                        <input type="checkbox" class="form-checkbox h-4 w-4 text-orange-600 rounded">
                        <span class="ml-2">Có Cây Trước Nhà</span>
                        </label>
                        <label class="flex items-center">
                        <input type="checkbox" class="form-checkbox h-4 w-4 text-orange-600 rounded">
                        <span class="ml-2">Không Cho Xây Mới Hoặc Không Thể Xây Mới</span>
                        </label>
                        <label class="flex items-center">
                        <input type="checkbox" class="form-checkbox h-4 w-4 text-orange-600 rounded">
                        <span class="ml-2">Quy Hoạch Treo</span>
                        </label>
                        <label class="flex items-center">
                        <input type="checkbox" class="form-checkbox h-4 w-4 text-orange-600 rounded">
                        <span class="ml-2">Quy Hoạch Lộ Giới Nhiều</span>
                        </label>
                        <label class="flex items-center">
                        <input type="checkbox" class="form-checkbox h-4 w-4 text-orange-600 rounded">
                        <span class="ml-2">Quy Hoạch Lộ Giới Hết Nhà</span>
                        </label>
                        <label class="flex items-center">
                        <input type="checkbox" class="form-checkbox h-4 w-4 text-orange-600 rounded">
                        <span class="ml-2">Pháp Lý (Thừa Kế, Tranh Chấp, Chưa Hoàn Công...)</span>
                        </label>
                        <label class="flex items-center">
                        <input type="checkbox" class="form-checkbox h-4 w-4 text-orange-600 rounded">
                        <span class="ml-2">Đối Diện Gần Chùa, Nhà Thờ</span>
                        </label>
                        <label class="flex items-center">
                        <input type="checkbox" class="form-checkbox h-4 w-4 text-orange-600 rounded">
                        <span class="ml-2">Dưới Chân Cầu Hoặc Điện Cao Thế</span>
                        </label>
                        <label class="flex items-center">
                        <input type="checkbox" class="form-checkbox h-4 w-4 text-orange-600 rounded">
                        <span class="ml-2">Gần Trại Hòm</span>
                        </label>
                        <label class="flex items-center">
                        <input type="checkbox" class="form-checkbox h-4 w-4 text-orange-600 rounded">
                        <span class="ml-2">Gần Nghĩa Trang</span>
                        </label>
                        <label class="flex items-center">
                        <input type="checkbox" class="form-checkbox h-4 w-4 text-orange-600 rounded">
                        <span class="ml-2">Gần nhà tang lễ</span>
                        </label>
                        <label class="flex items-center">
                        <input type="checkbox" class="form-checkbox h-4 w-4 text-orange-600 rounded">
                        <span class="ml-2">Chủ nhà không thiện chí</span>
                        </label>
                        <label class="flex items-center">
                        <input type="checkbox" class="form-checkbox h-4 w-4 text-orange-600 rounded">
                        <span class="ml-2">Hẻm Cụt</span>
                        </label>
                    </div>
                </div>
        </div>
    </div>
    <div id="so-hong-content" class="tab-content hidden bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-md font-semibold text-gray-800 mb-3">Hình ảnh đã tải lên</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white rounded-lg border border-gray-200 p-4">
                <div class="flex items-center mb-4">
                    <div class="bg-purple-600 text-white p-2 rounded-md mr-3 flex-shrink-0">
                        <i class="fas fa-file-alt text-lg"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800">SỔ HỒNG | GIẤY TỜ PHÁP LÝ</h3>
                </div>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center text-gray-500 hover:border-blue-400 hover:text-blue-600 cursor-pointer transition duration-200 ease-in-out">
                    <i class="fas fa-cloud-upload-alt text-4xl mb-2"></i>
                    <p>Chọn hoặc kéo thả</p>
                    <p class="text-xs">File: pdf, jpg, png, jpeg, webp, heic!</p>
                    <input type="file" multiple class="hidden">
                </div>
            </div>
            <div class="bg-white rounded-lg border border-gray-200 p-4">
                <div class="flex items-center mb-4">
                    <div class="bg-blue-600 text-white p-2 rounded-md mr-3 flex-shrink-0">
                        <i class="fas fa-images text-lg"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800">HÌNH ẢNH BỔ SUNG</h3>
                </div>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center text-gray-500 hover:border-blue-400 hover:text-blue-600 cursor-pointer transition duration-200 ease-in-out">
                    <i class="fas fa-cloud-upload-alt text-4xl mb-2"></i>
                    <p>Chọn hoặc kéo thả</p>
                    <p class="text-xs">File: pdf, jpg, png, jpeg, webp, heic!</p>
                    <input type="file" multiple class="hidden">
                </div>
            </div>
        </div>
        <br>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <!-- Placeholder for uploaded images -->
            <div class="relative group aspect-w-1 aspect-h-1 w-full rounded-lg overflow-hidden border border-gray-200">
                <img src="https://placehold.co/150x150/e0e0e0/555555?text=Image+1" alt="Placeholder Image 1" class="object-cover w-full h-full">
                <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                    <button class="text-white bg-red-500 hover:bg-red-600 p-2 rounded-full">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="relative group aspect-w-1 aspect-h-1 w-full rounded-lg overflow-hidden border border-gray-200">
                <img src="https://placehold.co/150x150/d0d0d0/444444?text=Image+2" alt="Placeholder Image 2" class="object-cover w-full h-full">
                <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                    <button class="text-white bg-red-500 hover:bg-red-600 p-2 rounded-full">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="relative group aspect-w-1 aspect-h-1 w-full rounded-lg overflow-hidden border border-gray-200">
                <img src="https://placehold.co/150x150/e0e0e0/555555?text=Image+1" alt="Placeholder Image 1" class="object-cover w-full h-full">
                <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                    <button class="text-white bg-red-500 hover:bg-red-600 p-2 rounded-full">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</main>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const thongTinTab = document.getElementById('thong-tin-tab');
        const soHongTab = document.getElementById('so-hong-tab');
        const thongTinContent = document.getElementById('thong-tin-content');
        const soHongContent = document.getElementById('so-hong-content');
    
        function activateTab(tabButton, contentDiv) {
            document.querySelectorAll('.tab-content').forEach(content => content.classList.add('hidden'));
            document.querySelectorAll('nav button').forEach(button => {
                button.classList.remove('text-orange-600', 'border-orange-600');
                button.classList.add('text-gray-600', 'hover:text-orange-600', 'hover:border-orange-600');
            });
    
            tabButton.classList.add('text-orange-600', 'border-b-2', 'border-orange-600');
            tabButton.classList.remove('text-gray-600', 'hover:text-orange-600', 'hover:border-orange-600');
            contentDiv.classList.remove('hidden');
        }
    
        thongTinTab.addEventListener('click', function() {
            activateTab(thongTinTab, thongTinContent);
        });
    
        soHongTab.addEventListener('click', function() {
            activateTab(soHongTab, soHongContent);
        });
    
        activateTab(thongTinTab, thongTinContent);
    });
</script>
