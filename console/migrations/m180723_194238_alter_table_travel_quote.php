<?php

use yii\db\Migration;

class m180723_194238_alter_table_travel_quote extends Migration
{
    public function safeUp()
    {
        $this->addColumn('travel_quote', 'flight_category', "ENUM('economy', 'premium', 'business') NOT NULL");

    }

    public function safeDown()
    {
        echo "m180723_194238_alter_table_travel_quote cannot be reverted.\n";

        return false;
    }
}
