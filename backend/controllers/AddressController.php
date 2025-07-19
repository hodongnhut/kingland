<?php

namespace backend\controllers;

use Yii;
use common\models\Provinces;
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

        $province = Provinces::find()
            ->where(['Name' => $ProvinceId])
            ->one();

        $districts = Districts::find()
            ->where(['ProvinceId' => $province->id])
            ->all();

        echo "<option value=''>Chọn Quận Huyện...</option>";
        foreach ($districts as $district) {
            echo "<option value='" . $district->Name . "'>" . $district->Name . "</option>";
        }
    }


    public function actionWards($DistrictId)
    {
        if (Yii::$app->user->isGuest) {
            throw new \yii\web\ForbiddenHttpException('Vui Lòng Đăng Nhập.');
        }

        $district = Districts::find()
            ->where(['Name' => $DistrictId])
            ->one();

        $wards = Wards::find()
            ->where(['DistrictId' => $district->id])
            ->all();

        echo "<option value=''>Chọn Phường / Xã</option>";
        foreach ($wards as $ward) {
            echo "<option value='" . $ward->Name . "'>" . $ward->Name . "</option>";
        }
    }

    public function actionStreets($DistrictId)
    {
        if (Yii::$app->user->isGuest) {
            throw new \yii\web\ForbiddenHttpException('Vui Lòng Đăng Nhập.');
        }


        $district = Districts::find()
            ->where(['Name' => $DistrictId])
            ->one();

        $streets = Streets::find()
            ->where(['DistrictId' => $district->id])
            ->all();

        echo "<option value=''>Chọn Đường</option>";
        foreach ($streets as $street) {
            echo "<option value='" . $street->Name . "'>" . $street->Name . "</option>";
        }
    }
}
