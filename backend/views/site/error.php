<?php

/** @var yii\web\View $this */
/** @var string $name */
/** @var string $message */
/** @var Exception $exception */

use yii\helpers\Html;

$this->title = $name;


?>
<div class="flex items-center justify-center min-h-screen bg-gray-100 font-sans">
    <div class="bg-white p-8 rounded-lg shadow-xl max-w-lg w-full text-center">
        <h1 class="text-4xl font-extrabold text-red-600 mb-4 rounded-md"><?= Html::encode($this->title) ?></h1>

        <div class="alert alert-danger bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6">
            <p class="text-lg font-medium"><?= nl2br(Html::encode($message)) ?></p>
        </div>

        <p class="text-gray-700 text-base mb-6">
            The above error occurred while the Web server was processing your request.
        </p>
        <p class="text-gray-700 text-base">
            Please contact us if you think this is a server error. Thank you.
        </p>
        <div class="mt-8">
            <a href="<?= Yii::$app->homeUrl ?>" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-md shadow-lg transition duration-300 ease-in-out transform hover:scale-105">
                Trang
            </a>
        </div>
    </div>
</div>