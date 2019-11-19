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
                    'clientId' => '2076627205736800', //'482427341961320',
                    'clientSecret' => '61db32969df60fc6b8e630e8eedf5e41', //'39e15e876dfb129d51163a02909c9416',
                    'authUrl' => 'https://www.facebook.com/v3.1/dialog/oauth',
                    'attributeNames' => ['email', 'name', 'first_name', 'last_name',
                        // 'user_age_range', 'user_birthday',  'user_gender', 'user_hometown', 'user_location'
                    ],
//                    'scope' =>  ['email', 'name', 'public_profile', 'user_location'],
                ],

//                'amazon' => [
//                    'class' => 'common\components\AmazonAuthClient',
//                    'clientId' => 'amzn1.application-oa2-client.a0e54471f93d4381a217ad024d3f3e5a',
//                    'clientSecret' => 'ec1df148e5f62a3e4a349ed653043ced443fcb18ef282d976f9f8214697576c5',
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
