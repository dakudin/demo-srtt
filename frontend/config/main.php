<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'name' => 'SortIt',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
//            'useFileTransport' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
				'/' => 'site/index',

//                '<_c:[\w-]+>' => '<_c>/index',
//                '<_c:[\w-]+>/<id:\d+>' => '<_c>/view',
//                '<_c:[\w-]+>/<id:\d+>/<_a:[\w-]+>' => '<_c>/<_a>',

//                'auth' => 'site/auth',
//				'request-filledin' => 'site/quoteprefilled',
				'<action:\w+ >' => '<action>',
                'travel/skiing/view/<id:\d+>' => 'travel/viewski',
                'travel/skiing/enquiry/<id:\d+>/company/<company_id:\d+>/resort/<resort_id:\d+>' => 'travel/skiingenquiry',
                'travel/beach/view/<id:\d+>' => 'travel/viewbeach',
//				'quotes/view/<id:\d+>'=>'quotes/view',
//				'quotes/show/<id:\d+>'=>'quotes/show',
                '<action:[\w\-]+>' => 'site/<action>',
           ],
        ],
    ],
    'params' => $params,
//    'on afterAction' => function (yii\base\ActionEvent $e) {
//        if(strpos($e->action->id, 'ajax' === FALSE)) // && $e->action->controller->id !== 'site')
//            Yii::$app->user->setReturnUrl(Yii::$app->request->url);
//    },
];
