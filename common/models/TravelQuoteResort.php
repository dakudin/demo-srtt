<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "travel_quote_resort".
 *
 * @property integer $travel_quote_id
 * @property integer $dict_resort_id
 *
 * @property DictResort $dictResort
 * @property TravelQuote $travelQuote
 */
class TravelQuoteResort extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'travel_quote_resort';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['travel_quote_id', 'dict_resort_id'], 'required'],
            [['travel_quote_id', 'dict_resort_id'], 'integer'],
            [['travel_quote_id', 'dict_resort_id'], 'unique', 'targetAttribute' => ['travel_quote_id', 'dict_resort_id'], 'message' => 'The combination of Travel Quote ID and Dict Resort ID has already been taken.'],
            [['dict_resort_id'], 'exist', 'skipOnError' => true, 'targetClass' => DictResort::className(), 'targetAttribute' => ['dict_resort_id' => 'id']],
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
            'dict_resort_id' => 'Dict Resort ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDictResort()
    {
        return $this->hasOne(DictResort::className(), ['id' => 'dict_resort_id']);
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
        return TravelQuoteResort::deleteAll('travel_quote_id = '.$travelQuoteId);
    }


    /**
     * @param $travelQuoteId int
     * @param $dictResortIDs array|int
     * @throws \yii\db\Exception
     */
    public static function addResorts($travelQuoteId, $dictResortIDs)
    {
        $rows=[];

        if(is_array($dictResortIDs) && !in_array(0, $dictResortIDs)) {
            foreach ($dictResortIDs as $dictResortId) {
                $rows[] = [$travelQuoteId, $dictResortId];
            }
        }elseif(!is_null($dictResortIDs) && !is_array($dictResortIDs) && $dictResortIDs!=0){
            $rows[] = [$travelQuoteId, (int)$dictResortIDs];
        }

        if(count($rows)>0){
            Yii::$app->db->createCommand()->
                batchInsert(self::tableName(), ['travel_quote_id', 'dict_resort_id'], $rows)->execute();
        }
    }

}
