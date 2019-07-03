<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "quote_company_destination".
 *
 * @property integer $id
 * @property integer $quote_company_id
 * @property string $destination_value
 * @property string $geo_country
 * @property string $geo_country_code
 * @property string $geo_city
 * @property string $geo_region
 */
class QuoteCompanyDestination extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quote_company_destination';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['quote_company_id', 'destination_value'], 'required'],
            [['quote_company_id'], 'integer'],
            [['destination_value', 'geo_country', 'geo_region'], 'string', 'max' => 100],
            [['geo_country_code'], 'string', 'max' => 2],
            [['geo_city'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'quote_company_id' => 'Quote Company ID',
            'destination_value' => 'Destination Value',
            'geo_country' => 'Geo Country',
            'geo_country_code' => 'Geo Country Code',
            'geo_city' => 'Geo City',
            'geo_region' => 'Geo Region',
        ];
    }

    public static function getDestinationValue($companyId, $city, $region, $country)
    {
        // find by country only
        if(empty($city) && empty($region) && !empty($country)) {
            $model = QuoteCompanyDestination::find()
                ->select('destination_value')
                ->andWhere([
                    'quote_company_id' => $companyId,
                    'geo_country' => $country,
                    'geo_city' => '',
                    'geo_region' => '',
                ])
                ->limit(1)
                ->one();

            if($model)
                return $model->destination_value;
        }
        // find by country and city or region
        if((!empty($city) || !empty($region)) && !empty($country)) {
            $model = QuoteCompanyDestination::find()
                ->select('destination_value')
                ->andWhere([
                    'quote_company_id' => $companyId,
                    'geo_country' => $country,
                ])
                ->andWhere([
                    'or',
                    ['geo_city' => $city],
                    ['geo_region' => $region]
                ])
                ->limit(1)
                ->one();

            if($model)
                return $model->destination_value;
        }

        return false;
    }
}
