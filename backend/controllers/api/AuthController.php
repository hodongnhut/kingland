<?php

namespace backend\controllers\api;

use Yii;
use yii\rest\Controller;
use yii\filters\auth\HttpBearerAuth;
use common\models\User;

class AuthController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
            'except' => ['login'],
        ];

        return $behaviors;
    }

    public function actionLogin()
    {
        $request = Yii::$app->request;
        $username = $request->post('username');
        $password = $request->post('password');

        $user = User::findByUsernameOrEmail($username);
        if ($user && $user->validatePassword($password)) {
            $user->generateAccessToken();

            return $this->response(true, 'Login successful', [
                'access_token' => $user->access_token,
                'expired_at' => $user->access_token_expired_at,
                'user' => [
                    'id' => $user->id,
                    'username' => $user->username,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'full_name' => $user->full_name,
                ],
            ]);
        }

        return $this->response(false, 'Invalid credentials');
    }


    public function actionMe()
    {
        $user = Yii::$app->user->identity;

        if (!$user) {
            return $this->response(false, 'Unauthorized');
        }

        return $this->response(true, 'User info', [
            'id' => $user->id,
            'username' => $user->username,
            'email' => $user->email,
        ]);
    }

    public function actionLogout()
    {
        $user = Yii::$app->user->identity;

        if ($user) {
            $user->access_token = null;
            $user->access_token_expired_at = null;
            $user->save(false);
        }

        return $this->response(true, 'Logout successful');
    }

    private function response($status, $msg, $data = null)
    {
        return [
            'status' => $status,
            'msg' => $msg,
            'data' => $data,
        ];
    }

}
