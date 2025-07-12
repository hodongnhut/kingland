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
function formatPriceUnit($number) {
    if (!is_numeric($number) || $number <= 0) {
        return 'Thỏa thuận';
    }

    $billion = 1000000000;
    $million = 1000000;

    if ($number >= $billion) {
        $result = $number / $billion;
        $formatted_result = rtrim(rtrim(number_format($result, 1, '.', ''), '0'), '.');
        return $formatted_result . ' Tỷ';
    }

    if ($number >= $million) {
        $result = $number / $million;
        $formatted_result = round($result);
        return $formatted_result . ' Triệu';
    }
    
    return number_format($number) . ' VNĐ';
}

function formatNumber($number) {
    if ($number === null) {
        return null;
    }
    if ($number == (int)$number) {
        return (int)$number;
    }
    
    return (float)$number;
}
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

        <div id="thong-tin-content" class="tab-content lg:col-span-2 space-y-6">
            <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between">
                <div>                    
                    <p class="text-sm text-gray-500">Mã BĐS: <span class="font-semibold text-gray-800"><?= Html::encode($model->property_id) ?></span></p>
                    <p class="text-sm text-gray-500">Ngày Nhập: <span class="font-semibold text-gray-800"><?= Yii::$app->formatter->asRelativeTime($model->created_at) ?> (<?= Yii::$app->formatter->asDate($model->created_at, 'php:d-m-Y') ?>)</span></p>
                </div>
                <div class="flex items-center space-x-2">
                    <img src="https://placehold.co/40x40/f0f0f0/555555?text=Logo" alt="Người Nhập Logo" class="w-10 h-10 rounded-full">
                    <div>
                        <p class="text-sm text-gray-500">Người Nhập:</p>
                        <p class="font-semibold text-gray-800">Admin <i class="fas fa-info-circle text-gray-400 text-xs"></i></p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md border-orange-600-custom">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-2">
                        <span class="text-lg font-bold text-orange-600"><?= Html::encode($model->listingType->name ?? '') ?></span>
                        <?php if ($model->transactionStatus && $model->transactionStatus->transaction_status_id !== 0): ?>
                            <span class="px-2 py-1 text-xs font-medium rounded-full <?= Html::encode($model->transactionStatus->class_css) ?>">
                                <?= Html::encode($model->transactionStatus->status_name) ?>
                            </span>
                        <?php endif; ?>
                    </div>
                    <img src="https://placehold.co/24x24/transparent/000000?text=🌍" alt="World Map Icon" class="w-6 h-6">
                </div>
                <p class="text-xl font-bold text-gray-800 mb-2"><?= Html::encode($model->title) ?></p>
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <?php
                        $totalPrice = $model->price; 
                        $totalArea = $model->area_total;
                        $pricePerSqM_Text = '';

                        if ($totalArea > 0 && $totalPrice > 0) {
                            $pricePerSqM_VND = $totalPrice / $totalArea;
                            $pricePerSqM_Text = formatPriceUnit($pricePerSqM_VND);
                        }
                    ?>

                    <div>
                        <p class="text-sm text-gray-500">Mức giá</p>
                        <p class="text-lg font-bold text-gray-800">
                            <?= formatPriceUnit($model->price) ?>
                        </p>
                        <p class="text-xs text-gray-500">
                            ~ <?= $pricePerSqM_Text ?>/m²
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Diện tích</p>
                        <p class="text-lg font-bold text-gray-800">
                            <?= formatNumber($model->area_total) ?> m²
                        </p>
                        <p class="text-xs text-gray-500">
                            (<?= formatNumber($model->area_length) ?>m × <?= formatNumber($model->area_width) ?>m)
                        </p>
                    </div>
                </div>
                
                <div class="space-y-2">
                    <?php foreach ($model->ownerContacts as $contact): ?>
                        <?php
                        if ($contact->gender_id == 2) {
                            $iconClass = 'fas fa-venus text-pink-500';
                        } else {
                            $iconClass = 'fas fa-mars text-blue-600';
                        }
                        ?>
                        
                        <div class="flex items-center font-medium">
                            <i class="<?= $iconClass ?> mr-2 w-4 text-center"></i> <span class="text-gray-800">
                                <?= Html::encode($contact->contact_name) ?> • 
                                ••••••.<?= substr($contact->phone_number, -3) ?>
                            </span>
                            <span class="ml-2 px-2 py-1 bg-blue-100 text-blue-700 text-xs rounded-full"><?= Html::encode($contact->role->name ?? 'Chủ nhà') ?></span>
                        </div>

                    <?php endforeach; ?>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md">
                <nav class="flex space-x-4 mb-4">
                    <button class="tab-sub-button px-4 py-2 text-sm font-medium rounded-full bg-orange-100 text-orange-700" data-target="vi-tri-mat-tien">Vị Trí <?= Html::encode($model->locationTypes->type_name ?? '') ?></button>
                    <?php
                        $assetTypeName = 'chưa có thông tin';
                        if ($model->assetType && $model->assetType->asset_type_id !== 0) {
                            $assetTypeName = $model->assetType->type_name;
                        }
                    ?>

                    <button class="tab-sub-button px-4 py-2 text-sm font-medium rounded-full bg-gray-100 text-gray-700 hover:bg-gray-200" data-target="loai-tai-san-ca-nhan">
                        Loại Tài Sản <?= Html::encode($assetTypeName) ?>
                    </button>
                </nav>

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

                <div id="loai-tai-san-ca-nhan" class="tab-sub-content hidden space-y-4">
                    <p class="text-gray-700">Thông tin chi tiết về loại tài sản cá nhân sẽ được hiển thị tại đây.</p>
                </div>
            </div>
        </div>

        <div class="lg:col-span-1 space-y-6">

            <?php foreach ($modelActivityLogs as $log): ?>
                <div class="bg-white p-6 rounded-lg shadow-md space-y-2">
                    <p class="text-sm text-gray-500">
                        <span class="font-medium text-gray-800">
                            <?= $log->user ? Html::encode($log->user->username) : 'Hệ thống' ?>
                        </span>
                        <span class="text-gray-400 mx-1">•</span>
                        <span><?= Yii::$app->formatter->asRelativeTime($log->created_at) ?></span>
                    </p>

                    <?php if (!empty($log->details)): ?>
                        <p class="text-gray-700">
                            <?= nl2br(Html::encode($log->details)) ?>
                        </p>
                    <?php endif; ?>

                </div>
            <?php endforeach; ?>

        </div>
    </div>

    <div id="lich-su-content" class="tab-content hidden bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Lịch sử tương tác</h2>
        <p class="text-gray-600">Nội dung lịch sử tương tác sẽ được hiển thị tại đây.</p>
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

    function activateMainTab(tabButton, contentDiv) {
        document.querySelectorAll('.tab-content').forEach(content => content.classList.add('hidden'));
        document.querySelectorAll('header nav button').forEach(button => {
            button.classList.remove('text-orange-600', 'border-orange-600');
            button.classList.add('text-gray-600', 'hover:text-orange-600', 'hover:border-orange-600');
        });

        tabButton.classList.add('text-orange-600', 'border-b-2', 'border-orange-600');
        tabButton.classList.remove('text-gray-600', 'hover:text-orange-600', 'hover:border-orange-600');
        contentDiv.classList.remove('hidden');
    }

    function activateSubTab(tabButton) {
        tabButton.closest('nav').nextElementSibling.querySelectorAll('.tab-sub-content').forEach(content => {
            content.classList.add('hidden');
        });

        tabButton.closest('nav').querySelectorAll('.tab-sub-button').forEach(button => {
            button.classList.remove('bg-orange-100', 'text-orange-700');
            button.classList.add('bg-gray-100', 'text-gray-700', 'hover:bg-gray-200');
        });

        tabButton.classList.add('bg-orange-100', 'text-orange-700');
        tabButton.classList.remove('bg-gray-100', 'text-gray-700', 'hover:bg-gray-200');
        document.getElementById(tabButton.dataset.target).classList.remove('hidden');
    }

    thongTinTab.addEventListener('click', function() {
        activateMainTab(thongTinTab, thongTinContent);
    });

    lichSuTab.addEventListener('click', function() {
        activateMainTab(lichSuTab, lichSuContent);
    });

    subTabButtons.forEach(button => {
        button.addEventListener('click', function() {
            activateSubTab(this);
        });
    });

    activateMainTab(thongTinTab, thongTinContent);

    document.querySelectorAll('.tab-sub-button[data-target="vi-tri-mat-tien"]').forEach(button => {
        activateSubTab(button);
    });
    document.querySelectorAll('.tab-sub-button[data-target="vi-tri-mat-tien-2"]').forEach(button => {
        activateSubTab(button);
    });
});
</script>
