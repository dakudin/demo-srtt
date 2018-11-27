<?php

use yii\db\Migration;

class m171011_100617_alter_table_travel_quote extends Migration
{
    public function safeUp()
    {
        $this->addColumn('travel_quote', 'details', 'text DEFAULT NULL');
        $this->addColumn('travel_quote', 'parsed_results', 'text DEFAULT NULL');
    }

    public function safeDown()
    {
        $this->dropColumn('travel_quote', 'details');
        $this->dropColumn('travel_quote', 'parsed_results');
    }
}
