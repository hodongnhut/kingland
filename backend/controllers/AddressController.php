<?php

namespace backend\controllers;

use Yii;
use common\models\Districts;
use common\models\Wards;
use common\models\Streets;
use yii\filters\AccessControl;

class AddressController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['districts', 'wards', 'streets'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
    public function actionDistricts($ProvinceId)
    {
        if (Yii::$app->user->isGuest) {
            throw new \yii\web\ForbiddenHttpException('Vui Lòng Đăng Nhập.');
        }

        $districts = Districts::find()
            ->where(['ProvinceId' => $ProvinceId])
            ->all();

        echo "<option value=''>Chọn Quận Huyện...</option>";
        foreach ($districts as $district) {
            echo "<option value='" . $district->id . "'>" . $district->Name . "</option>";
        }
    }


    public function actionWards($DistrictId)
    {
        if (Yii::$app->user->isGuest) {
            throw new \yii\web\ForbiddenHttpException('Vui Lòng Đăng Nhập.');
        }

        $wards = Wards::find()
            ->where(['DistrictId' => $DistrictId])
            ->all();

        echo "<option value=''>Chọn Phường / Xã</option>";
        foreach ($wards as $ward) {
            echo "<option value='" . $ward->id . "'>" . $ward->Name . "</option>";
        }
    }

    public function actionStreets($DistrictId)
    {
        if (Yii::$app->user->isGuest) {
            throw new \yii\web\ForbiddenHttpException('Vui Lòng Đăng Nhập.');
        }

        $streets = Streets::find()
            ->where(['DistrictId' => $DistrictId])
            ->all();

        echo "<option value=''>Chọn Đường</option>";
        foreach ($streets as $street) {
            echo "<option value='" . $street->id . "'>" . $street->Name . "</option>";
        }
    }
}
