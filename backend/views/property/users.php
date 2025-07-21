<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\widgets\LinkPager;

$this->title = "Quản Lý Người Dùng - Thống Kê Bài Đăng";
?>

<header class="bg-white shadow-md p-2 flex items-center justify-between rounded-bl-lg">
    <div class="text-lg font-semibold text-gray-800"><?= Html::encode($this->title) ?></div>
    <div class="relative flex items-center space-x-4">
        <button id="userMenuButton" class="w-10 h-10 bg-blue-500 hover:bg-blue-600 text-white rounded-full flex items-center justify-center shadow-md transition-colors duration-200">
            <i class="fas fa-user"></i>
        </button>
        <div id="userMenu" class="absolute right-0 mt-20 w-48 bg-white border border-gray-200 rounded-md shadow-lg py-1 z-10 hidden">
            <?= Html::a('Phiên Đăng Nhập', ['/login-version'], ['class' => 'block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100']) ?>
            <?= Html::a('Đổi Mật Khẩu', ['/change-password'], ['class' => 'block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100']) ?>
            <?= Html::a('Đăng Xuất', ['/site/logout'], ['data-method' => 'post', 'class' => 'block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100']) ?>
        </div>
    </div>
</header>

<main class="flex-1 p-6 overflow-auto">
    <div class="bg-white p-6 rounded-lg shadow-md mb-6">
    <?php $form = ActiveForm::begin(['method' => 'get']); ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-4 gap-4 mb-4">
            <?= $form->field($searchModel, 'username')->textInput(['placeholder' => 'Tên Người Dùng', 'class' => 'form-input border border-gray-300 rounded-lg p-2 focus:ring-blue-500 focus:border-blue-500'])->label(false) ?>
            <div class="relative">
                <?= $form->field($searchModel, 'start_date')
                    ->widget(\yii\jui\DatePicker::class, [
                        'dateFormat' => 'yyyy-MM-dd',
                        'options' => [
                            'class' => 'form-control',
                            'placeholder' => 'Ngày Bắt Đầu'
                        ],
                        'clientOptions' => [
                            'changeMonth' => true,
                            'changeYear' => true,
                            'showButtonPanel' => true,
                            'yearRange' => '1900:2099',
                        ],
                    ])->label(false) ?>
               
                <i class="fas fa-calendar-alt absolute right-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
            </div>
            <div class="relative">
                <?= $form->field($searchModel, 'end_date')
                    ->widget(\yii\jui\DatePicker::class, [
                        'dateFormat' => 'yyyy-MM-dd',
                        'options' => [
                            'class' => 'form-control',
                            'placeholder' => 'Ngày Kết Thúc'
                        ],
                        'clientOptions' => [
                            'changeMonth' => true,
                            'changeYear' => true,
                            'showButtonPanel' => true,
                            'yearRange' => '1900:2099',
                        ],
                    ])->label(false) ?>
               
                <i class="fas fa-calendar-alt absolute right-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
            </div>
            <div class="flex space-x-2">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow-md flex items-center justify-center transition-colors duration-200">
                    <i class="fas fa-search mr-2"></i> TÌM
                </button>
                <button type="reset" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg shadow-md flex items-center justify-center transition-colors duration-200">
                    <i class="fas fa-sync-alt"></i>
                </button>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md overflow-x-auto">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'layout' => "{items}\n",
            'summaryOptions' => [
                'class' => 'text-sm text-gray-700',
                'id' => 'DataTables_Table_0_info',
            ],
            'summary' => 'Hiển thị từ {begin} đến {end} trong tổng số {totalCount} mục',
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute' => 'username',
                    'label' => 'Tên Tài Khoản',
                ],
                [
                    'attribute' => 'full_name',
                    'label' => 'Tên Người Dùng',
                ],
                [
                    'attribute' => 'email',
                    'label' => 'Email',
                ],
                [
                    'attribute' => 'property_count',
                    'label' => 'Số Bài Đăng',
                    'value' => function ($model) {
                        return $model->property_count;
                    },
                ],
            ],
        ]) ?>
        <?= LinkPager::widget(['pagination' => $dataProvider->pagination]) ?>
    </div>
</main>

<script>
    document.getElementById('userMenuButton').addEventListener('click', function () {
        document.getElementById('userMenu').classList.toggle('hidden');
    });
</script>