<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use \common\components\Helper;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password

 * @property string $contact_email
 * @property string $contact_phone
 * @property string $user_title
 * @property string $user_first_name
 * @property string $user_last_name
 * @property string $address_street
 * @property string $address_town
 * @property string $address_county
 * @property string $address_postcode
 * @property string $best_time2contact

 *
 * @property Auth $auths
 * @property Token $tokens
 * @property UserToken $user_tokens
 * @property TravelQuote $TravelQuotes
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    const USER_TITLE_MR = 'Mr';
    const USER_TITLE_MRS = 'Mrs';
    const USER_TITLE_MISS = 'Miss';
    const USER_TITLE_MS = 'Ms';
    const USER_TITLE_DR = 'Dr';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            [['address_street', 'address_town', 'address_county'], 'string', 'max' => 100],
            ['user_title', 'in', 'range' => [self::USER_TITLE_MISS, self::USER_TITLE_MR, self::USER_TITLE_MRS, self::USER_TITLE_MS, self::USER_TITLE_DR]],
            ['contact_phone', 'match', 'pattern' => Helper::REGEXP_PHONE],
            [['address_postcode'], 'match', 'pattern' => Helper::REGEXP_POSTCODE],
            [['contact_email'], 'string', 'max' => 255],
            ['contact_phone', 'string', 'max' => 20],
            ['best_time2contact', 'string', 'max' => 50],
            ['contact_email', 'email'],
            ['email', 'emailUniqueValidator', 'on'=>'update'],
        ];
    }

    public function emailUniqueValidator($attribute,$params){
        if(!$this->hasErrors()){
            if(User::find()->where([$attribute=>$this->$attribute])->andWhere(['<>','id',Yii::$app->user->id])){

            }
        }
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::find()
            ->joinWith('user_tokens t')
            ->andWhere(['t.access_token' => $token])
            ->andWhere(['>', 't.expires_in', time()])
            ->one();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTokens()
    {
        return $this->hasMany(Token::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserTokens()
    {
        return $this->hasMany(UserToken::className(), ['user_id' => 'id']);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuths()
    {
        return $this->hasMany(Auth::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTravelQuotes()
    {
        return $this->hasMany(TravelQuote::className(), ['user_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * Set first values for user info and address
     * @param $contact_email
     * @param $contact_phone
     * @param $user_title
     * @param $user_first_name
     * @param $user_last_name
     * @param $address_street
     * @param $address_town
     * @param $address_county
     * @param $address_postcode
     * @param $best_time2contact
     * @return bool
     */
    public function setProfileInfoForFirstValues($contact_email, $contact_phone, $user_title, $user_first_name,
        $user_last_name, $address_street, $address_town, $address_county, $address_postcode, $best_time2contact)
    {
        $fields = [];
        if(empty($this->contact_email) && empty($this->contact_phone)
            && empty($this->user_first_name) && empty($this->user_last_name) && empty($this->best_time2contact)
        ){
            $fields = ['contact_email','contact_phone','user_title','user_first_name','user_last_name'];
            $this->contact_email = $contact_email;
            $this->contact_phone = $contact_phone;
            $this->user_title = $user_title;
            $this->user_first_name = $user_first_name;
            $this->user_last_name = $user_last_name;
            $this->best_time2contact = $best_time2contact;
        }

        if(empty($this->address_street) && empty($this->address_town) && empty($this->address_county)
            && empty($this->address_postcode)
        ){
            $this->address_street = $address_street;
            $this->address_town = $address_town;
            $this->address_county = $address_county;
            $this->address_postcode = $address_postcode;
            $fields = array_merge($fields, ['address_street','address_town','address_county','address_postcode']);
        }

        if(empty($fields)) return false;

        return $this->save(true, $fields);
    }

    public function fields()
    {
        return [
            'id' => 'id',
            'email' => 'email',
            'contact_email' => 'contact_email',
            'contact_phone' => 'contact_phone',
            'user_title' => 'user_title',
            'user_first_name' => 'user_first_name',
            'user_last_name' => 'user_last_name',
            'address_street' => 'address_street',
            'address_town' => 'address_town',
            'address_county' => 'address_county',
            'address_postcode' => 'address_postcode',
            'best_time2contact' => 'best_time2contact',
        ];
    }
}
