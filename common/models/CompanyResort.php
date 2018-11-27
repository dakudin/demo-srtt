<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "company_resort".
 *
 * @property integer $quote_company_id
 * @property integer $resort_id
 * @property string $service_resort_id
 *
 * @property DictResort $resort
 * @property QuoteCompany $quoteCompany
 */
class CompanyResort extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'company_resort';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['quote_company_id', 'resort_id', 'service_resort_id'], 'required'],
            [['quote_company_id', 'resort_id'], 'integer'],
            ['service_resort_id', 'string', 'max' => 10],
            [['quote_company_id', 'resort_id'], 'unique', 'targetAttribute' => ['quote_company_id', 'resort_id'], 'message' => 'The combination of Quote Company ID and Resort ID has already been taken.'],
            [['resort_id'], 'exist', 'skipOnError' => true, 'targetClass' => DictResort::className(), 'targetAttribute' => ['resort_id' => 'id']],
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
            'resort_id' => 'Resort ID',
            'service_resort_id' => 'Service Resort ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResort()
    {
        return $this->hasOne(DictResort::className(), ['id' => 'resort_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuoteCompany()
    {
        return $this->hasOne(QuoteCompany::className(), ['id' => 'quote_company_id']);
    }
}
