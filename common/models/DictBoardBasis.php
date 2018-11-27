<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "dict_board_basis".
 *
 * @property integer $id
 * @property string $name
 *
 * @property CompanyBoardBasis[] $companyBoardBases
 * @property QuoteCompany[] $quoteCompanies
 * @property TravelQuoteBoardBasis[] $travelQuoteBoardBases
 * @property TravelQuote[] $travelQuotes
 */
class DictBoardBasis extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dict_board_basis';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 30],
            [['name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyBoardBases()
    {
        return $this->hasMany(CompanyBoardBasis::className(), ['board_basis_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuoteCompanies()
    {
        return $this->hasMany(QuoteCompany::className(), ['id' => 'quote_company_id'])->viaTable('company_board_basis', ['board_basis_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTravelQuoteBoardBases()
    {
        return $this->hasMany(TravelQuoteBoardBasis::className(), ['dict_board_basis_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTravelQuotes()
    {
        return $this->hasMany(TravelQuote::className(), ['id' => 'travel_quote_id'])->viaTable('travel_quote_board_basis', ['dict_board_basis_id' => 'id']);
    }

    /**
     * @param $companyIDs array
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getBoardBasisByCompany($companyIDs){
        $companies = implode(',', $companyIDs);
        $sql = 'SELECT d.id, d.name FROM dict_board_basis d LEFT JOIN company_board_basis c ON (d.id=c.board_basis_id)'
            .' WHERE c. quote_company_id IN ('.$companies.') ORDER BY name';

        return DictBoardBasis::findBySql($sql)->all();
    }
}
