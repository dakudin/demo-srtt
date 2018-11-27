<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_token".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $access_token
 * @property string $token_type
 * @property integer $expires_in
 * @property string $refresh_token
 * @property integer $refresh_expiration_in
 *
 * @property User $user
 */
class UserToken extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_token';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'expires_in', 'refresh_expiration_in'], 'integer'],
            [['access_token', 'refresh_token'], 'string', 'max' => 41],
            [['token_type'], 'string', 'max' => 255],
            [['access_token'], 'unique'],
            [['refresh_token'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'access_token' => 'Access Token',
            'token_type' => 'Token Type',
            'expires_in' => 'Expires In',
            'refresh_token' => 'Refresh Token',
            'refresh_expiration_in' => 'Refresh Expiration In',
        ];
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
        $this->expires_in = $expire;
        $this->access_token = \Yii::$app->security->generateRandomString();
        $this->refresh_token = \Yii::$app->security->generateRandomString();
        $this->refresh_expiration_in = $expire + 3600 * 24;
    }

    public function fields()
    {
        return [
            'access_token' => 'access_token',
            'expired' => function () {
                return date(DATE_RFC3339, $this->expires_in);
            },
        ];
    }
}
