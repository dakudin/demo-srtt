<?php
/**
 * Created by PhpStorm.
 * User: Monk
 * Date: 02.08.2018
 * Time: 13:49
 */

namespace frontend\helpers;

use Yii;

class FHelper
{

    public static function setRequestQuoteAgreementCookies()
    {
        if (!isset(Yii::$app->request->cookies['quote_agreement'])) {
            Yii::$app->response->cookies->add(new \yii\web\Cookie([
                'name' => 'quote_agreement',
                'value' => null,
                'expire' => time() + 60 * 60 * 24 * 30 * 12 * 5,
                'path' => '/'
            ]));
        }
    }
}