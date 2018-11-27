<?php

use yii\db\Migration;

class m180720_085815_modify_table_travel_quote extends Migration
{
    public function safeUp()
    {
        $this->execute('DELETE FROM travel_quote');

        $this->addColumn('travel_quote', 'user_title', "ENUM('Mr', 'Mrs', 'Miss', 'Ms') NOT NULL");

        $this->addColumn('travel_quote', 'user_first_name', 'VARCHAR(50) NOT NULL');
        $this->addColumn('travel_quote', 'user_last_name', 'VARCHAR(50) NOT NULL');
        $this->dropColumn('travel_quote', 'username');

        $this->addColumn('travel_quote', 'address_street', 'VARCHAR(100)');
        $this->addColumn('travel_quote', 'address_town', 'VARCHAR(100)');
        $this->addColumn('travel_quote', 'address_county', 'VARCHAR(100)');
        $this->addColumn('travel_quote', 'address_postcode', 'VARCHAR(8)');
    }

    public function safeDown()
    {
        echo "m180720_085815_modify_table_travel_quote cannot be reverted.\n";

        return false;
    }
}
