<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "travel_quote_region".
 *
 * @property integer $travel_quote_id
 * @property integer $dict_region_id
 *
 * @property DictRegion $dictRegion
 * @property TravelQuote $travelQuote
 */
class TravelQuoteRegion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'travel_quote_region';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['travel_quote_id', 'dict_region_id'], 'required'],
            [['travel_quote_id', 'dict_region_id'], 'integer'],
            [['travel_quote_id', 'dict_region_id'], 'unique', 'targetAttribute' => ['travel_quote_id', 'dict_region_id'], 'message' => 'The combination of Travel Quote ID and Dict Region ID has already been taken.'],
            [['dict_region_id'], 'exist', 'skipOnError' => true, 'targetClass' => DictRegion::className(), 'targetAttribute' => ['dict_region_id' => 'id']],
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
            'dict_region_id' => 'Dict Region ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDictRegion()
    {
        return $this->hasOne(DictRegion::className(), ['id' => 'dict_region_id']);
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
        return TravelQuoteRegion::deleteAll('travel_quote_id = '.$travelQuoteId);
    }


    /**
     * @param $travelQuoteId int
     * @param $dictRegionIDs array|int
     * @throws \yii\db\Exception
     */
    public static function addRegions($travelQuoteId, $dictRegionIDs)
    {
        $rows=[];

        if(is_array($dictRegionIDs) && !in_array('0', $dictRegionIDs)) {
            foreach ($dictRegionIDs as $dictRegionId) {
                $rows[] = [$travelQuoteId, (int)$dictRegionId];
            }
        }elseif(!is_null($dictRegionIDs) && !is_array($dictRegionIDs) && $dictRegionIDs!=0){
            $rows[] = [$travelQuoteId, (int)$dictRegionIDs];
        }

        if(count($rows)>0){
            Yii::$app->db->createCommand()->
            batchInsert(self::tableName(), ['travel_quote_id', 'dict_region_id'], $rows)->execute();
        }
    }

}
