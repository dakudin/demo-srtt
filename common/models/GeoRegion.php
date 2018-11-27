<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "geo_region".
 *
 * @property string $country_code
 * @property string $region_code
 * @property string $name
 */
class GeoRegion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'geo_region';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['country_code', 'region_code', 'name'], 'required'],
            [['country_code', 'region_code'], 'string', 'max' => 2],
            [['name'], 'string', 'max' => 100],
            [['country_code', 'region_code'], 'unique', 'targetAttribute' => ['country_code', 'region_code'], 'message' => 'The combination of Country Code and Region Code has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'country_code' => 'Country Code',
            'region_code' => 'Region Code',
            'name' => 'Name',
        ];
    }
}
