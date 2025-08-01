<?php
namespace common\components;

use Yii;
use yii\base\Behavior;
use yii\web\User;
use yii\web\UnauthorizedHttpException;

class SessionChecker extends Behavior
{
    public function events()
    {
        return [
            User::EVENT_AFTER_LOGIN => 'afterLogin',
            User::EVENT_BEFORE_LOGOUT => 'beforeLogout',
        ];
    }

    public function afterLogin($event)
    {
        $identity = $event->identity;
        Yii::$app->session->set('auth_key_session', $identity->auth_key_session);
        Yii::info('User logged in with auth_key_session: ' . $identity->auth_key_session, __METHOD__);
    }

    public function beforeLogout($event)
    {
        Yii::$app->session->remove('auth_key_session');
    }

    public function checkAuthKeySession()
    {
        if (!Yii::$app->user->isGuest) {
            $user = Yii::$app->user->identity;
            $authKeySession = Yii::$app->session->get('auth_key_session');
            if ($authKeySession !== $user->auth_key_session) {
                Yii::$app->user->logout();
                Yii::$app->session->setFlash('error', 'Phiên của bạn đã bị vô hiệu hóa. Vui lòng đăng nhập lại.');
                throw new UnauthorizedHttpException('Tài Khoản của bạn đang đăng nhập ở thiết bị khác.');
            }
        }
    }
}