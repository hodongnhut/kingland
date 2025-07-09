<?php

/** @var yii\web\View $this */

$this->title = 'Bản Đồ Quy Hoạch TP.HCM';
?> 

<style>
.map-container {
    position: relative;
    width: 100%;
    height: 100vh; /* Or a fixed height like 800px */
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