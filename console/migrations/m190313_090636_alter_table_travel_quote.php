<?php

use yii\db\Migration;

class m190313_090636_alter_table_travel_quote extends Migration
{
    public function safeUp()
    {
        $this->addColumn('travel_quote', 'created_at', 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP');
    }

    public function safeDown()
    {
        $this->dropColumn('travel_quote', 'created_at');
    }
}
