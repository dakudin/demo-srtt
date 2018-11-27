<?php

use yii\db\Migration;

class m181004_143949_alter_user_add_contact_info extends Migration
{
    public function safeUp()
    {
        $this->addColumn('user', 'contact_email', 'VARCHAR(255)');
        $this->addColumn('user', 'contact_phone', 'VARCHAR(20)');

        $this->addColumn('user', 'user_title', "ENUM('Mr', 'Mrs', 'Miss', 'Ms') NOT NULL DEFAULT 'Mr'");
        $this->addColumn('user', 'user_first_name', 'VARCHAR(50)');
        $this->addColumn('user', 'user_last_name', 'VARCHAR(50)');

        $this->addColumn('user', 'address_street', 'VARCHAR(100)');
        $this->addColumn('user', 'address_town', 'VARCHAR(100)');
        $this->addColumn('user', 'address_county', 'VARCHAR(100)');
        $this->addColumn('user', 'address_postcode', 'VARCHAR(8)');

        $this->execute('DELETE FROM travel_quote');
        $this->addColumn('travel_quote', 'user_id', $this->integer()->notNull()->after('id'));
        $this->createIndex('idx_user', 'travel_quote', 'user_id');
        $this->addForeignKey('fk_travel_quote2user', 'travel_quote', 'user_id', 'user', 'id');
    }

    public function safeDown()
    {
        echo "m181004_143949_alter_user_add_contact_info cannot be reverted.\n";

        return false;
    }
}
