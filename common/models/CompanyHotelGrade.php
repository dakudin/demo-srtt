<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "company_hotel_grade".
 *
 * @property integer $quote_company_id
 * @property integer $hotel_grade_id
 * @property string $service_hotel_grade_id
 *
 * @property DictHotelGrade $hotelGrade
 * @property QuoteCompany $quoteCompany
 */
class CompanyHotelGrade extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'company_hotel_grade';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['quote_company_id', 'hotel_grade_id', 'service_hotel_grade_id'], 'required'],
            [['quote_company_id', 'hotel_grade_id'], 'integer'],
            [['service_hotel_grade_id'], 'string', 'max' => 10],
            [['quote_company_id', 'hotel_grade_id'], 'unique', 'targetAttribute' => ['quote_company_id', 'hotel_grade_id'], 'message' => 'The combination of Quote Company ID and Hotel Grade ID has already been taken.'],
            [['hotel_grade_id'], 'exist', 'skipOnError' => true, 'targetClass' => DictHotelGrade::className(), 'targetAttribute' => ['hotel_grade_id' => 'id']],
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
            'hotel_grade_id' => 'Hotel Grade ID',
            'service_hotel_grade_id' => 'Service Hotel Grade ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHotelGrade()
    {
        return $this->hasOne(DictHotelGrade::className(), ['id' => 'hotel_grade_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuoteCompany()
    {
        return $this->hasOne(QuoteCompany::className(), ['id' => 'quote_company_id']);
    }
}
