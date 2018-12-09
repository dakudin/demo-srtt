<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "geo_city".
 *
 * @property string $country
 * @property string $city
 * @property string $accent_city
 * @property string $region
 * @property integer $population
 * @property double $latitude
 * @property double $longitude
 */
class GeoCity extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'geo_city';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['country', 'city', 'accent_city', 'region', 'latitude', 'longitude'], 'required'],
            [['population'], 'integer'],
            [['latitude', 'longitude'], 'number'],
            [['country', 'region'], 'string', 'max' => 2],
            [['city', 'accent_city'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'country' => 'Country',
            'city' => 'City',
            'accent_city' => 'Accent City',
            'region' => 'Region',
            'population' => 'Population',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
        ];
    }

    public static function getCitiesByName($name = null, $country = null, $limit = 10)
    {
        if(empty($country))
            return Yii::$app->db->createCommand(
                    'SELECT DISTINCT accent_city FROM geo_city WHERE accent_city LIKE :name ORDER BY accent_city LIMIT :limit')
                ->bindValue(':name', $name.'%')
                ->bindValue(':limit', $limit)
                ->queryAll();
        else {
            return Yii::$app->db->createCommand(
                'SELECT DISTINCT c.accent_city FROM geo_city c, geo_country cn WHERE cn.country_name=:country AND '
                    .'cn.country_code=c.country AND c.accent_city LIKE :name ORDER BY accent_city LIMIT :limit')
                ->bindValue(':country', $country)
                ->bindValue(':name', $name.'%')
                ->bindValue(':limit', $limit)
                ->queryAll();
        }
    }
}
