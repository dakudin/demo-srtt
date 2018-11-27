<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "quote_company".
 *
 * @property integer $id
 * @property string $image
 * @property string $company_name
 *
 * @property QuoteResponse[] $quoteResponses
 */
class QuoteCompany extends \yii\db\ActiveRecord
{
    public static $SkiKingsCompany = 4;
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
            [['image', 'company_name'], 'string', 'max' => 50],
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
}
