<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "quote_response".
 *
 * @property integer $id
 * @property integer $instant_quote_id
 * @property integer $quote_company_id
 * @property string $legal_fee
 * @property string $vat
 * @property string $disbursements
 * @property string $stamp_duty
 * @property string $total_amount
 * @property string $reference_number
 * @property string $instruct_us_url
 * @property string $instruct_us_method
 * @property integer $instruct_us_is_multipart_form
 * @property string $instruct_us_params
 *
 * @property InstantQuote $instantQuote
 * @property QuoteCompany $quoteCompany
 * @property QuoteResponseDetail[] $quoteResponseDetails
 */
class QuoteResponse extends \yii\db\ActiveRecord
{
	const INSTRUCT_US_METHOD_GET = 'GET';
	const INSTRUCT_US_METHOD_POST = 'POST';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quote_response';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['instant_quote_id', 'quote_company_id'], 'required'],
            [['instant_quote_id', 'quote_company_id'], 'integer'],
            [['legal_fee', 'vat', 'disbursements', 'stamp_duty', 'total_amount'], 'number'],
            ['reference_number', 'string', 'max' => 100],
			['instruct_us_method', 'in', 'range' => [self::INSTRUCT_US_METHOD_GET, self::INSTRUCT_US_METHOD_POST]],
			['instruct_us_is_multipart_form', 'boolean'],
			[['instruct_us_params', 'instruct_us_url'], 'string'],
			[['instant_quote_id'], 'exist', 'skipOnError' => true, 'targetClass' => InstantQuote::className(), 'targetAttribute' => ['instant_quote_id' => 'id']],
            [['quote_company_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuoteCompany::className(), 'targetAttribute' => ['quote_company_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'instant_quote_id' => 'Instant Quote ID',
            'quote_company_id' => 'Quote Company ID',
            'legal_fee' => 'Legal Fees',
            'vat' => 'Vat',
            'disbursements' => 'Disbursements',
            'stamp_duty' => 'Stamp Duty',
            'total_amount' => 'Total Amount',
            'reference_number' => 'Reference Number',
			'instruct_us_url' => 'Instruct Us form url',
			'instruct_us_method' => 'Form method',
			'instruct_us_is_multipart_form' => 'Is form as `multipart/form-data`',
			'instruct_us_params' => 'Form parameters',
		];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInstantQuote()
    {
        return $this->hasOne(InstantQuote::className(), ['id' => 'instant_quote_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuoteCompany()
    {
        return $this->hasOne(QuoteCompany::className(), ['id' => 'quote_company_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuoteResponseDetails()
    {
        return $this->hasMany(QuoteResponseDetail::className(), ['quote_response_id' => 'id']);
    }
}
