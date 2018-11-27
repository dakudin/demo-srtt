<?php
/**
 * Created by Kudin Dmitry.
 * Date: 05.11.2018
 * Time: 10:22
 */

namespace frontend\widgets\restorepasswordform;

use Yii;
use yii\base\Widget;
use frontend\models\PasswordResetRequestForm;

class RestorePasswordFormWidget extends Widget {

    public function run() {
        if (Yii::$app->user->isGuest) {
            $model = new PasswordResetRequestForm();
            return $this->render('restorePasswordFormWidget', [
                'model' => $model,
            ]);
        } else {
            return '';
        }
    }

}