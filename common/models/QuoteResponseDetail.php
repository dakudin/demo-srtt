<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "quote_response_detail".
 *
 * @property integer $id
 * @property integer $quote_response_id
 * @property string $description
 * @property string $amount
 * @property integer $is_disbursements
 * @property string $type
 *
 * @property QuoteResponse $quoteResponse
 */
class QuoteResponseDetail extends \yii\db\ActiveRecord
{
	const TYPE_BUYING = 'buying';
	const TYPE_SELLING = 'selling';
	const TYPE_UNDEFINED = 'undefined';

	const IS_DISBURSTEMENTS = 1;
	const IS_NOT_DISBURSTEMENTS = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quote_response_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['quote_response_id', 'type', 'description', 'amount', 'description'], 'required'],
            [['quote_response_id'], 'integer'],
			['is_disbursements', 'boolean'],
            [['amount'], 'number'],
            [['description'], 'string', 'max' => 1000],
			['type', 'in', 'range' => ['buying','selling','undefined']],
            [['quote_response_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuoteResponse::className(), 'targetAttribute' => ['quote_response_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'quote_response_id' => 'Quote Response ID',
            'description' => 'Description',
            'amount' => 'Amount',
            'is_disbursements' => 'Is Disbursements',
			'type' => 'Type'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuoteResponse()
    {
        return $this->hasOne(QuoteResponse::className(), ['id' => 'quote_response_id']);
    }
}
