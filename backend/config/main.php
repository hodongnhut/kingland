<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log', 'gii'],
    'modules' => [
        'gii' => [
            'class' => 'yii\gii\Module',
           'allowedIPs' => ['*'],
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
            'enableCsrfValidation' => true,
            'secureHeaders' => [
                'X-Forwarded-For',
                'X-Forwarded-Host',
                'X-Forwarded-Proto',
                'X-Forwarded-Port',
            ],
            'secureProtocolHeaders' => [
                'X-Forwarded-Proto' => ['https'],
            ],
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'property' => 'site/property',
                'property-folder' => 'site/property-folder',
                'property-user' => 'site/property-user',
                'login-version' => 'site/login-version',
                'change-password' => 'site/change-password',
                'news' => 'news/index',
                'user/map/<id:\d+>' => 'user/map',
                'login-version' => 'user-location',
                'news' => 'post',
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',

            ],
        ],
    ],
    'params' => $params,
];
