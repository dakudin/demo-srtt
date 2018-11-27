<?php
/**
 * Created by Kudin Dmitry.
 * Date: 04.10.2018
 * Time: 17:27
 */


namespace frontend\widgets\profileform;

use frontend\models\ProfileForm;
use Yii;
use yii\base\Widget;
use common\models\User;

class ProfileFormWidget extends Widget {

    public function run() {
        if (Yii::$app->user->isGuest) {
            return '';
        } else {
            $model = new ProfileForm();

            $user = User::findIdentity(Yii::$app->user->id);
            if(!$user) return '';

            $model->id = $user->id;
            $model->email = $user->email;
            $model->contact_email = $user->contact_email;
            $model->contact_phone = $user->contact_phone;
            $model->user_title = $user->user_title;
            $model->user_first_name = $user->user_first_name;
            $model->user_last_name = $user->user_last_name;
            $model->address_street = $user->address_street;
            $model->address_town = $user->address_town;
            $model->address_county = $user->address_county;
            $model->address_postcode = $user->address_postcode;

            return $this->render('profileFormWidget', [
                'model' => $model,
            ]);
        }
    }

}