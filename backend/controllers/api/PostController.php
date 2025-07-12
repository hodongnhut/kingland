<?php

namespace backend\controllers\api;

use yii\rest\Controller;
use Yii;
use common\models\PropertyImages;
use yii\helpers\FileHelper;

class PostController extends Controller
{
    public $enableCsrfValidation = false;

    protected function verbs()
    {
        return [
            'create' => ['POST'],
        ];
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::class,
        ];
        return $behaviors;
    }

    public function actionCreate()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        $params = Yii::$app->getRequest()->getBodyParams();
        $imageUrl = $params['imageUrl'] ?? null;
        $propertyID = $params['property_id'] ?? 0;

        if (empty($imageUrl) || !filter_var($imageUrl, FILTER_VALIDATE_URL)) {
            return ['success' => false, 'message' => 'A valid imageUrl is required.'];
        }

        if ($propertyID == 0) {
            return ['success' => false, 'message' => 'A valid post_id is required.'];
        }

        $imageData = @file_get_contents($imageUrl);
        if ($imageData === false) {
            return ['success' => false, 'message' => 'Could not download the image from the provided URL.'];
        }

        $extension = pathinfo($imageUrl, PATHINFO_EXTENSION);
        $extension = strtok($extension, '?'); 
        if (empty($extension)) {
            $extension = 'jpg';
        }

        $allowedExtensions = ['pdf', 'jpg', 'png', 'jpeg', 'webp', 'heic'];
        if (!in_array(strtolower($extension), $allowedExtensions)) {
            return [
                'success' => false, 
                'message' => 'Invalid file format. Only ' . implode(', ', $allowedExtensions) . ' are allowed.'
            ];
        }

        $directoryPath = Yii::getAlias('@webroot/uploads/properties/') . $propertyID;

        FileHelper::createDirectory($directoryPath);

        $fileName = time() . '_' . uniqid() . '.' . $extension;
        $filePath = $directoryPath . '/' . $fileName;

        if (file_put_contents($filePath, $imageData)) {
            $imageModel = new PropertyImages();
            $imageModel->property_id = $propertyID;
            $imageModel->image_path = '/uploads/properties/' . $propertyID . '/' . $fileName;
            
            if ($imageModel->save()) {
                return [
                    'success' => true,
                    'message' => 'Image downloaded and saved successfully.',
                ];
            }
        }

        return ['success' => false, 'message' => 'An error occurred while saving the image.'];
    }

    public function actionListByProperty($property_id)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $images = PropertyImages::find()->where(['property_id' => $property_id])->all();

        if (empty($images)) {
            return ['success' => true, 'message' => 'No images found for this property.', 'data' => []];
        }

        $formattedImages = [];
        foreach ($images as $image) {
            $formattedImages[] = [
                'image_id' => $image->image_id,
                'url' => Yii::$app->urlManager->createAbsoluteUrl($image->image_path),
            ];
        }

        return ['success' => true, 'data' => $formattedImages];
    }
}