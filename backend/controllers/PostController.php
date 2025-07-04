<?php

namespace backend\controllers; // Or wherever your PostsController is located

use Yii;
use common\models\Posts;
use common\models\PostSearch;
use common\models\Categories;
use common\models\Attachments; // Import Attachments model
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile; // Import UploadedFile

/**
 * PostsController implements the CRUD actions for Posts model.
 */
class PostController extends Controller
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
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                        'attachments/delete' => ['POST'], // Add this for attachment deletion
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Posts models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        $categories = \yii\helpers\ArrayHelper::map(Categories::find()->all(), 'category_id', 'category_name');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'categories' => $categories,
        ]);
    }

    /**
     * Displays a single Posts model.
     * @param int $post_id Post ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($post_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($post_id),
        ]);
    }

    /**
     * Creates a new Posts model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Posts();
        $attachmentModel = new Attachments(); // Create an instance for handling uploads

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                // Get uploaded files
                $files = UploadedFile::getInstances($attachmentModel, 'file');

                if ($files) {
                    foreach ($files as $file) {
                        $newAttachment = new Attachments();
                        $newAttachment->file = $file; // Assign the UploadedFile object
                        if (!$newAttachment->upload($model->post_id)) {
                            Yii::$app->session->setFlash('error', 'Lỗi khi tải lên tệp đính kèm: ' . implode(', ', $newAttachment->getErrorSummary(true)));
                            // You might want to rollback post save here or handle it differently
                            // For simplicity, we just flash an error.
                        }
                    }
                }
                Yii::$app->session->setFlash('success', 'Bài viết đã được tạo thành công.');
                return $this->redirect(['view', 'post_id' => $model->post_id]);
            } else {
                Yii::$app->session->setFlash('error', 'Lỗi khi tạo bài viết: ' . implode(', ', $model->getErrorSummary(true)));
            }
        } else {
            $model->loadDefaultValues();
            // Set default date for new post if desired
            $model->post_date = date('Y-m-d');
            $model->is_active = true; // Set default active status
        }

        $categories = \yii\helpers\ArrayHelper::map(Categories::find()->all(), 'category_id', 'category_name');

        return $this->render('create', [
            'model' => $model,
            'categories' => $categories,
            // 'attachments' is not needed for create initially, but will be for update
        ]);
    }

    /**
     * Updates an existing Posts model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $post_id Post ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($post_id)
    {
        $model = $this->findModel($post_id);
        $attachmentModel = new Attachments(); // Create an instance for handling uploads

        // Eager load attachments for display in the form
        $model->attachments; // This loads the attachments via the relation

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                $files = UploadedFile::getInstances($attachmentModel, 'file');

                if ($files) {
                    foreach ($files as $file) {
                        $newAttachment = new Attachments();
                        $newAttachment->file = $file; // Assign the UploadedFile object
                        if (!$newAttachment->upload($model->post_id)) {
                            Yii::$app->session->setFlash('error', 'Lỗi khi tải lên tệp đính kèm: ' . implode(', ', $newAttachment->getErrorSummary(true)));
                            // Handle error, e.g., don't redirect or show detailed error
                        }
                    }
                }
                Yii::$app->session->setFlash('success', 'Bài viết đã được cập nhật thành công.');
                return $this->redirect(['view', 'post_id' => $model->post_id]);
            } else {
                Yii::$app->session->setFlash('error', 'Lỗi khi cập nhật bài viết: ' . implode(', ', $model->getErrorSummary(true)));
            }
        }

        $categories = \yii\helpers\ArrayHelper::map(Categories::find()->all(), 'category_id', 'category_name');

        return $this->render('update', [
            'model' => $model,
            'categories' => $categories,
            // $model->attachments will be available directly through the loaded model
        ]);
    }

    /**
     * Deletes an existing Posts model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $post_id Post ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($post_id)
    {
        $model = $this->findModel($post_id);

        // Before deleting the post, delete its attachments (files and database records)
        foreach ($model->attachments as $attachment) {
            $this->deleteAttachmentFile($attachment->file_path); // Delete file from server
            $attachment->delete(); // Delete record from database
        }

        if ($model->delete()) {
            Yii::$app->session->setFlash('success', 'Bài viết đã được xóa thành công.');
        } else {
            Yii::$app->session->setFlash('error', 'Không thể xóa bài viết.');
        }

        return $this->redirect(['index']);
    }

    /**
     * Deletes an attachment via AJAX or direct request.
     * @param int $attachment_id Attachment ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionAttachmentDelete($attachment_id)
    {
        $attachment = Attachments::findOne($attachment_id);

        if ($attachment === null) {
            throw new NotFoundHttpException('Tệp đính kèm không tồn tại.');
        }

        $filePath = Yii::getAlias('@frontend/web' . $attachment->file_path); // Adjust path as needed

        if ($attachment->delete()) { // This deletes the DB record
            // Now, delete the actual file from the server
            if (file_exists($filePath)) {
                unlink($filePath);
                Yii::$app->session->setFlash('success', 'Tệp đính kèm đã được xóa.');
            } else {
                Yii::$app->session->setFlash('warning', 'Tệp đính kèm đã được xóa khỏi DB nhưng không tìm thấy trên máy chủ.');
            }
        } else {
            Yii::$app->session->setFlash('error', 'Không thể xóa tệp đính kèm.');
        }

        // Redirect back to the post update page or referrer
        return $this->redirect(Yii::$app->request->referrer ?: ['update', 'post_id' => $attachment->post_id]);
    }

    /**
     * Finds the Posts model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $post_id Post ID
     * @return Posts the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($post_id)
    {
        if (($model = Posts::findOne(['post_id' => $post_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Helper to delete attachment file from server.
     * @param string $filePath The relative path to the file (e.g., /uploads/attachments/xyz.jpg)
     */
    protected function deleteAttachmentFile($filePath)
    {
        $fullPath = Yii::getAlias('@frontend/web' . $filePath);
        if (file_exists($fullPath) && is_file($fullPath)) {
            unlink($fullPath);
        }
    }
}