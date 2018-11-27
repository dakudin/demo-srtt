<?php
/**
 * Created by Kudin Dmitry
 * Date: 24.10.2018
 * Time: 12:43
 */

return [
    [
        'user_id' => 1,
        'token' => 'token-correct',
        'expired_at' => time() + 3600,
    ],
    [
        'user_id' => 1,
        'token' => 'token-expired',
        'expired_at' => time() - 3600,
    ]
];