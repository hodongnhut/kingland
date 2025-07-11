<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use common\models\Districts;
use common\models\Provinces;
use common\models\Advantages;
use common\models\AssetTypes;
use common\models\Directions;
use common\models\Properties;
use common\models\ListingTypes;
use common\models\Disadvantages;
use common\models\LocationTypes;
use common\models\PropertyTypes;
use common\models\PropertiesFrom;
use yii\web\NotFoundHttpException;
use common\models\PropertiesSearch;
use yii\filters\AccessControl; 
use common\models\PropertyInteriors;
use common\models\PropertyAdvantages;
use common\models\PropertyDisadvantages;
use common\models\OwnerContactSearch;
use yii\web\UploadedFile;
use common\models\PropertyImages;

class PropertyController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'], 
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $model = new PropertiesFrom();
        $model->provinces = 50;
        $searchModel = new PropertiesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'modelPropertyTypes' => PropertyTypes::find()->all(),
            'modelListingTypes' => ListingTypes::find()->all(),
            'modelLocationTypes' => LocationTypes::find()->all(),
            'modelAssetTypes' => AssetTypes::find()->all(),
            'modelAdvantages' => Advantages::find()->all(),
            'modelDisadvantages' => Disadvantages::find()->all(),
            'modelDirections' => Directions::find()->all(),
            'dataProvider' => $dataProvider,
            'model' => $model,
            'modelProvinces' => Provinces::find()->all(),
            'modelDistricts' => Districts::find()->where(['ProvinceId' => 50])->all()
        ]);
    }

     /**
     * Displays a single Properties model.
     * @param int $property_id Property ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($property_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($property_id),
        ]);
    }

    /**
     * Creates a new Properties model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new PropertiesFrom();


        if ($this->request->isPost) {
            $property = $model->load($this->request->post()) ? $model->save() : null;
            if ($property !== null) {
                return $this->redirect(['update', 'property_id' => $property->property_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Properties model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $property_id Property ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($property_id)
    {
        $model = $this->findModel($property_id);
        $searchModel = new OwnerContactSearch();
        $searchModel->property_id = $property_id;
        $dataProvider = $searchModel->search($this->request->queryParams);
        
        if ($this->request->isPost && $model->load($this->request->post())) {
            if ($model->validate()) {
                if ($model->save(false)) { 
                    if ($model->listing_types_id === 2) {
                        $interiorIds = Yii::$app->request->post('interiors', []);
                        PropertyInteriors::deleteAll(['property_id' => $model->property_id]);
                        foreach ($interiorIds as $interiorId) {
                            $relation = new PropertyInteriors();
                            $relation->property_id = $model->property_id;
                            $relation->interior_id = $interiorId;
                            $relation->save();
                        }
                    }
                    $advantagesIds = Yii::$app->request->post('advantages', []);
                    PropertyAdvantages::deleteAll(['property_id' => $model->property_id]);
                    foreach ($advantagesIds as $antageseriorId) { 
                        $antageserior = new PropertyAdvantages();
                        $antageserior->property_id = $model->property_id;
                        $antageserior->advantage_id = $antageseriorId;
                        $antageserior->save();
                    }

                    $disadvantagesIds = Yii::$app->request->post('disadvantages', []);
                    PropertyDisadvantages::deleteAll(['property_id' => $model->property_id]);
                    foreach ($disadvantagesIds as $disadvantageId) { 
                        $disadvantages = new PropertyDisadvantages();
                        $disadvantages->property_id = $model->property_id;
                        $disadvantages->disadvantage_id = $disadvantageId;
                        $disadvantages->save();
                    }
                    
                    Yii::$app->session->setFlash('success', 'Cập nhật bất động sản thành công.');
                    return $this->redirect(['update', 'property_id' => $model->property_id]);
                } else {
                    Yii::$app->session->setFlash('error', 'Không thể lưu bất động sản. Vui lòng thử lại.');
                }
            } else {
                $errors = $model->getErrors();
                $errorMessages = [];
                foreach ($errors as $attribute => $errorList) {
                    foreach ($errorList as $error) {
                        $errorMessages[] = $error;
                    }
                }
                Yii::$app->session->setFlash('error', 'Có lỗi trong dữ liệu nhập: ' . implode(', ', $errorMessages));
            }
        }

        return $this->render('update', [
            'model' => $model,
            'modelProvinces' => Provinces::find()->all(),
            'modelDistricts' => Districts::find()->where(['ProvinceId' => 50])->all(),
            'modelPropertyTypes' => PropertyTypes::find()->all(),
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Deletes an existing Properties model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $property_id Property ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($property_id)
    {
        $this->findModel($property_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Properties model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $property_id Property ID
     * @return Properties the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($property_id)
    {
        if (($model = Properties::findOne(['property_id' => $property_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    /**
     * Uploads images via AJAX.
     * @return array JSON response
     */
    public function actionUploadImage()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $response = ['success' => false, 'message' => '', 'images' => []];

        $files = UploadedFile::getInstancesByName('files');
        $type = Yii::$app->request->post('type');
        $propertyId = Yii::$app->request->post('property_id', 0);

        if (empty($files)) {
            $response['message'] = 'Vui lòng chọn ít nhất một file để tải lên.';
            return $response;
        }

        if ($propertyId == 0) {
            $response['message'] = 'ID bất động sản không hợp lệ.';
            return $response;
        }

        $sortOrder = PropertyImages::find()->where(['property_id' => $propertyId])->max('sort_order') + 1;

        foreach ($files as $file) {
            $allowedExtensions = ['pdf', 'jpg', 'png', 'jpeg', 'webp', 'heic'];
            if (!in_array(strtolower($file->extension), $allowedExtensions)) {
                $response['message'] = 'Định dạng file không hợp lệ: ' . $file->name;
                return $response;
            }

            $imageModel = new PropertyImages();
            $imageModel->property_id = $propertyId;
            $imageModel->image_path = '/uploads/properties/' . time() . '_' . uniqid() . '.' . $file->extension;
            $imageModel->is_main = 0;
            $imageModel->sort_order = $sortOrder++;

            $filePath = Yii::getAlias('@webroot') . $imageModel->image_path;
            if ($file->saveAs($filePath)) {
                if ($imageModel->save()) {
                    $response['images'][] = [
                        'id' => $imageModel->image_id,
                        'url' => Yii::$app->urlManager->createAbsoluteUrl($imageModel->image_path),
                        'name' => $file->name
                    ];
                } else {
                    $response['message'] = 'Không thể lưu thông tin hình ảnh vào cơ sở dữ liệu: ' . implode(', ', $imageModel->getErrorSummary(true));
                    return $response;
                }
            } else {
                $response['message'] = 'Không thể lưu file: ' . $file->name;
                return $response;
            }
        }

        $response['success'] = true;
        $response['message'] = 'Tải lên thành công';
        return $response;
    }

    /**
     * Deletes an image via AJAX.
     * @return array JSON response
     */
    public function actionDeleteImage()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $response = ['success' => false, 'message' => ''];

        $imageId = Yii::$app->request->post('image_id');
        $image = PropertyImages::findOne($imageId);

        if (!$image) {
            $response['message'] = 'Hình ảnh không tồn tại.';
            return $response;
        }

        $filePath = Yii::getAlias('@webroot') . $image->image_path;
        if (file_exists($filePath) && unlink($filePath)) {
            if ($image->delete()) {
                $otherImage = PropertyImages::find()
                    ->where(['property_id' => $image->property_id])
                    ->andWhere(['!=', 'image_id', $imageId])
                    ->orderBy(['sort_order' => SORT_ASC])
                    ->one();
                if ($otherImage && $image->is_main) {
                    $otherImage->is_main = 1;
                    $otherImage->save();
                }
                $response['success'] = true;
                $response['message'] = 'Xóa hình ảnh thành công.';
            } else {
                $response['message'] = 'Không thể xóa thông tin hình ảnh khỏi cơ sở dữ liệu.';
            }
        } else {
            $response['message'] = 'Không thể xóa file hình ảnh.';
        }

        return $response;
    }

}
