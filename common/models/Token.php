<?php
/**
 * Created by Kudin Dmitry
 * Date: 24.10.2018
 * Time: 12:29
 */

namespace common\models;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "Token".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $expired_at
 * @property string $token
 *
 * @property User $user
 *
 */
class Token extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%token}}';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function generateToken($expire)
    {
        $this->expired_at = $expire;
        $this->token = \Yii::$app->security->generateRandomString();
    }

    public function fields()
    {
        return [
            'token' => 'token',
            'expired' => function () {
                return date(DATE_RFC3339, $this->expired_at);
            },
        ];
    }
}