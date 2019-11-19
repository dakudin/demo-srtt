<?php
return yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/main.php'),
    require(__DIR__ . '/main-local.php'),
    require(__DIR__ . '/test.php'),
    [
        'components' => [
            'db' => [
                'dsn' => 'mysql:host=localhost;dbname=shoptility_quote_test',
                'username' => 'quote_test',
                'password' => 'KitDMb45',
                'charset' => 'utf8',
            ]
        ],
    ]
);
