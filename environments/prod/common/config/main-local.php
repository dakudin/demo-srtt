<?php
return [
    'components' => [
        'components' => [
            'db' => [
                'class' => 'yii\db\Connection',
                'dsn' => 'mysql:host=localhost;dbname=s_quote',
                'username' => 's_quote',
                'password' => '5ksIDBQvT9YG9snM_er3',
                'charset' => 'utf8',
            ],
            'mailer' => [
                'class' => 'yii\swiftmailer\Mailer',
                'viewPath' => '@common/mail',
                'useFileTransport' => false,
            ],
        ],
    ],
];
