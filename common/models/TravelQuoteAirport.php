<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "travel_quote_airport".
 *
 * @property integer $travel_quote_id
 * @property integer $dict_airport_id
 *
 * @property DictAirport $dictAirport
 * @property TravelQuote $travelQuote
 */
class TravelQuoteAirport extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'travel_quote_airport';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['travel_quote_id', 'dict_airport_id'], 'required'],
            [['travel_quote_id', 'dict_airport_id'], 'integer'],
            [['travel_quote_id', 'dict_airport_id'], 'unique', 'targetAttribute' => ['travel_quote_id', 'dict_airport_id'], 'message' => 'The combination of Travel Quote ID and Dict Airport ID has already been taken.'],
            [['dict_airport_id'], 'exist', 'skipOnError' => true, 'targetClass' => DictAirport::className(), 'targetAttribute' => ['dict_airport_id' => 'id']],
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
            'dict_airport_id' => 'Dict Airport ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDictAirport()
    {
        return $this->hasOne(DictAirport::className(), ['id' => 'dict_airport_id']);
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
        return TravelQuoteAirport::deleteAll('travel_quote_id = '.$travelQuoteId);
    }

    /**
     * @param $travelQuoteId int
     * @param $dictAirportIDs array|int
     * @throws \yii\db\Exception
     */
    public static function addAirports($travelQuoteId, $dictAirportIDs)
    {
        $rows=[];

        if(is_array($dictAirportIDs) && !in_array(0, $dictAirportIDs)) {
            foreach ($dictAirportIDs as $dictAirportId) {
                $rows[] = [$travelQuoteId, $dictAirportId];
            }
        }elseif(!is_null($dictAirportIDs) && !is_array($dictAirportIDs) && $dictAirportIDs!=0){
            $rows[] = [$travelQuoteId, (int)$dictAirportIDs];
        }

        if(count($rows)>0){
            Yii::$app->db->createCommand()->
                batchInsert(self::tableName(), ['travel_quote_id', 'dict_airport_id'], $rows)->execute();
        }
    }
}
