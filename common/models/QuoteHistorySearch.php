<?php
/**
 * Created by PhpStorm.
 * User: Monk
 * Date: 28.02.2019
 * Time: 21:44
 */

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\db\ActiveQuery;
use yii\db\Query;

class QuoteHistorySearch extends TravelQuote
{

    // these fields can be used for filtering
    public function rules()
    {
        return [

        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $queryTravel = TravelQuote::find()->joinWith('enquiryCategory')->where(['user_id' => \Yii::$app->user->id]);
        // $queryCar = CarQuote::find()->with('enquiry_category');

        $query = (new ActiveQuery(TravelQuote::className()))->from([
            'quote_history' => $queryTravel
//            'quote_history' => $queryTravel->union($queryCar)
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC]
            ]
        ]);

        if(!($this->load($params) && $this->validate())){
            return $dataProvider;
        }

//        $query->andFilterWhere(['like', ])

        return $dataProvider;
    }

    public function getNotRatedQuotes()
    {
        $queryTravel = TravelQuote::find()->joinWith(['enquiryCategory', 'user'])->
            where([
                'travel_quote.is_rate_email_sent' => 0,
                'travel_quote.is_rated' => 0,
                'enquiry_category.is_active' => 1,
                'user.status' => User::STATUS_ACTIVE,
            ])->andWhere(['not', ['enquiry_category.enquiry_class_name' => null]]);
        // $queryCar = CarQuote::find()->with('enquiry_category');

        $query = (new ActiveQuery(TravelQuote::className()))->from([
            'quote_history' => $queryTravel
//            'quote_history' => $queryTravel->union($queryCar)
        ])->with(['enquiryCategory', 'user']);

        $rows = $query->all();
        return $rows;
    }

}