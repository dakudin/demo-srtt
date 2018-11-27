<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "company_board_basis".
 *
 * @property integer $quote_company_id
 * @property integer $board_basis_id
 * @property string $service_board_basis_id
 *
 * @property DictBoardBasis $boardBasis
 * @property QuoteCompany $quoteCompany
 */
class CompanyBoardBasis extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'company_board_basis';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['quote_company_id', 'board_basis_id', 'service_board_basis_id'], 'required'],
            [['quote_company_id', 'board_basis_id'], 'integer'],
            [['service_board_basis_id'], 'string', 'max' => 10],
            [['quote_company_id', 'board_basis_id'], 'unique', 'targetAttribute' => ['quote_company_id', 'board_basis_id'], 'message' => 'The combination of Quote Company ID and Board Basis ID has already been taken.'],
            [['board_basis_id'], 'exist', 'skipOnError' => true, 'targetClass' => DictBoardBasis::className(), 'targetAttribute' => ['board_basis_id' => 'id']],
            [['quote_company_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuoteCompany::className(), 'targetAttribute' => ['quote_company_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'quote_company_id' => 'Quote Company ID',
            'board_basis_id' => 'Board Basis ID',
            'service_board_basis_id' => 'Service Board Basis ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBoardBasis()
    {
        return $this->hasOne(DictBoardBasis::className(), ['id' => 'board_basis_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuoteCompany()
    {
        return $this->hasOne(QuoteCompany::className(), ['id' => 'quote_company_id']);
    }
}
