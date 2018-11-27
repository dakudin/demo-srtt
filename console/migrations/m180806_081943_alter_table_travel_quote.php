<?php

use yii\db\Migration;

class m180806_081943_alter_table_travel_quote extends Migration
{
    public function safeUp()
    {
        $this->addColumn('travel_quote', 'budget', 'VARCHAR(120) DEFAULT NULL');
    }

    public function safeDown()
    {
        echo "m180806_081943_alter_table_travel_quote cannot be reverted.\n";

        return false;
    }
}
