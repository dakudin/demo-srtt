<?php

use yii\db\Migration;

class m190221_221502_add_classname2quote_company extends Migration
{
    public function safeUp()
    {
        $this->addColumn('quote_company', 'method_name', "VARCHAR(50) NOT NULL DEFAULT ''");
        $this->update('quote_company', ['method_name' => 'createQuoteEShores'], 'id=6');
        $this->update('quote_company', ['method_name' => 'createQuoteDesignTravel'], 'id=7');
        $this->update('quote_company', ['method_name' => 'createQuoteTravelCounsellors'], 'id=8');
    }

    public function safeDown()
    {
        echo "m190221_221502_add_classname2quote_company cannot be reverted.\n";

        return false;
    }
}
