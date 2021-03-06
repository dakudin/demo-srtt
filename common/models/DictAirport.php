<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "dict_airport".
 *
 * @property integer $id
 * @property string $name
 *
 * @property CompanyAirport[] $companyAirports
 * @property QuoteCompany[] $quoteCompanies
 * @property TravelQuote[] $travelQuotes
 */
class DictAirport extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dict_airport';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 50],
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
    public function getCompanyAirports()
    {
        return $this->hasMany(CompanyAirport::className(), ['airport_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuoteCompanies()
    {
        return $this->hasMany(QuoteCompany::className(), ['id' => 'quote_company_id'])->viaTable('company_airport', ['airport_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTravelQuotes()
    {
        return $this->hasMany(TravelQuote::className(), ['airport_id' => 'id']);
    }

    /**
     * @param $companyIDs array
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getAirportsByCompany($companyIDs){
        $companies = implode(',', $companyIDs);
        $sql = 'SELECT d.id, d.name FROM dict_airport d LEFT JOIN company_airport c ON (d.id=c.airport_id)'
            .' WHERE c. quote_company_id IN ('.$companies.') ORDER BY name';

        return DictAirport::findBySql($sql)->all();
    }

    /**
     * fetch the country list
     */
    public static function getAirportList() {
        $data = DictAirport::find()->all();
        $out = [];
        foreach ($data as $d) {
            $out[] = $d['name']; //['value' => $d['name']];
        }

        return $out;
    }
}

