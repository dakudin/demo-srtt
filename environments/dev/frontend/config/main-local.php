<?php

$config = [
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '8_RwKmVVD856ppk6lHtjO4ZqG7JgEnL0',
        ],

/*        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'facebook' => [
                    'class' => 'yii\authclient\clients\Facebook',
                    'clientId' => '',
                    'clientSecret' => '',
                    'authUrl' => 'https://www.facebook.com/v3.1/dialog/oauth',
                    'attributeNames' => ['email', 'name', 'first_name', 'last_name',
                        // 'user_age_range', 'user_birthday',  'user_gender', 'user_hometown', 'user_location'
                    ],
//                    'scope' =>  ['email', 'name', 'public_profile', 'user_location'],
                ],

//                'amazon' => [
//                    'class' => 'common\components\AmazonAuthClient',
//                    'clientId' => '',
//                    'clientSecret' => '',
//                ],
            ],
        ],*/
    ],
];

if (!YII_ENV_TEST) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
		'allowedIPs' => ['127.0.0.1']
    ];
}

return $config;
