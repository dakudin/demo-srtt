<?php
/**
 * Created by Kudin Dmitry.
 * Date: 04.10.2018
 * Time: 17:28
 */


namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use common\components\Helper;

/**
 * User Profile form
 */
class ProfileForm extends Model
{
    const USER_TITLE_MR = 'Mr';
    const USER_TITLE_MRS = 'Mrs';
    const USER_TITLE_MISS = 'Miss';
    const USER_TITLE_MS = 'Ms';
    const USER_TITLE_DR = 'Dr';

    public $id;
    public $email;

    public $contact_email;
    public $contact_phone;
    public $user_title;
    public $user_first_name;
    public $user_last_name;
    public $best_time2contact;
    public $address_street;
    public $address_town;
    public $address_county;
    public $address_postcode;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User',
                'filter' => function ($query) {
                    $query->andWhere(['not', ['id'=>Yii::$app->user->id]]);
                },
                'message' => 'This email address has already been taken.'
            ],

            [['address_street', 'address_town', 'address_county'], 'string', 'max' => 100],
            ['user_title', 'in', 'range' => [self::USER_TITLE_MISS, self::USER_TITLE_MR, self::USER_TITLE_MRS, self::USER_TITLE_MS, self::USER_TITLE_DR]],
            ['contact_phone', 'match', 'pattern' => Helper::REGEXP_PHONE],
            ['address_postcode', 'match', 'pattern' => Helper::REGEXP_POSTCODE],
            [['user_first_name', 'user_last_name'], 'string', 'max' => 50],
            ['contact_email', 'string', 'max' => 255],
            ['contact_phone', 'string', 'max' => 20],
            ['best_time2contact', 'string', 'max' => 50],
            ['contact_email', 'email'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'contact email' => 'Email address',
            'contact_phone' => 'Telephone',
            'user_title' => 'Title',
            'user_first_name' => 'First name',
            'user_last_name' => 'Last name',
            'address_street' => 'Street name',
            'address_town' => 'Town',
            'address_county' => 'County',
            'address_postcode' => 'Postcode',
            'best_time2contact' => 'Best time to contact you',
        ];
    }


    /**
     * save user profile.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function saveProfile()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = User::findIdentity(Yii::$app->user->id);
//        if(!$user) return null;

        $user->email = $this->email;
        $user->contact_email = $this->contact_email;
        $user->contact_phone = $this->contact_phone;
        $user->user_title = $this->user_title;
        $user->user_first_name = $this->user_first_name;
        $user->user_last_name = $this->user_last_name;
        $user->best_time2contact = $this->best_time2contact;
        $user->address_street = $this->address_street;
        $user->address_town = $this->address_town;
        $user->address_county = $this->address_county;
        $user->address_postcode = $this->address_postcode;

        return $user->save() ? $user : null;
    }

    /**
     * @return array
     */
    public static function getUserTitleList()
    {
        return [
            User::USER_TITLE_MR => User::USER_TITLE_MR,
            User::USER_TITLE_MRS => User::USER_TITLE_MRS,
            User::USER_TITLE_MISS => User::USER_TITLE_MISS,
            User::USER_TITLE_MS => User::USER_TITLE_MS,
            User::USER_TITLE_DR => User::USER_TITLE_DR,
        ];
    }

}
