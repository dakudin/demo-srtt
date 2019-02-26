<?php
/**
 * Created by Kudin Dmitry
 * Date: 26.02.2019
 * Time: 17:24
 */

namespace common\components;

use yii\authclient\AuthAction;
use Yii;

class SocialAuthAction extends AuthAction
{
    /**
     * Runs the action.
     */
    public function run()
    {
        if(strpos(Yii::$app->request->referrer, Yii::$app->request->serverName) !== FALSE) {
            Yii::$app->session['returnUrl'] = Yii::$app->request->referrer;
        }

        parent::run();
    }
}