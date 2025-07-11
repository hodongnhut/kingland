
<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\PropertyImages;

/** @var yii\web\View $this */
/** @var common\models\Properties $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Properties', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="properties-view container mx-auto p-6 bg-white rounded-lg shadow-md">
    <h1 class="text-2xl font-bold text-gray-800 mb-4"><?= Html::encode($this->title) ?></h1>

    <div class="flex justify-between items-center mb-6">
        <div>
            <?= Html::a('Update', ['update', 'property_id' => $model->property_id], ['class' => 'btn bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700']) ?>
            <?= Html::a('Delete', ['delete', 'property_id' => $model->property_id], [
                'class' => 'btn bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        </div>
    </div>

    <!-- Property Images -->
    <div class="mb-6">
        <h2 class="text-lg font-semibold text-gray-700 mb-2">Hình ảnh bất động sản</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4 uploaded-images">
            <?php
            $images = $model->propertyImages;
            foreach ($images as $image) {
                echo "<div class='relative group aspect-w-1 aspect-h-1 w-full rounded-lg overflow-hidden border border-gray-200 image-container' data-image-id='{$image->image_id}'>";
                echo "<img src='" . Html::encode(Yii::$app->urlManager->createAbsoluteUrl($image->image_path)) . "' alt='" . Html::encode($image->image_path) . "' class='object-cover w-full h-full'>";
                echo "<button class='absolute top-2 right-2 text-white bg-red-500 hover:bg-red-600 p-2 rounded-full delete-btn opacity-0 group-hover:opacity-100 transition-opacity duration-200' data-image-id='{$image->image_id}'>";
                echo "<svg class='w-5 h-5' fill='none' viewBox='0 0 24 24' stroke='currentColor'>";
                echo "<path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16'></path>";
                echo "</svg></button></div>";
            }
            ?>
        </div>
    </div>

    <!-- Property Details -->
    <div class="bg-gray-50 p-4 rounded-lg">
        <?= DetailView::widget([
            'model' => $model,
            'options' => ['class' => 'table-auto w-full text-left text-gray-700'],
            'template' => '<tr><th class="px-4 py-2 bg-gray-100 font-semibold">{label}</th><td class="px-4 py-2">{value}</td></tr>',
            'attributes' => [
                'property_id',
                'user_id',
                [
                    'attribute' => 'title',
                    'format' => 'raw',
                    'value' => Html::encode($model->title),
                ],
                'property_type_id',
                [
                    'attribute' => 'selling_price',
                    'value' => number_format($model->selling_price, 0, ',', '.') . ' VNĐ',
                ],
                [
                    'attribute' => 'has_vat_invoice',
                    'value' => $model->has_vat_invoice ? 'Có' : 'Không',
                ],
                [
                    'attribute' => 'address',
                    'value' => implode(', ', array_filter([
                        $model->house_number,
                        $model->street_name,
                        $model->ward_commune,
                        $model->district_county,
                        $model->city,
                    ])),
                    'label' => 'Địa chỉ',
                ],
                'location_type_id',
                'compound_name',
                'area_total',
                'direction',
                'land_type',
                'num_bedrooms',
                'num_toilets',
                'num_floors',
                'description:ntext',
                'transaction_status_id',
                'transaction_description:ntext',
                [
                    'attribute' => 'is_active',
                    'value' => $model->is_active ? 'Hoạt động' : 'Không hoạt động',
                ],
                [
                    'attribute' => 'created_at',
                    'value' => date('d/m/Y H:i:s', $model->created_at),
                ],
                [
                    'attribute' => 'updated_at',
                    'value' => date('d/m/Y H:i:s', $model->updated_at),
                ],
                'external_id',
                'plot_number',
                'sheet_number',
                'lot_number',
                'commission_types_id',
                'commission_prices_id',
                'area_back_side',
                'wide_road',
                'planned_back_side',
                // Loại bỏ property_images_id vì nó không còn phù hợp với quan hệ hasMany
            ],
        ]) ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.addEventListener('click', function(e) {
        if (e.target.closest('.delete-btn')) {
            const button = e.target.closest('.delete-btn');
            const imageId = button.dataset.imageId;
            if (confirm('Bạn có chắc chắn muốn xóa hình ảnh này?')) {
                const xhr = new XMLHttpRequest();
                xhr.open('POST', '<?= Yii::$app->urlManager->createUrl(['properties/delete-image']) ?>', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.setRequestHeader('X-CSRF-Token', yii.getCsrfToken());
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4) {
                        if (xhr.status === 200) {
                            try {
                                const response = JSON.parse(xhr.responseText);
                                if (response.success) {
                                    document.querySelector(`.image-container[data-image-id="${imageId}"]`).remove();
                                    alert('Xóa hình ảnh thành công.');
                                } else {
                                    alert('Xóa hình ảnh thất bại: ' + response.message);
                                }
                            } catch (e) {
                                alert('Lỗi phân tích phản hồi từ server.');
                            }
                        } else {
                            alert('Lỗi khi xóa hình ảnh. Mã lỗi: ' + xhr.status);
                        }
                    }
                };
                xhr.send('image_id=' + encodeURIComponent(imageId));
            }
        }
    });
});
</script>