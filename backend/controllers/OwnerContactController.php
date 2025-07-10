<?php

namespace backend\controllers;

use Yii;
use common\models\OwnerContacts;
use common\models\OwnerContactSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * OwnerContactController implements the CRUD actions for OwnerContacts model.
 */
class OwnerContactController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all OwnerContacts models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new OwnerContactSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreateAjax()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $data = json_decode(file_get_contents('php://input'), true);

        if (!$data || !isset($data['role'])) {
            return ['success' => false, 'message' => 'Dữ liệu gửi lên không hợp lệ.'];
        }


        $model = new OwnerContacts();
        $model->role_id = (int)$data['role'];
        $model->contact_name = $data['name'];
        $model->phone_number = $data['phone'];
        $model->gender_id = (int)$data['gender'];
        $model->property_id = $data['propertyId'];

        if ($model->save()) {
            return ['success' => true];
        }

        return ['success' => false, 'errors' => $model->errors];
    }

    /**
     * Displays a single OwnerContacts model.
     * @param int $contact_id Contact ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($contact_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($contact_id),
        ]);
    }

    /**
     * Creates a new OwnerContacts model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new OwnerContacts();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'contact_id' => $model->contact_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing OwnerContacts model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $contact_id Contact ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($contact_id)
    {
        $model = $this->findModel($contact_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'contact_id' => $model->contact_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing OwnerContacts model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $contact_id Contact ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($contact_id)
    {
        $this->findModel($contact_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the OwnerContacts model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $contact_id Contact ID
     * @return OwnerContacts the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($contact_id)
    {
        if (($model = OwnerContacts::findOne(['contact_id' => $contact_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
