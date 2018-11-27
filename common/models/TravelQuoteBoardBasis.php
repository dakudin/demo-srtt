<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "travel_quote_board_basis".
 *
 * @property integer $travel_quote_id
 * @property integer $dict_board_basis_id
 *
 * @property DictBoardBasis $dictBoardBasis
 * @property TravelQuote $travelQuote
 */
class TravelQuoteBoardBasis extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'travel_quote_board_basis';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['travel_quote_id', 'dict_board_basis_id'], 'required'],
            [['travel_quote_id', 'dict_board_basis_id'], 'integer'],
            [['travel_quote_id', 'dict_board_basis_id'], 'unique', 'targetAttribute' => ['travel_quote_id', 'dict_board_basis_id'], 'message' => 'The combination of Travel Quote ID and Dict Board Basis ID has already been taken.'],
            [['dict_board_basis_id'], 'exist', 'skipOnError' => true, 'targetClass' => DictBoardBasis::className(), 'targetAttribute' => ['dict_board_basis_id' => 'id']],
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
            'dict_board_basis_id' => 'Dict Board Basis ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDictBoardBasis()
    {
        return $this->hasOne(DictBoardBasis::className(), ['id' => 'dict_board_basis_id']);
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
        return TravelQuoteBoardBasis::deleteAll('travel_quote_id = '.$travelQuoteId);
    }

    /**
     * @param $travelQuoteId int
     * @param $dictBoardBasisIDs array
     * @throws \yii\db\Exception
     */
    public static function addBoardBasis($travelQuoteId, $dictBoardBasisIDs)
    {
        $rows=[];

        if(is_array($dictBoardBasisIDs) && !in_array(0, $dictBoardBasisIDs)) {
            foreach ($dictBoardBasisIDs as $dictBoardBasisID) {
                $rows[] = [$travelQuoteId, $dictBoardBasisID];
            }
        }

        if(count($rows)>0){
            Yii::$app->db->createCommand()->
            batchInsert(self::tableName(), ['travel_quote_id', 'dict_board_basis_id'], $rows)->execute();
        }
    }
}
