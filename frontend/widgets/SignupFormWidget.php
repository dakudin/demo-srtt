<?php
/**
 * Created by Kudin Dmitry.
 * Date: 28.09.2018
 * Time: 12:06
 */

namespace frontend\widgets;

use Yii;
use yii\base\Widget;
use frontend\models\SignupForm;

class SignupFormWidget extends Widget{

    public function run() {
        if(Yii::$app->user->isGuest) {
            $model = new SignupForm();
            return $this->render('signupFormWidget' , [
                'model' => $model
            ]);
        }else{
            return '';
        }
    }
}