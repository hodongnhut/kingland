<?php
use yii\helpers\Html;
use common\models\PropertyFavorite; 

/** @var PropertyFavorite $model */

?>

<div class="property-favorite-item border p-4 mb-4 rounded-lg shadow-md">
    <h2 class="text-xl font-semibold">Tài sản ID: <?= Html::encode($model->property_id) ?></h2>
    <?php if ($model->property): // Kiểm tra xem tài sản có tồn tại không ?>
        <p>Địa Chỉ: <?= Html::encode($model->property->title) ?></p> <!-- Giả sử model Property có thuộc tính 'name' -->
        <p>Giá Bán:  <?= $price = number_format($model->property->price / 1e9, 1) . ' Tỷ ' . $model->property->currencies->code; ?>
        <p>Giá Bán/m2: <?= number_format($model->property->price / $model->property->area_total / 1e6, 0) . ' Triệu/m2' ?></p> <!-- Giả sử model Property có thuộc tính 'address' -->
        <p>Được lưu vào: <?= Yii::$app->formatter->asDatetime($model->created_at) ?></p>
        <?= Html::a('Xem chi tiết', ['property/view', 'property_id' => $model->property_id], ['class' => 'text-blue-500 hover:underline']) ?>
    <?php else: ?>
        <p class="text-red-500">Thông tin tài sản không khả dụng hoặc đã bị xóa.</p>
    <?php endif; ?>
</div>