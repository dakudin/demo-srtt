<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "company_rating".
 *
 * @property integer $id
 * @property double $rating
 * @property integer $quote_company_id
 * @property integer $travel_quote_id
 *
 * @property QuoteCompany $quoteCompany
 * @property TravelQuote $travelQuote
 */
class CompanyRating extends \yii\db\ActiveRecord
{
    const RATE_POOR = 2.5;
    const RATE_NEUTRAL = 5;
    const RATE_GOOD = 7.5;
    const RATE_EXCELLENT = 10;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'company_rating';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rating'], 'number'],
            [['rating'], 'in', 'range' => [self::RATE_POOR, self::RATE_NEUTRAL, self::RATE_GOOD, self::RATE_EXCELLENT]],
            [['quote_company_id', 'rating'], 'required'],
            [['quote_company_id', 'travel_quote_id'], 'integer'],
            [['quote_company_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuoteCompany::className(), 'targetAttribute' => ['quote_company_id' => 'id']],
            [['travel_quote_id'], 'exist', 'skipOnError' => true, 'targetClass' => TravelQuote::className(), 'targetAttribute' => ['travel_quote_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'rating' => 'Rating',
            'quote_company_id' => 'Quote Company ID',
            'travel_quote_id' => 'Travel Quote ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuoteCompany()
    {
        return $this->hasOne(QuoteCompany::className(), ['id' => 'quote_company_id']); //->inverseOf('companyRatings');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTravelQuote()
    {
        return $this->hasOne(TravelQuote::className(), ['id' => 'travel_quote_id']);
    }

    /**
     * @param $review
     * @return string
     */
    public static function getReviewCaption($review)
    {
        if(empty($review))
            return 'no reviews';
        elseif($review == 1){
            return '1 review';
        }else{
            return $review . ' reviews';
        }
    }
}
