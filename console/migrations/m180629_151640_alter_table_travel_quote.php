<?php

use yii\db\Migration;

class m180629_151640_alter_table_travel_quote extends Migration
{
    public function safeUp()
    {
        $this->addColumn('travel_quote', 'room_info', 'VARCHAR(1000) NOT NULL');
    }

    public function safeDown()
    {
        $this->dropColumn('travel_quote', 'room_info');

        return false;
    }
}
