<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "company_airport".
 *
 * @property integer $quote_company_id
 * @property integer $airport_id
 * @property string $service_airport_id
 *
 * @property DictAirport $airport
 * @property QuoteCompany $quoteCompany
 */
class CompanyAirport extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'company_airport';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['quote_company_id', 'airport_id', 'service_airport_id'], 'required'],
            [['quote_company_id', 'airport_id', 'service_airport_id'], 'integer'],
            ['service_airport_id', 'string', 'max' => 10],
            [['quote_company_id', 'airport_id'], 'unique', 'targetAttribute' => ['quote_company_id', 'airport_id'], 'message' => 'The combination of Quote Company ID and Airport ID has already been taken.'],
            [['airport_id'], 'exist', 'skipOnError' => true, 'targetClass' => DictAirport::className(), 'targetAttribute' => ['airport_id' => 'id']],
            [['quote_company_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuoteCompany::className(), 'targetAttribute' => ['quote_company_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'quote_company_id' => 'Quote Company ID',
            'airport_id' => 'Airport ID',
            'service_airport_id' => 'Service Airport ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAirport()
    {
        return $this->hasOne(DictAirport::className(), ['id' => 'airport_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuoteCompany()
    {
        return $this->hasOne(QuoteCompany::className(), ['id' => 'quote_company_id']);
    }
}
