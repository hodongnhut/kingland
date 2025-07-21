<?php
use yii\helpers\Url;
use yii\helpers\Html;
// Nội dung ví dụ cho file _favorite_item.php (đặt trong backend/views/property/_favorite_item.php)
// File này sẽ định nghĩa cách hiển thị từng hàng tài sản yêu thích trong bảng.

/*
use yii\helpers\Html;
use yii\helpers\Url;
use common\models\PropertyFavorite; 

/** @var PropertyFavorite $model */
/** @var int $index */ // ListView cung cấp biến $index

$property = $model->property; // Lấy model Property liên quan

// Định nghĩa giá trị mặc định nếu tài sản là null hoặc thiếu thuộc tính
$propertyId = Html::encode($model->property_id);
$propertyTitle = $property ? Html::encode($property->title) : 'N/A';
$propertyDistrict = $property && isset($property->district_county) ? Html::encode($property->district_county) : 'N/A'; // Giả sử có thuộc tính 'district'
$propertyPrice = 'N/A';
$propertyAreaTotal = 'N/A';
$propertyStructure = 'N/A'; // Placeholder cho KẾT CẤU
$propertyLeaseContract = 'N/A'; // Placeholder cho HĐ THUÊ

if ($property) {
    if (isset($property->price) && $property->price !== null && isset($property->currencies->code)) {
        $propertyPrice = number_format($property->price / 1e9, 1) . ' Tỷ ' . Html::encode($property->currencies->code);
    } else {
        $propertyPrice = 'N/A';
    }

    if (isset($property->price) && isset($property->area_total) && $property->area_total > 0) {
        $pricePerM2 = number_format($property->price / $property->area_total / 1e6, 0) . ' Triệu/m2';
        $propertyAreaTotal = Html::encode($property->area_total) . ' m2';
    } else {
        $pricePerM2 = 'N/A';
        $propertyAreaTotal = 'N/A';
    }
    
    $propertyStructure =  'N/A'; // Giả sử có thuộc tính 'structure_type'
    $propertyLeaseContract = 'N/A'; // Giả sử có thuộc tính 'lease_contract_status'
}

$favoritedIcon = '<i class="fas fa-heart text-red-500"></i>'; // Luôn là trái tim đầy vì đây là danh sách yêu thích
$unfavoriteUrl = Url::to(['/property/toggle-favorite']); // URL để bỏ yêu thích

$updateUrl = $property ? Url::to(['property/view', 'property_id' => $property->property_id]) : '#'; // Giả sử action update dùng 'id'
$updateIcon = '<i class="fas fa-eye text-blue-500"></i>'; // Icon bút chì cho cập nhật

?>

<tr class="property-favorite-row border-b border-gray-200 hover:bg-gray-50">
    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
        <?= $index + 1 ?>
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
        <!-- "SỐ NHÀ" - Sử dụng property_id hoặc thuộc tính số nhà cụ thể nếu có -->
        <?= $propertyId ?>
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
        <!-- "ĐƯỜNG PHỐ" -->
        <?= $propertyTitle ?>
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
        <!-- "QUẬN/HUYỆN" -->
        <?= $propertyDistrict ?>
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-red-600 font-semibold">
        <!-- "GIÁ" -->
        <?= $propertyPrice ?>
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
        <!-- "DIỆN TÍCH" -->
        <?= $propertyAreaTotal ?>
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
        <!-- "KẾT CẤU" -->
        <?= $propertyStructure ?>
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
        <!-- "HĐ THUÊ" -->
        <?= $propertyLeaseContract ?>
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">
        <!-- "LƯU" - Luôn là trái tim đầy, với hành động bỏ yêu thích -->
        <?php if ($property): ?>
            <?= Html::tag('span', $favoritedIcon, [
                'class' => 'favorite-toggle cursor-pointer',
                'title' => 'Bỏ lưu', // Tiêu đề chỉ ra hành động bỏ yêu thích
                'data-property-id' => $property->property_id,
                'data-favorited' => 1, // Đã được yêu thích
                'data-url' => $unfavoriteUrl,
            ]) ?>
        <?php else: ?>
            <span class="text-gray-400 opacity-50 cursor-not-allowed" title="Thông tin tài sản không khả dụng">
                <i class="fas fa-heart"></i>
            </span>
        <?php endif; ?>
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">
        <!-- "CẬP NHẬT" -->
        <?php if ($property): ?>
            <?= Html::a($updateIcon, $updateUrl, ['title' => 'Xem Chi Tiết', 'class' => 'inline-block ml-2']) ?>
        <?php else: ?>
            <span class="text-gray-400 opacity-50 cursor-not-allowed" title="Không thể cập nhật">
                <i class="fas fa-pencil-alt"></i>
            </span>
        <?php endif; ?>
    </td>
</tr>