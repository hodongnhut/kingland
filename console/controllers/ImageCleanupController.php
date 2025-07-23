<?php

namespace console\controllers;

use yii\console\Controller;
use yii\helpers\Console;
use common\models\PropertyImages;

class ImageCleanupController extends Controller
{
    /**
     * This command will check all image paths in property_images table,
     * and delete the row if the image file does not exist.
     */
    public function actionCheckAndClean()
    {
        $images = PropertyImages::find()->all();
        $deletedCount = 0;

        foreach ($images as $image) {
            $fullPath = \Yii::getAlias('@backend/web/' . $image->image_path);

            if (!file_exists($fullPath)) {
                Console::output("Deleting record ID {$image->image_id} — file not found: {$fullPath}");
                $image->delete();
                $deletedCount++;
            }
        }

        Console::output("✅ Cleanup complete. Deleted $deletedCount records.");
    }
}
