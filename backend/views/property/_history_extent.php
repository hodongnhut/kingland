<?php
use yii\helpers\Json;
?>
<div class="interaction-history-container ">
        <div class="PropertyRightView jPropertyRightView">
        <div class="TabInfo HasHistory jPropertyInfo">
            <section class="PropertyHistoryList jPropertyHistoryList" data-propertyid="whgwyI1nXXPy8uM4zPjdGwtcd2duabng">

            <div class="GridList">
                <?php foreach ($modelLog as $log): ?>
                        <?=  $log->body_html ?>
                    <?php endforeach; ?>
                </div>
            </section>
        </div>
    </div>
</div>