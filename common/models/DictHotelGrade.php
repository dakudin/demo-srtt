<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "dict_hotel_grade".
 *
 * @property integer $id
 * @property string $name
 *
 * @property CompanyHotelGrade[] $companyHotelGrades
 * @property QuoteCompany[] $quoteCompanies
 * @property TravelQuoteHotelGrade[] $travelQuoteHotelGrades
 * @property TravelQuote[] $travelQuotes
 */
class DictHotelGrade extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dict_hotel_grade';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 3],
            [['name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyHotelGrades()
    {
        return $this->hasMany(CompanyHotelGrade::className(), ['hotel_grade_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuoteCompanies()
    {
        return $this->hasMany(QuoteCompany::className(), ['id' => 'quote_company_id'])->viaTable('company_hotel_grade', ['hotel_grade_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTravelQuoteHotelGrades()
    {
        return $this->hasMany(TravelQuoteHotelGrade::className(), ['dict_hotel_grade_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTravelQuotes()
    {
        return $this->hasMany(TravelQuote::className(), ['id' => 'travel_quote_id'])->viaTable('travel_quote_hotel_grade', ['dict_hotel_grade_id' => 'id']);
    }

    /**
     * @param $companyIDs array
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getHotelGradeByCompany($companyIDs){
        $companies = implode(',', $companyIDs);
        $sql = 'SELECT d.id, d.name FROM dict_hotel_grade d LEFT JOIN company_hotel_grade c ON (d.id=c.hotel_grade_id)'
            .' WHERE c. quote_company_id IN ('.$companies.') ORDER BY name';

        return DictHotelGrade::findBySql($sql)->all();
    }
}
