<?php

namespace backend\controllers;

use Yii;
use yii\web\Response;
use yii\web\Controller;
use yii\filters\VerbFilter;
use common\models\LoginForm;
use common\models\SignupForm;
use yii\filters\AccessControl;
use yii\web\BadRequestHttpException;
use frontend\models\ResetPasswordForm;
use yii\base\InvalidArgumentException;
use frontend\models\PasswordResetRequestForm;
use common\models\ChangePasswordForm;
use common\models\UserSearch;


/**
 * Site controller
 */
class SiteController extends Controller
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
                        'actions' => [
                            'login', 
                            'error', 
                            'reset-password', 
                            'request-password-reset', 
                            'property', 
                            'property-folder',
                            'property-user',
                            'login-version',
                            'change-password'
                        ],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'property'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $this->layout = 'blank';
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            }

            Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Login action.
     *
     * @return string|Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'blank';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout(): Response
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    /**
     * Property user up.
     *
     * @return mixed
     */
    public function actionProperty() {
        return $this->render('property');
    }

    /**
     * Property user up.
     *
     * @return mixed
     */
    public function actionPropertyUser() {
        return $this->render('property-user');
    }

    /**
     * Property user up.
     *
     * @return mixed
     */
    public function actionLoginVersion() {
        return $this->render('login-version');
    }


    /**
     * Property user up.
     *
     * @return mixed
     */
    public function actionPropertyFolder() {
        return $this->render('property-folder');
    }
    


    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Action to change the logged-in user's password.
     * @return string|\yii\web\Response
     */
    public function actionChangePassword()
    {
        $model = new ChangePasswordForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->changePassword()) {
                Yii::$app->session->setFlash('success', 'Mật khẩu của bạn đã được thay đổi thành công.');
                // Optional: Log out the user after password change for security
                // Yii::$app->user->logout();
                return $this->redirect(['site/index']); // Redirect to dashboard or login page
            } else {
                Yii::$app->session->setFlash('error', 'Có lỗi xảy ra khi thay đổi mật khẩu.');
            }
        }

        return $this->render('change-password', [
            'model' => $model,
        ]);
    }

}
