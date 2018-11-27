<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "dict_resort".
 *
 * @property integer $id
 * @property string $name
 * @property integer $dict_country_id
 *
 * @property CompanyResort[] $companyResorts
 * @property QuoteCompany[] $quoteCompanies
 * @property DictCountry $dictCountry
 * @property TravelQuote[] $travelQuotes
 */
class DictResort extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dict_resort';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'dict_country_id'], 'required'],
            [['dict_country_id'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['name'], 'unique'],
            [['dict_country_id'], 'exist', 'skipOnError' => true, 'targetClass' => DictCountry::className(), 'targetAttribute' => ['dict_country_id' => 'id']],
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
            'dict_country_id' => 'Dict Country ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyResorts()
    {
        return $this->hasMany(CompanyResort::className(), ['resort_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuoteCompanies()
    {
        return $this->hasMany(QuoteCompany::className(), ['id' => 'quote_company_id'])->viaTable('company_resort', ['resort_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDictCountry()
    {
        return $this->hasOne(DictCountry::className(), ['id' => 'dict_country_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTravelQuotes()
    {
        return $this->hasMany(TravelQuote::className(), ['resort_id' => 'id']);
    }

    public static function getRegionResortsByCompany($companyIDs, $regionIDs)
    {
        $regionIDs = implode(',', $regionIDs);
        $companyIDs = implode(',', $companyIDs);

        $sql = 'SELECT dr.id, dr.name FROM dict_resort dr'
                .' LEFT JOIN company_resort c ON (d.id=c.resort_id)'
                .' LEFT JOIN dict_country dc ON (dr.dict_country_id=dc.id)'
                .' WHERE dc.dict_region_id IN ('.$regionIDs.')'
                .' AND c.quote_company_id IN ('.$companyIDs.')';

        $resorts = Yii::$app->db->createCommand($sql)->queryAll();

        return $resorts;
    }

    /**
     * @param $companyIDs array
     * @param $countryIDs array|int
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getResortsByCompany($companyIDs, $countryIDs){
        $companies = implode(',', $companyIDs);
        $sql = 'SELECT d.id, d.name FROM dict_resort d LEFT JOIN company_resort c ON (d.id=c.resort_id)'
            .' WHERE c.quote_company_id IN ('.$companies.')';

        if(is_array($countryIDs) && count($countryIDs)>0){
            $countries = implode(',', $countryIDs);
            $sql .= ' AND d.dict_country_id IN (' . $countries . ')';
        }elseif(!is_array($countryIDs) && $countryIDs!=0){
            $sql .= ' AND d.dict_country_id = ' . (int)$countryIDs;
        }
        $sql .= ' ORDER BY name';

        return DictResort::findBySql($sql)->all();
    }
}
