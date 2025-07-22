<?php

/** @var \yii\web\View $this */
/** @var string $content */

use yii\bootstrap5\Nav;
use yii\bootstrap5\Html;
use yii\bootstrap5\NavBar;
use backend\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="flex min-h-screen bg-gray-100">
<?php $this->beginBody() ?>

    <aside class="flex flex-col items-start py-4">
        <div class="mb-8 px-3">
            <div class="h-10 w-10 rounded-lg flex items-center justify-center text-white text-xl font-bold overflow-hidden">
            <img src="<?= Yii::$app->request->baseUrl ?>/img/logo.png" alt="King Land" class="h-full w-full object-contain">
            </div>
        </div>
        <nav class="flex flex-col space-y-2 w-full">
            <a href="<?= Yii::$app->homeUrl ?>" class="nav-item <?= Yii::$app->request->pathInfo === '' ? 'bg-blue-100 text-blue-600' : '' ?>" aria-label="Màn hình chính">
                <i class="fas fa-home text-xl"></i>
                <span>Màn hình chính</span>
            </a>
            <a href="<?= \yii\helpers\Url::to(['/news']) ?>" class="nav-item <?= Yii::$app->controller->action->id === 'post' ? 'bg-blue-100 text-blue-600' : '' ?>" aria-label="Bản tin nội bộ">
                <i class="fas fa-newspaper text-xl"></i>
                <span>Bản tin nội bộ</span>
            </a>
            <a href="<?= \yii\helpers\Url::to(['/property']) ?>" class="nav-item <?= Yii::$app->controller->action->id === 'index' ? 'bg-blue-100 text-blue-600' : '' ?>" aria-label="Dữ liệu Nhà Đất">
                <i class="fas fa-database text-xl"></i>
                <span>Dữ liệu Nhà Đất</span>
            </a>
            <a href="<?= \yii\helpers\Url::to(['/property/my-favorites']) ?>" class="nav-item <?= Yii::$app->controller->action->id === 'my-favorites' ? 'bg-blue-100 text-blue-600' : '' ?>" aria-label="My Favorites">
                <i class="fas fa-heart text-xl"></i>
                <span>BĐS Yêu Thích</span>
            </a>
            <a href="<?= \yii\helpers\Url::to(['/ban-do-quy-hoach']) ?>" class="nav-item <?= Yii::$app->controller->action->id === 'map' ? 'bg-blue-100 text-blue-600' : '' ?>" aria-label="BĐ Quy Hoạch">
                <i class="fas fa-map text-xl"></i>
                <span>BĐ Quy Hoạch</span>
            </a>
            <?php if (!Yii::$app->user->isGuest && in_array(Yii::$app->user->identity->jobTitle->role_code, ['manager', 'super_admin'])): ?>
                <a href="<?= \yii\helpers\Url::to(['/property/users']) ?>" class="nav-item <?= Yii::$app->controller->action->id === 'users' ? 'bg-blue-100 text-blue-600' : '' ?>" aria-label="Quản Lý Nhân Viên">
                    <i class="fas fa-users text-xl"></i>
                    <span>Quản Lý Nhân Viên</span>
                </a>
            <?php endif; ?>
            
        </nav>
    </aside>

    <div class="flex-1 flex flex-col">
        <?= $content ?>
    </div>
    <script>
    const userMenuButton = document.getElementById('userMenuButton');
    const userMenu = document.getElementById('userMenu');
    let timeoutId;

    userMenuButton.addEventListener('mouseenter', () => {
        clearTimeout(timeoutId);
        userMenu.classList.remove('hidden');
        userMenuButton.setAttribute('aria-expanded', 'true');
    });

    userMenuButton.addEventListener('mouseleave', () => {
        timeoutId = setTimeout(() => {
            userMenu.classList.add('hidden');
            userMenuButton.setAttribute('aria-expanded', 'false');
        }, 300);
    });

    userMenu.addEventListener('mouseenter', () => {
        clearTimeout(timeoutId);
    });

    userMenu.addEventListener('mouseleave', () => {
        timeoutId = setTimeout(() => {
            userMenu.classList.add('hidden');
            userMenuButton.setAttribute('aria-expanded', 'false');
        }, 300);
    });
</script>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage();
