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

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'property_id' => $model->property_id]);
        }

        return $this->render('update', [
            'model' => $model,
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




}
