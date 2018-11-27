<?php

use yii\db\Migration;

class m171030_083327_add_ability_multiple_selection extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->execute('DELETE FROM travel_quote');

        $this->dropForeignKey('fk_travel_quote2dict_airport', 'travel_quote');
        $this->dropForeignKey('fk_travel_quote2dict_country', 'travel_quote');
        $this->dropForeignKey('fk_travel_quote2dict_region', 'travel_quote');
        $this->dropForeignKey('fk_travel_quote2dict_resort', 'travel_quote');

        $this->dropColumn('travel_quote', 'region_id');
        $this->dropColumn('travel_quote', 'country_id');
        $this->dropColumn('travel_quote', 'resort_id');
        $this->dropColumn('travel_quote', 'airport_id');

        $this->createTable('travel_quote_country', [
            'travel_quote_id' => 'INTEGER(11) NOT NULL',
            'dict_country_id' => 'INTEGER(11) NOT NULL',
        ], $tableOptions);

        $this->createIndex('uk_travel_quote_country', 'travel_quote_country', ['travel_quote_id', 'dict_country_id'], TRUE);
        $this->createIndex('idx_travel_quote_id', 'travel_quote_country', 'travel_quote_id');
        $this->addForeignKey('fk_travel_quote_country2dict_country' , 'travel_quote_country', 'dict_country_id', 'dict_country', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_travel_quote_country2travel_quote' , 'travel_quote_country', 'travel_quote_id', 'travel_quote', 'id', 'CASCADE', 'CASCADE');

        $this->createTable('travel_quote_region', [
            'travel_quote_id' => 'INTEGER(11) NOT NULL',
            'dict_region_id' => 'INTEGER(11) NOT NULL',
        ], $tableOptions);

        $this->createIndex('uk_travel_quote_region', 'travel_quote_region', ['travel_quote_id', 'dict_region_id'], TRUE);
        $this->createIndex('idx_travel_quote_id', 'travel_quote_region', 'travel_quote_id');
        $this->addForeignKey('fk_travel_quote_region2dict_region' , 'travel_quote_region', 'dict_region_id', 'dict_region', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_travel_quote_region2travel_quote' , 'travel_quote_region', 'travel_quote_id', 'travel_quote', 'id', 'CASCADE', 'CASCADE');

        $this->createTable('travel_quote_resort', [
            'travel_quote_id' => 'INTEGER(11) NOT NULL',
            'dict_resort_id' => 'INTEGER(11) NOT NULL',
        ], $tableOptions);

        $this->createIndex('uk_travel_quote_resort', 'travel_quote_resort', ['travel_quote_id', 'dict_resort_id'], TRUE);
        $this->createIndex('idx_travel_quote_id', 'travel_quote_resort', 'travel_quote_id');
        $this->addForeignKey('fk_travel_quote_resort2dict_resort' , 'travel_quote_resort', 'dict_resort_id', 'dict_resort', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_travel_quote_resort2travel_quote' , 'travel_quote_resort', 'travel_quote_id', 'travel_quote', 'id', 'CASCADE', 'CASCADE');

        $this->createTable('travel_quote_airport', [
            'travel_quote_id' => 'INTEGER(11) NOT NULL',
            'dict_airport_id' => 'INTEGER(11) NOT NULL',
        ], $tableOptions);

        $this->createIndex('uk_travel_quote_airport', 'travel_quote_airport', ['travel_quote_id', 'dict_airport_id'], TRUE);
        $this->createIndex('idx_travel_quote_id', 'travel_quote_airport', 'travel_quote_id');
        $this->addForeignKey('fk_travel_quote_airport2dict_airport' , 'travel_quote_airport', 'dict_airport_id', 'dict_airport', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_travel_quote_airport2travel_quote' , 'travel_quote_airport', 'travel_quote_id', 'travel_quote', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        echo "m171030_083327_add_ability_multiple_selection cannot be reverted.\n";

        return false;
    }
}
