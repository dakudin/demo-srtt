<?php

use yii\db\Migration;

class m181122_114713_alter_table_travel_quote extends Migration
{
    public function safeUp()
    {
        $this->addColumn('travel_quote', 'country', 'VARCHAR(100) DEFAULT NULL');
        $this->addColumn('travel_quote', 'city', 'VARCHAR(100) DEFAULT NULL');
        $this->addColumn('travel_quote', 'airport', 'VARCHAR(100) DEFAULT NULL');
    }

    public function safeDown()
    {
        $this->dropColumn('travel_quote', 'country');
        $this->dropColumn('travel_quote', 'city');
        $this->dropColumn('travel_quote', 'airport');
    }
}
