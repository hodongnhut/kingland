<?php

namespace backend\controllers\api;

use yii\rest\Controller;
use Yii;
use common\models\PropertyImages;
use common\models\Properties;
use common\models\OwnerContacts;
use yii\helpers\FileHelper;

class PostController extends Controller
{
    public $enableCsrfValidation = false;

    protected function verbs()
    {
        return [
            'create' => ['POST'],
            'create-property' => ['POST'],
            'view-property' => ['GET'],
            'update-property' => ['PUT', 'PATCH'],
            'add-owner-contact' => ['POST']
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

    public function actionViewProperty($external_id)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $property = Properties::find()
        ->where(['external_id' => $external_id])
        ->with([
            'propertyImages',
            'advantages',
            'disadvantages',
            'rentalContract',
            'interiors',
            'ownerContacts',
        ])
        ->asArray()
        ->one();

        if ($property !== null) {
            return [
                'success' => true,
                'data' => $property,
            ];
        } else {
            Yii::$app->response->statusCode = 404;
            return [
                'success' => false,
                'message' => 'Property not found.',
            ];
        }
    }
    public function actionCreateProperty()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $params = Yii::$app->getRequest()->getBodyParams();

        $transaction = Yii::$app->db->beginTransaction();

        try {
            $model = new Properties();
            $model->load($params, '');

            if (!$model->save()) {
                throw new \Exception('Failed to save property details.');
            }

            if (!empty($params['images']) && is_array($params['images'])) {
                foreach ($params['images'] as $imageData) {
                    $this->saveImageFromUrl($imageData['url'], $model->property_id, $imageData['is_main'] ?? 0);
                }
            }

            if (!empty($params['advantages']) && is_array($params['advantages'])) {
                foreach ($params['advantages'] as $advantageId) {
                    $advantage = \common\models\Advantages::findOne($advantageId);
                    if ($advantage) {
                        $model->link('advantages', $advantage);
                    }
                }
            }

            if (!empty($params['disadvantages']) && is_array($params['disadvantages'])) {
                foreach ($params['disadvantages'] as $disadvantageId) {
                    $disadvantage = \common\models\Disadvantages::findOne($disadvantageId);
                    if ($disadvantage) {
                        $model->link('disadvantages', $disadvantage);
                    }
                }
            }

            if (!empty($params['interiors']) && is_array($params['interiors'])) {
                foreach ($params['interiors'] as $interiorId) {
                    $interior = \common\models\Interiors::findOne($interiorId);
                    if ($interior) {
                        $model->link('interiors', $interior);
                    }
                }
            }

            if (!empty($params['ownerContacts']) && is_array($params['ownerContacts'])) {
                foreach ($params['ownerContacts'] as $contactData) {
                    $contactModel = new \common\models\OwnerContacts();
                    $contactModel->load($contactData, '');
                    $contactModel->property_id = $model->property_id;
                    if (!$contactModel->save()) {
                        throw new \Exception('Failed to save owner contact.');
                    }
                }
            }
            
            if (!empty($params['rental_contract']) && is_array($params['rental_contract'])) {
                $rentalContract = new \common\models\RentalContracts();
                $rentalContract->load($params['rental_contract'], '');
                $rentalContract->property_id = $model->property_id;
                if (!$rentalContract->save()) {
                    throw new \Exception('Failed to save rental contract.');
                }
            }
            $transaction->commit();
            
            return [
                'success' => true,
                'property_id' => $model->property_id,
                'message' => 'Property and all related data created successfully.'
            ];

        } catch (\Exception $e) {
            $transaction->rollBack();
            Yii::$app->response->statusCode = 422;
            return [
                'success' => false,
                'message' => $e->getMessage(),
                'errors' => $model->hasErrors() ? $model->getErrors() : null,
            ];
        }
    }
    public function actionUpdateProperty($external_id)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = Properties::findOne(['external_id' => $external_id]);

        if ($model === null) {
            Yii::$app->response->statusCode = 404;
            return [
                'success' => false,
                'message' => 'Property not found.',
            ];
        }

        $params = Yii::$app->getRequest()->getBodyParams();
        $transaction = Yii::$app->db->beginTransaction();

        try {
            $model->load($params, '');

            if (!$model->save()) {
                throw new \Exception('Failed to save property: ' . json_encode($model->getErrors()));
            }

            if (!empty($params['interior_ids']) && is_array($params['interior_ids'])) {
                \common\models\PropertyInteriors::deleteAll(['property_id' => $model->property_id]);
                foreach ($params['interior_ids'] as $id) {
                    $pi = new \common\models\PropertyInteriors();
                    $pi->property_id = $model->property_id;
                    $pi->interior_id = $id;
                    $pi->save(false);
                }
            }

            if (!empty($params['disadvantage_ids']) && is_array($params['disadvantage_ids'])) {
                \common\models\PropertyDisadvantages::deleteAll(['property_id' => $model->property_id]);
                foreach ($params['disadvantage_ids'] as $id) {
                    $pd = new \common\models\PropertyDisadvantages();
                    $pd->property_id = $model->property_id;
                    $pd->disadvantage_id = $id;
                    $pd->save(false);
                }
            }

            if (!empty($params['advantages_ids']) && is_array($params['advantages_ids'])) {
                \common\models\PropertyAdvantages::deleteAll(['property_id' => $model->property_id]);
                foreach ($params['advantages_ids'] as $id) {
                    $pa = new \common\models\PropertyAdvantages();
                    $pa->property_id = $model->property_id;
                    $pa->advantage_id = $id;
                    $pa->save(false);
                }
            }

            if (!empty($params['images']) && is_array($params['images'])) {
                foreach ($params['images'] as $imageData) {
                    $this->saveImageFromUrl(
                        $imageData['url'],
                        $model->property_id,
                        $imageData['is_main'] ?? 0
                    );
                }
            }

            $transaction->commit();

            return [
                'success' => true,
                'message' => 'Property updated successfully.',
                'data' => $model->attributes,
            ];
        } catch (\Throwable $e) {
            $transaction->rollBack();
            Yii::error("❌ Failed to update property: " . $e->getMessage(), __METHOD__);

            Yii::$app->response->statusCode = 500;
            return [
                'success' => false,
                'message' => 'Update failed.',
                'error' => $e->getMessage(),
            ];
        }
    }
    private function saveImageFromUrl($imageUrl, $propertyID, $isMain = 0)
    {
        if (empty($imageUrl) || !filter_var($imageUrl, FILTER_VALIDATE_URL)) {
            return false;
        }

        $imageData = @file_get_contents($imageUrl);
        if ($imageData === false) {
            throw new \Exception("Could not download image from URL: $imageUrl");
        }

        $originalFileName = basename(parse_url($imageUrl, PHP_URL_PATH));
        $extension = pathinfo($originalFileName, PATHINFO_EXTENSION) ?: 'jpg';

        $directoryPath = Yii::getAlias('@webroot/uploads/properties/') . $propertyID;
        FileHelper::createDirectory($directoryPath);

        $filePath = $directoryPath . '/' . $originalFileName;

        if (file_exists($filePath)) {
            $nameOnly = pathinfo($originalFileName, PATHINFO_FILENAME); // không lấy đuôi
            $uniqueName = $nameOnly . '_' . time() . '_' . uniqid() . '.' . $extension;
            $filePath = $directoryPath . '/' . $uniqueName;
            $finalFileName = $uniqueName;
        } else {
            $finalFileName = $originalFileName;
        }

        if (file_put_contents($filePath, $imageData)) {
            $imageModel = new PropertyImages();
            $imageModel->property_id = $propertyID;
            $imageModel->image_path = '/uploads/properties/' . $propertyID . '/' . $finalFileName;
            $imageModel->is_main = $isMain;
            if (!$imageModel->save()) {
                throw new \Exception('Failed to save image record to database.');
            }
            return true;
        }

        return false;
    }

    public function actionAddOwnerContact($property_id)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $property = Properties::findOne($property_id);
        if ($property === null) {
            Yii::$app->response->statusCode = 404;
            return ['success' => false, 'message' => 'Property not found.'];
        }

        $contacts = Yii::$app->request->getBodyParam('contacts');

        if (!is_array($contacts) || empty($contacts)) {
            Yii::$app->response->statusCode = 400;
            return ['success' => false, 'message' => 'Input "contacts" must be a non-empty array.'];
        }

        $successfulCreations = [];
        $failedCreations = [];

        foreach ($contacts as $contact) {
            $phoneNumber = $contact['phone_number'] ?? null;

            if (empty($phoneNumber)) {
                $failedCreations[] = [
                    'contact' => $contact,
                    'error' => 'Missing phone_number.'
                ];
                continue;
            }

            $isDuplicate = OwnerContacts::find()
                ->where(['property_id' => $property_id, 'phone_number' => $phoneNumber])
                ->exists();

            if ($isDuplicate) {
                $failedCreations[] = [
                    'phone_number' => $phoneNumber,
                    'error' => 'Số điện thoại đã tồn tại cho bất động sản này.'
                ];
                continue;
            }

            $model = new OwnerContacts();
            $model->property_id = $property_id;
            $model->phone_number = $phoneNumber;
            $model->contact_name = $contact['contact_name'] ?? null;
            $model->role_id = $contact['role_id'] ?? null;
            $model->gender_id = $contact['gender_id'] ?? null;

            if ($model->save()) {
                $successfulCreations[] = $model->attributes;
            } else {
                $failedCreations[] = [
                    'contact' => $contact,
                    'errors' => $model->getErrors()
                ];
            }
        }

        return [
            'success' => true,
            'message' => 'Batch contact processing completed.',
            'data' => [
                'successful_creations' => $successfulCreations,
                'failed_creations' => $failedCreations
            ]
        ];
    }
    
}