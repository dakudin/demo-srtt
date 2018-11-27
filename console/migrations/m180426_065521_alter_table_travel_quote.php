<?php

use yii\db\Migration;

class m180426_065521_alter_table_travel_quote extends Migration
{
    public function safeUp()
    {
        $this->addColumn('travel_quote', 'username', 'VARCHAR(255) NOT NULL');
        $this->addColumn('travel_quote', 'email', 'VARCHAR(255) NOT NULL');
        $this->addColumn('travel_quote', 'phone', 'VARCHAR(20)');
    }

    public function safeDown()
    {
        echo "m180426_065521_alter_table_travel_quote cannot be reverted.\n";

        return false;
    }
}
