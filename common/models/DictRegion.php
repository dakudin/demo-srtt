<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "dict_region".
 *
 * @property integer $id
 * @property string $name
 *
 * @property CompanyRegion[] $companyRegions
 * @property QuoteCompany[] $quoteCompanies
 * @property DictCountry[] $dictCountries
 */
class DictRegion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dict_region';
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
    public function getCompanyRegions()
    {
        return $this->hasMany(CompanyRegion::className(), ['region_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuoteCompanies()
    {
        return $this->hasMany(QuoteCompany::className(), ['id' => 'quote_company_id'])->viaTable('company_region', ['region_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDictCountries()
    {
        return $this->hasMany(DictCountry::className(), ['dict_region_id' => 'id']);
    }

    /**
     * @param $companyIDs array
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getRegionsByCompany($companyIDs){
        $regions = implode(',', $companyIDs);
        $sql = 'SELECT d.id, d.name FROM dict_region d LEFT JOIN company_region c ON (d.id=c.region_id)'
            .' WHERE c. quote_company_id IN ('.$regions.') ORDER BY name';

        return DictRegion::findBySql($sql)->all();
    }
}
