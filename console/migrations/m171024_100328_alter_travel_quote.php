<?php

use yii\db\Migration;

class m171024_100328_alter_travel_quote extends Migration
{
    public function safeUp()
    {
        $this->addColumn('travel_quote', 'region_id', 'INT(11) DEFAULT NULL AFTER id');

        $this->createIndex('idx_region', 'travel_quote', 'region_id');

        $this->addForeignKey('fk_travel_quote2dict_region', 'travel_quote', 'region_id', 'dict_region', 'id');
    }

    public function safeDown()
    {
        echo "m171024_100328_alter_travel_quote cannot be reverted.\n";

        return false;
    }
}
