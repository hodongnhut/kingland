<?php
use yii\helpers\Json;
?>
<div class="interaction-history-container hover-effect mb-4">
<div class="interaction-history-container">
    <div class="overlay-frame"></div>
    <div class="content-wrapper">
        <?php foreach ($modelLog as $log): ?>
            <?=  Json::decode($log->rendered_html_content) ?>
        <?php endforeach; ?>
    </div>
</div>