<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "travel_quote_hotel_grade".
 *
 * @property integer $travel_quote_id
 * @property integer $dict_hotel_grade_id
 *
 * @property DictHotelGrade $dictHotelGrade
 * @property TravelQuote $travelQuote
 */
class TravelQuoteHotelGrade extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'travel_quote_hotel_grade';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['travel_quote_id', 'dict_hotel_grade_id'], 'required'],
            [['travel_quote_id', 'dict_hotel_grade_id'], 'integer'],
            [['travel_quote_id', 'dict_hotel_grade_id'], 'unique', 'targetAttribute' => ['travel_quote_id', 'dict_hotel_grade_id'], 'message' => 'The combination of Travel Quote ID and Dict Hotel Grade ID has already been taken.'],
            [['dict_hotel_grade_id'], 'exist', 'skipOnError' => true, 'targetClass' => DictHotelGrade::className(), 'targetAttribute' => ['dict_hotel_grade_id' => 'id']],
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
            'dict_hotel_grade_id' => 'Dict Hotel Grade ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDictHotelGrade()
    {
        return $this->hasOne(DictHotelGrade::className(), ['id' => 'dict_hotel_grade_id']);
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
        return TravelQuoteHotelGrade::deleteAll('travel_quote_id = '.$travelQuoteId);
    }

    /**
     * @param $travelQuoteId int
     * @param $dictHotelGradeIDs array
     * @throws \yii\db\Exception
     */
    public static function addHotelGrades($travelQuoteId, $dictHotelGradeIDs)
    {
        $rows=[];

        if(is_array($dictHotelGradeIDs) && !in_array(0, $dictHotelGradeIDs)) {
            foreach ($dictHotelGradeIDs as $dictHotelGradeID) {
                $rows[] = [$travelQuoteId, $dictHotelGradeID];
            }
        }

        if(count($rows)>0){
            Yii::$app->db->createCommand()->
            batchInsert(self::tableName(), ['travel_quote_id', 'dict_hotel_grade_id'], $rows)->execute();
        }
    }
}
