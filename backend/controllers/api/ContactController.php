<?php

namespace backend\controllers\api;

use Yii;
use yii\rest\Controller;
use yii\filters\auth\HttpBearerAuth;
use common\models\OwnerContacts;

class ContactController extends Controller
{

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
        ];
        return $behaviors;
    }


    public function actionUpdate()
    {
        $data = $data = Yii::$app->request->post();
        if (!$data || !isset($data['role'])) {
            return ['success' => false, 'message' => 'Dữ liệu gửi lên không hợp lệ.'];
        }

        $id = Yii::$app->request->post('id');
        $model = OwnerContacts::findOne($id);
        $model->role_id = (int)$data['role'];
        $model->contact_name = $data['name'];
        $model->phone_number = $data['phone'];
        $model->gender_id = (int)$data['gender'];
        $model->property_id = (int)$data['propertyId'];


        if ($model->save()) {
            return [
                'success' => true,
                'data' => $model,
                'message' => "Cập nhật thành công"
            ];
        } else {
            return [
                'success' => false,
                'message' => $model ? implode(', ', $model->getFirstErrors()) : 'Không tìm thấy liên hệ.',
            ];
        }
        
    }

    public function actionDelete($id)
    {
        if (!in_array(Yii::$app->user->identity->jobTitle->role_code ?? '', ['manager', 'super_admin'])) {
            return ['success' => false, 'message' => 'Bạn không có quyền xóa liên hệ.'];
        }

        $contact = OwnerContacts::findOne($id);

        if (!$contact) {
            return ['success' => false, 'message' => 'Không tìm thấy liên hệ.'];
        }

        if ($contact->delete()) {
            return ['success' => true, 'message' => 'Xóa Contact thành công'];
        } else {
            return ['success' => false, 'message' => 'Không thể xóa liên hệ.'];
        }
    }


}