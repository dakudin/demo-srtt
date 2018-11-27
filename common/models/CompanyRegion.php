<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "company_region".
 *
 * @property integer $quote_company_id
 * @property integer $region_id
 * @property string $service_region_id
 *
 * @property DictRegion $region
 * @property QuoteCompany $quoteCompany
 */
class CompanyRegion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'company_region';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['quote_company_id', 'region_id', 'service_region_id'], 'required'],
            [['quote_company_id', 'region_id'], 'integer'],
            [['service_region_id'], 'string', 'max' => 10],
            [['quote_company_id', 'region_id'], 'unique', 'targetAttribute' => ['quote_company_id', 'region_id'], 'message' => 'The combination of Quote Company ID and Region ID has already been taken.'],
            [['region_id'], 'exist', 'skipOnError' => true, 'targetClass' => DictRegion::className(), 'targetAttribute' => ['region_id' => 'id']],
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
            'region_id' => 'Region ID',
            'service_region_id' => 'Service Region ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegion()
    {
        return $this->hasOne(DictRegion::className(), ['id' => 'region_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuoteCompany()
    {
        return $this->hasOne(QuoteCompany::className(), ['id' => 'quote_company_id']);
    }

    /**
     * Return list of countries by company and regions
     * @param $companyId int
     * @param $regionIDs array
     * @return array
     */
    public static function getCompanyServiceCountriesID($companyId, $regionIDs)
    {
        $regionIDs = implode(',', $regionIDs);
        $sql = 'SELECT c.service_country_id FROM company_country c LEFT JOIN dict_country dc ON (dc.id=c.country_id)'
            .' WHERE c.quote_company_id=:companyId AND dc.dict_region_id IN ('.$regionIDs.')';

        $countriesID = Yii::$app->db->createCommand($sql)
            ->bindValue(':companyId', $companyId)
            ->queryAll();

        return $countriesID;
    }

    /**
     * Return list of resorts by company and regions
     * @param $companyId
     * @param $regionIDs
     * @return array
     */
    public static function getCompanyServiceResortsID($companyId, $regionIDs)
    {
        $regionIDs = implode(',', $regionIDs);

        $sql = ' SELECT cr.service_resort_id FROM company_resort cr
                 LEFT JOIN dict_resort dr ON (dr.id=cr.resort_id)
                 LEFT JOIN dict_country dc ON (dr.dict_country_id=dc.id)
                 WHERE cr.quote_company_id=:companyId AND dr.dict_country_id=dc.id AND dc.dict_region_id IN ('.$regionIDs.') ';

        $resortsID = Yii::$app->db->createCommand($sql)
            ->bindValue(':companyId', $companyId)
            ->queryAll();

        return $resortsID;
    }

}
