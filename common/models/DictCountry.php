<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "dict_country".
 *
 * @property integer $id
 * @property string $name
 *
 * @property CompanyCountry[] $companyCountries
 * @property QuoteCompany[] $quoteCompanies
 * @property DictRegion $dictRegion
 * @property DictResort[] $dictResorts
 * @property TravelQuote[] $travelQuotes
 */
class DictCountry extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dict_country';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 30],
            [['name'], 'unique'],
            ['dict_region_id', 'integer'],
            [['dict_region_id'], 'exist', 'skipOnError' => true, 'targetClass' => DictRegion::className(), 'targetAttribute' => ['dict_region_id' => 'id']],
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
    public function getCompanyCountries()
    {
        return $this->hasMany(CompanyCountry::className(), ['country_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuoteCompanies()
    {
        return $this->hasMany(QuoteCompany::className(), ['id' => 'quote_company_id'])->viaTable('company_country', ['country_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDictResorts()
    {
        return $this->hasMany(DictResort::className(), ['dict_country_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDictRegion()
    {
        return $this->hasOne(DictRegion::className(), ['id' => 'dict_region_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTravelQuotes()
    {
        return $this->hasMany(TravelQuote::className(), ['country_id' => 'id']);
    }

    /**
     * @param $companyIDs array
     * @param $regionIDs array|int
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getCountriesByCompany($companyIDs, $regionIDs){
        $companies = implode(',', $companyIDs);
        $sql = 'SELECT d.id, d.name FROM dict_country d LEFT JOIN company_country c ON (d.id=c.country_id) '
            .'WHERE c.quote_company_id IN ('.$companies.')';

        if(is_array($regionIDs) && count($regionIDs)>0){
            $regions = implode($regionIDs, ',');
            $sql .= ' AND d.dict_region_id IN (' . $regions . ')';
        }elseif(!is_array($regionIDs) && $regionIDs!=0){
            $sql .= ' AND d.dict_region_id = ' . (int)$regionIDs;
        }
        $sql .= ' ORDER BY name';

        return DictCountry::findBySql($sql)->orderBy('name')->all();
    }

    public static function getCountriesByName($name = null, $limit = 10)
    {
        return Yii::$app->db->createCommand('SELECT name FROM dict_country WHERE name LIKE :name ORDER BY name LIMIT 10')
            ->bindValue(':name', '%'.$name.'%')
            ->queryAll();
    }
}
