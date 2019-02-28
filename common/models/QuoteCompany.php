<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "quote_company".
 *
 * @property integer $id
 * @property string $image
 * @property string $company_name
 * @property string $info
 * @property string $method_name
 *
 * @property QuoteResponse[] $quoteResponses
 */
class QuoteCompany extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quote_company';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['image'], 'required'],
            [['image', 'company_name', 'method_name'], 'string', 'max' => 50],
            [['company_name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'image' => 'Image',
            'company_name' => 'Company Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuoteResponses()
    {
        return $this->hasMany(QuoteResponse::className(), ['quote_company_id' => 'id']);
    }

    public function getFullImage()
    {
        return Yii::$app->params['domainName'] . '/images/companies/' . $this->image;
    }


    /**
     * @param $categoryId
     * @return array
     */
    public static function getCompaniesWithRatingByCategory($categoryId)
    {
        $sql =
            'SELECT
              q.id, q.image, q.company_name, q.info,
              r.reviews,
              ROUND(r.sum_review / r.reviews , 2) as rating
            FROM
              quote_company q
              JOIN (SELECT quote_company_id FROM quote_company_category WHERE enquiry_category_id=:categoryId) cc ON (q.id=cc.quote_company_id)
              LEFT JOIN (SELECT quote_company_id, COUNT(id) as reviews, SUM(rating) as sum_review FROM company_rating GROUP BY quote_company_id) r ON (q.id=r.quote_company_id)
            ORDER BY rating DESC';

        return Yii::$app->db->createCommand($sql)
            ->bindValue(':categoryId', $categoryId)
            ->queryAll();
    }
}
