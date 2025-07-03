<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\UserLocationSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = "Danh sách thiết bị";
$this->params['breadcrumbs'][] = $this->title;
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
<main class="flex-1 p-6 overflow-auto">
    <div class="bg-white p-6 rounded-lg shadow-md mb-6">
        <p class="text-sm text-gray-500 mb-2">Màn hình chính / Xem Danh sách thiết bị</p>
        <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-4 sm:mb-0">Danh sách thiết bị</h2>
        </div>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            [
                'attribute' => 'id',
                'header' => 'ID',
                'headerOptions' => ['class' => 'px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider'],
                'contentOptions' => ['class' => 'px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900'],
                'visible' => false, // Ẩn cột ID nếu không cần thiết
            ],
            [
                'attribute' => 'user_id',
                'header' => 'User ID',
                'headerOptions' => ['class' => 'px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider'],
                'contentOptions' => ['class' => 'px-6 py-4 whitespace-nowrap text-sm text-gray-900'],
                'visible' => false, // Ẩn nếu không cần hiển thị
            ],
            [
                'attribute' => 'device_type',
                'header' => 'Thiết bị',
                'headerOptions' => ['class' => 'px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider'],
                'contentOptions' => ['class' => 'px-6 py-4 whitespace-nowrap text-sm text-gray-900'],
                'value' => function ($model) {
                    $deviceInfo = Html::tag('div', Html::encode($model->device_type ?: 'N/A'), ['class' => 'font-semibold']);
                    $deviceInfo .= Html::tag('div', Html::encode($model->os ?: 'N/A'), ['class' => 'text-xs text-gray-600']);
                    $deviceInfo .= Html::tag('div', Html::encode($model->device_unique_id ?: 'N/A'), ['class' => 'text-xs text-gray-600']);
                    $deviceInfo .= Html::tag('div', 'Thiết bị hiện tại', ['class' => 'text-blue-600 text-xs font-semibold mt-1']);
                    return $deviceInfo;
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'browser',
                'header' => 'Phương thức',
                'headerOptions' => ['class' => 'px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider'],
                'contentOptions' => ['class' => 'px-6 py-4 whitespace-nowrap text-sm text-gray-900'],
                'value' => function ($model) {
                    return Html::encode($model->browser ?: 'N/A');
                },
            ],
            [
                'attribute' => 'created_at',
                'header' => 'Hoạt động gần nhất',
                'headerOptions' => ['class' => 'px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider'],
                'contentOptions' => ['class' => 'px-6 py-4 whitespace-nowrap text-sm text-gray-900'],
                'value' => function ($model) {
                    $timeAgo = Yii::$app->formatter->asRelativeTime(strtotime($model->created_at));
                    return Html::encode($timeAgo ?: 'N/A');
                },
            ],
            [
                'header' => 'Thao tác gần nhất',
                'headerOptions' => ['class' => 'px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider'],
                'contentOptions' => ['class' => 'px-6 py-4 whitespace-nowrap text-sm text-gray-900'],
                'value' => function ($model) {
                    // Giả định thao tác gần nhất là "Đăng Nhập" nếu là bản ghi mới nhất
                    $action = 'Đăng Nhập';
                    $badgeClass = 'bg-blue-100 text-blue-800';
                    if ($model->created_at && strtotime($model->created_at) < strtotime('-1 day')) {
                        $action = 'Xem';
                        $badgeClass = 'bg-green-100 text-green-800';
                    }
                    return Html::tag('span', $action, [
                        'class' => "$badgeClass text-xs font-medium px-2.5 py-0.5 rounded-full"
                    ]);
                },
                'format' => 'raw',
            ],
            [
                'header' => 'Đăng nhập lần đầu',
                'headerOptions' => ['class' => 'px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider'],
                'contentOptions' => ['class' => 'px-6 py-4 whitespace-nowrap text-sm text-gray-900'],
                'value' => function ($model) {
                    $firstLogin = Yii::$app->formatter->asDate(strtotime($model->created_at), 'd-M') . ' Lúc: ' . Yii::$app->formatter->asTime(strtotime($model->created_at));
                    $relativeTime = Yii::$app->formatter->asRelativeTime(strtotime($model->created_at));
                    return Html::tag('div', $relativeTime, ['class' => 'text-gray-900']) .
                        Html::tag('div', "($firstLogin)", ['class' => 'text-xs text-gray-600']);
                },
                'format' => 'raw',
            ],
            [
                'header' => 'Phiên hiện tại',
                'headerOptions' => ['class' => 'px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider'],
                'contentOptions' => ['class' => 'px-6 py-4 whitespace-nowrap text-sm text-gray-900'],
                'value' => function ($model) {
                    $action = 'Tìm';
                    return Html::tag('span', $action, [
                        'class' => 'bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full'
                    ]) . Html::tag('div', $model->session_id, ['class' => 'text-xs text-gray-600 mt-1']);
                },
                'format' => 'raw',
            ],
            [
                'header' => 'TK Đăng nhập bằng',
                'headerOptions' => ['class' => 'px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider'],
                'contentOptions' => ['class' => 'px-6 py-4 whitespace-nowrap text-sm text-gray-900'],
                'value' => function ($model) {
                    $action = 'Tìm';
                    return Html::tag('span', $action, [
                        'class' => 'bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded-full'
                    ]) . Html::tag('div', $model->user->username, ['class' => 'text-xs text-gray-600 mt-1']);
                },
                'format' => 'raw',
            ],
            [
                'header' => 'Đăng xuất',
                'headerOptions' => ['class' => 'px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider'],
                'contentOptions' => ['class' => 'px-6 py-4 whitespace-nowrap text-sm text-gray-900'],
                'value' => function ($model) {
                    return Html::a('', ['site/logout-device', 'id' => $model->id], [
                        'class' => 'text-red-600 hover:text-red-800',
                        'title' => 'Đăng xuất',
                        'data-method' => 'post',
                        'data-confirm' => 'Bạn có chắc chắn muốn đăng xuất thiết bị này?'
                    ]);
                },
                'format' => 'raw',
            ],
        ],
        'tableOptions' => ['class' => 'min-w-full divide-y divide-gray-200'],
        'headerRowOptions' => ['class' => 'bg-gray-50'],
        'rowOptions' => ['class' => 'bg-white'],
        'layout' => "{items}\n{pager}",
        'pager' => [
            'options' => ['class' => 'flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6 mt-6 rounded-lg shadow-sm'],
            'linkOptions' => ['class' => 'relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0'],
            'activePageCssClass' => 'z-10 bg-blue-600 text-white',
            'prevPageCssClass' => 'relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0',
            'nextPageCssClass' => 'relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0',
            'prevPageLabel' => '<span class="sr-only">Trước</span><i class="fas fa-chevron-left"></i>',
            'nextPageLabel' => '<span class="sr-only">Sau</span><i class="fas fa-chevron-right"></i>',
        ],
    ]);?>

</div>
</main>
