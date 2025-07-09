<?php

/** @var yii\web\View $this */
use yii\bootstrap5\Html;
$this->title = 'Bản Đồ Quy Hoạch TP.HCM';
?> 
<!-- Header -->
<header class="bg-white shadow-md p-2 flex items-center justify-between rounded-bl-lg">
    <div class="text-lg font-semibold text-gray-800">Bản Đồ Quy Hoạch TP.HCM'</div>
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
<style>
.map-container {
    position: relative;
    width: 100%;
    height: 95vh; /* Or a fixed height like 800px */
    overflow: hidden;
}

iframe {
    width: 100%;
    height: 100%;
    border: 0;
    display: block;
}

.logo-overlay {
    position: absolute;
    top: 2%;      
    left: 40%;      
    transform: translate(-50%, -50%); 
    z-index: 10;
    width: 129px;
    height: 50px; 
    background-color: white ;
    display: flex;
    justify-content: center; 
    align-items: center;
    border-radius: 8px;
}

.logo-overlay img {
    max-width: 90%; 
    max-height: 90%;
    object-fit: contain; 
}
</style>

<div class="map-container">
    <div class="logo-overlay">
        <img src="<?= Yii::$app->request->baseUrl ?>/img/logo.png" alt="King Land">
    </div>
    <iframe
        src="https://appquyhoach.com/soi-quy-hoach/tp-ho-chi-minh"
        width="100%"
        height="100%"
        frameborder="0"
        allowfullscreen>
    </iframe>
</div>