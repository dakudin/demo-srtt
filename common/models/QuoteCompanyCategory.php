<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "quote_company_category".
 *
 * @property integer $id
 * @property integer $quote_company_id
 * @property integer $enquiry_category_id
 *
 * @property EnquiryCategory $enquiryCategory
 * @property QuoteCompany $quoteCompany
 */
class QuoteCompanyCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quote_company_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['quote_company_id', 'enquiry_category_id'], 'required'],
            [['quote_company_id', 'enquiry_category_id'], 'integer'],
            [['quote_company_id', 'enquiry_category_id'], 'unique', 'targetAttribute' => ['quote_company_id', 'enquiry_category_id'], 'message' => 'The combination of Quote Company ID and Enquiry Category ID has already been taken.'],
            [['enquiry_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => EnquiryCategory::className(), 'targetAttribute' => ['enquiry_category_id' => 'id']],
            [['quote_company_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuoteCompany::className(), 'targetAttribute' => ['quote_company_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'quote_company_id' => 'Quote Company ID',
            'enquiry_category_id' => 'Enquiry Category ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEnquiryCategory()
    {
        return $this->hasOne(EnquiryCategory::className(), ['id' => 'enquiry_category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuoteCompany()
    {
        return $this->hasOne(QuoteCompany::className(), ['id' => 'quote_company_id']);
    }
}
