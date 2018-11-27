<?php

namespace common\models;

use Yii;
use \common\components\Helper;

/**
 * This is the model class for table "instant_quote".
 *
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $phone
 * @property string $type
 * @property string $buying_price
 * @property string $property_type
 * @property integer $has_buying_mortgage
 * @property integer $is_new_build
 * @property integer $is_second_purchase
 * @property string $selling_price
 * @property string $selling_property_type
 * @property integer $has_selling_mortgage
 * @property string $remortgage_price
 * @property string $remortgage_property_type
 * @property integer $transfer_of_enquity
 * @property integer $email_subscribed
 * @property string $buying_postcode
 * @property string $selling_postcode
 * @property string $remortgage_postcode
 * @property integer $help_to_buy
 * @property integer $sdlt_additional
 */
class InstantQuote extends \yii\db\ActiveRecord
{

	const TYPE_BUY = 'buy';
	const TYPE_BUY_N_SELL = 'buy_n_sell';
	const TYPE_SELL = 'sell';
	const TYPE_REMORTGAGE = 'remortgage';

	const FREEHOLD = 'freehold';
	const LEASEHOLD = 'leasehold';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'instant_quote';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'email', 'phone', 'type'], 'required'],
            [['type', 'property_type', 'selling_property_type', 'remortgage_property_type'], 'string'],
            [['buying_price', 'selling_price', 'remortgage_price'], 'number'],
			[['buying_price', 'selling_price', 'remortgage_price'], 'compare', 'compareValue' => 1000, 'operator' => '>='],
			[['buying_price', 'selling_price', 'remortgage_price'], 'compare', 'compareValue' => 1999999, 'operator' => '<='],
            [['has_buying_mortgage', 'is_new_build', 'is_second_purchase', 'has_selling_mortgage', 'transfer_of_enquity', 'email_subscribed', 'help_to_buy', 'sdlt_additional'],
			 	'in',
				'range' => [0,1]
			],
            [['first_name', 'last_name', 'email'], 'string', 'max' => 255],
            ['phone', 'string', 'max' => 20],
			['email', 'email'],
			['phone', 'match', 'pattern' => Helper::REGEXP_PHONE],
			[['buying_postcode', 'selling_postcode', 'remortgage_postcode'], 'match', 'pattern' => Helper::REGEXP_POSTCODE],

			['buying_price', 'required', 'when' => function ($model) {
					return $model->type == self::TYPE_BUY || $model->type == self::TYPE_BUY_N_SELL;
				}, 'whenClient' => 'function (attribute, value) {
					return $("#type-buy").is(":checked") || $("#type-buy_n_sell").is(":checked");
				}', 'message' => 'Set the Buying price'],

			['buying_postcode', 'required', 'when' => function ($model) {
					return $model->type == self::TYPE_BUY || $model->type == self::TYPE_BUY_N_SELL;
				}, 'whenClient' => 'function (attribute, value) {
					return $("#type-buy").is(":checked") || $("#type-buy_n_sell").is(":checked");
				}', 'message' => 'Set the Buying property postcode'],

			['selling_price', 'required', 'when' => function ($model) {
					return $model->type == self::TYPE_SELL || $model->type == self::TYPE_BUY_N_SELL;
				}, 'whenClient' => 'function (attribute, value) {
					return $("#type-sell").is(":checked") || $("#type-buy_n_sell").is(":checked");
				}', 'message' => 'Set the Selling price'],

			['selling_postcode', 'required', 'when' => function ($model) {
					return $model->type == self::TYPE_SELL || $model->type == self::TYPE_BUY_N_SELL;
				}, 'whenClient' => 'function (attribute, value) {
					return $("#type-sell").is(":checked") || $("#type-buy_n_sell").is(":checked");
				}', 'message' => 'Set the Selling property postcode'],

			['remortgage_price', 'required', 'when' => function ($model) {
					return $model->type == self::TYPE_REMORTGAGE;
				}, 'whenClient' => 'function (attribute, value) {
					return $("#type-remortgage").is(":checked");
				}', 'message' => 'Set the Remortgage price'],

			['remortgage_postcode', 'required', 'when' => function ($model) {
					return $model->type == self::TYPE_REMORTGAGE;
				}, 'whenClient' => 'function (attribute, value) {
					return $("#type-remortgage").is(":checked");
				}', 'message' => 'Set the Remortgage property postcode'],
		];
    }

	public function clearDirtyFields(){
		switch ($this->type){

			case self::TYPE_BUY :
				$this->selling_price = null;
				$this->selling_property_type = self::FREEHOLD;
				$this->has_selling_mortgage = 0;
				$this->remortgage_property_type = self::FREEHOLD;
				$this->remortgage_price = null;
				$this->transfer_of_enquity = 0;
				$this->selling_postcode = null;
				$this->remortgage_postcode = null;
				break;

			case self::TYPE_SELL :
				$this->buying_price = null;
				$this->property_type = self::FREEHOLD;
				$this->has_buying_mortgage = 0;
				$this->is_new_build = 0;
				$this->is_second_purchase = 0;
				$this->remortgage_property_type = self::FREEHOLD;
				$this->remortgage_price = null;
				$this->transfer_of_enquity = 0;
				$this->buying_postcode = null;
				$this->remortgage_postcode = null;
				$this->help_to_buy = 0;
				$this->sdlt_additional = 0;
				break;

			case self::TYPE_BUY_N_SELL :
				$this->remortgage_property_type = self::FREEHOLD;
				$this->remortgage_price = null;
				$this->transfer_of_enquity = 0;
				$this->remortgage_postcode = null;
				break;

			case self::TYPE_REMORTGAGE :
				$this->selling_price = null;
				$this->selling_property_type = self::FREEHOLD;
				$this->has_selling_mortgage = 0;
				$this->buying_price = null;
				$this->property_type = self::FREEHOLD;
				$this->help_to_buy = 0;
				$this->sdlt_additional = 0;
				$this->has_buying_mortgage = 0;
				$this->is_new_build = 0;
				$this->is_second_purchase = 0;
				$this->buying_postcode = null;
				$this->selling_postcode = null;
				break;
		}
	}

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email' => 'Email Address',
            'phone' => 'Telephone',
            'type' => 'Type',
            'buying_price' => 'Buying Price',
            'property_type' => 'Property Type',
            'has_buying_mortgage' => 'I\'m buying with a mortgage',
            'is_new_build' => 'New build property',
            'is_second_purchase' => 'This is a second or investment property purchase',
            'selling_price' => 'Selling Price',
            'selling_property_type' => 'Selling Property Type',
            'has_selling_mortgage' => 'I already have a mortgage on this property',
            'remortgage_price' => 'Remortgage Price',
			'remortgage_property_type' => 'Remortgage Property Type',
            'transfer_of_enquity' => 'Transfer of enquity',
            'email_subscribed' => 'Email Subscribed',
			'buying_postcode' => 'Buying property postcode',
			'selling_postcode' => 'Selling property postcode',
			'remortgage_postcode' => 'Property postcode',
        ];
    }

	public function beforeSave($insert)
	{
		if (!parent::beforeSave($insert)) {
			return false;
		}

		// remove -,) and spaces from phone
		if(!empty($this->phone)) $this->phone = str_replace(['-', ',', '(', ')', ' '], '', $this->phone);

		return true;
	}

	public function setDefaultFields()
	{

		$this->first_name = 'Sebastian';
		$this->last_name = 'Sutton';
		$this->email = 'SebastianSutton@teleworm.us';
		$this->phone = '07037315082';
		$this->type = self::TYPE_BUY;
		$this->buying_price = '104000';
		$this->buying_postcode = 'YO10 5JR';
		$this->property_type = self::FREEHOLD;
	}

	static function getPropertyTypeList()
	{
		return [
			self::FREEHOLD => ucfirst(self::FREEHOLD),
			self::LEASEHOLD => ucfirst(self::LEASEHOLD)
		];
	}
}
