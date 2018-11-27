<?php
/**
 * Created by Kudin Dmitry.
 * Date: 10.09.2018
 * Time: 9:29
 */

namespace frontend\widgets;

use Yii;
use yii\base\Widget;
use common\models\LoginForm;

class LoginFormWidget extends Widget {

    public function run() {
        if (Yii::$app->user->isGuest) {
            $model = new LoginForm();
            return $this->render('loginFormWidget', [
                'model' => $model,
            ]);
        } else {
            return '';
        }
    }

}