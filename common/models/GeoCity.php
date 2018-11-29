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

    public static function getCitiesByName($name = null, $limit = 10)
    {
        return Yii::$app->db->createCommand(
                'SELECT DISTINCT accent_city FROM geo_city WHERE accent_city LIKE :name
                ORDER BY accent_city LIMIT :limit')
            ->bindValue(':name', $name.'%')
            ->bindValue(':limit', $limit)
            ->queryAll();
    }
}
