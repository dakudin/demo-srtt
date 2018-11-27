<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "company_country".
 *
 * @property integer $quote_company_id
 * @property integer $country_id
 * @property string $service_country_id
 *
 * @property DictCountry $country
 * @property QuoteCompany $quoteCompany
 */
class CompanyCountry extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'company_country';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['quote_company_id', 'country_id', 'service_country_id'], 'required'],
            [['quote_company_id', 'country_id'], 'integer'],
            ['service_country_id', 'string', 'max' => 10],
            [['quote_company_id', 'country_id'], 'unique', 'targetAttribute' => ['quote_company_id', 'country_id'], 'message' => 'The combination of Quote Company ID and Country ID has already been taken.'],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => DictCountry::className(), 'targetAttribute' => ['country_id' => 'id']],
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
            'country_id' => 'Country ID',
            'service_country_id' => 'Service Country ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(DictCountry::className(), ['id' => 'country_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuoteCompany()
    {
        return $this->hasOne(QuoteCompany::className(), ['id' => 'quote_company_id']);
    }

    /**
     * @param $companyId int
     * @param $countryIDs array
     * @return array
     */
    public static function getCompanyServiceResortsID($companyId, $countryIDs)
    {
        $countryIDs = implode(',', $countryIDs);
        $sql = 'SELECT cr.service_resort_id FROM company_resort cr LEFT JOIN dict_resort dr ON (dr.id=cr.resort_id)'
            .' WHERE cr.quote_company_id=:companyId AND dr.dict_country_id IN ('.$countryIDs.')';

        $resorts = Yii::$app->db->createCommand($sql)
            ->bindValue(':companyId', $companyId)
            ->queryAll();

        return $resorts;
    }
}
