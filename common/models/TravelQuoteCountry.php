<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "travel_quote_country".
 *
 * @property integer $travel_quote_id
 * @property integer $dict_country_id
 *
 * @property DictCountry $dictCountry
 * @property TravelQuote $travelQuote
 */
class TravelQuoteCountry extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'travel_quote_country';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['travel_quote_id', 'dict_country_id'], 'required'],
            [['travel_quote_id', 'dict_country_id'], 'integer'],
            [['travel_quote_id', 'dict_country_id'], 'unique', 'targetAttribute' => ['travel_quote_id', 'dict_country_id'], 'message' => 'The combination of Travel Quote ID and Dict Country ID has already been taken.'],
            [['dict_country_id'], 'exist', 'skipOnError' => true, 'targetClass' => DictCountry::className(), 'targetAttribute' => ['dict_country_id' => 'id']],
            [['travel_quote_id'], 'exist', 'skipOnError' => true, 'targetClass' => TravelQuote::className(), 'targetAttribute' => ['travel_quote_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'travel_quote_id' => 'Travel Quote ID',
            'dict_country_id' => 'Dict Country ID',
        ];
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
    public function getTravelQuote()
    {
        return $this->hasOne(TravelQuote::className(), ['id' => 'travel_quote_id']);
    }

    /**
     * @param $travelQuoteId int
     * @return int
     */
    public static function deleteAllByTravelQuote($travelQuoteId)
    {
        return TravelQuoteCountry::deleteAll('travel_quote_id = '.$travelQuoteId);
    }


    /**
     * @param $travelQuoteId int
     * @param $dictCountryIDs array|int
     * @throws \yii\db\Exception
     */
    public static function addCountries($travelQuoteId, $dictCountryIDs)
    {
        $rows=[];

        if(is_array($dictCountryIDs) && !in_array(0, $dictCountryIDs)) {
            foreach ($dictCountryIDs as $dictCountryId) {
                $rows[] = [$travelQuoteId, $dictCountryId];
            }
        }elseif(!is_null($dictCountryIDs) && !is_array($dictCountryIDs) && $dictCountryIDs!=0){
            $rows[] = [$travelQuoteId, (int)$dictCountryIDs];
        }

        if(count($rows)>0){
            Yii::$app->db->createCommand()->
            batchInsert(self::tableName(), ['travel_quote_id', 'dict_country_id'], $rows)->execute();
        }
    }

}
