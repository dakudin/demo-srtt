<?php
/**
 * Created by Kudin Dmitry.
 * Date: 19.08.2019
 * Time: 19:29
 */

namespace frontend\widgets;

use Yii;
use yii\base\Widget;
use common\models\LoginForm;
use frontend\models\SignupForm;

class SignInUpFormWidget extends Widget {

    public function run() {
        if (Yii::$app->user->isGuest) {
            $signInModel = new LoginForm();
            $signUpModel = new SignupForm();
            return $this->render('signInUpFormWidget', [
                'signInModel' => $signInModel,
                'signUpModel' => $signUpModel,
            ]);
        } else {
            return '';
        }
    }

}