<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "geo_country".
 *
 * @property string $continent_code
 * @property string $continent_name
 * @property string $country_code
 * @property string $country_name
 * @property integer $is_in_european_union
 */
class GeoCountry extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'geo_country';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['continent_code', 'continent_name', 'country_code', 'country_name', 'is_in_european_union'], 'required'],
            [['is_in_european_union'], 'integer'],
            [['continent_code', 'country_code'], 'string', 'max' => 2],
            [['continent_name'], 'string', 'max' => 50],
            [['country_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'continent_code' => 'Continent Code',
            'continent_name' => 'Continent Name',
            'country_code' => 'Country Code',
            'country_name' => 'Country Name',
            'is_in_european_union' => 'Is In European Union',
        ];
    }

    public static function getCountriesByName($name = null, $limit = 10)
    {
        return Yii::$app->db->createCommand('SELECT country_name FROM geo_country WHERE country_name LIKE :name ORDER BY country_name LIMIT :limit')
            ->bindValue(':name', '%'.$name.'%')
            ->bindValue(':limit', $limit)
            ->queryAll();
    }
}
