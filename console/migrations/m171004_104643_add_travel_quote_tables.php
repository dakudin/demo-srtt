<?php

use yii\db\Migration;

class m171004_104643_add_travel_quote_tables extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('company_country', [
            'quote_company_id' => $this->integer(11)->notNull(),
            'country_id' => $this->integer(11)->notNull(),
            'service_country_id' => $this->integer(11)->notNull()
        ], $tableOptions);

        $this->createIndex('uk_company_country', 'company_country', ['quote_company_id','country_id'], true);
        $this->createIndex('idx_company', 'company_country', 'quote_company_id');

        $this->addForeignKey('fk_company_country2dict_country', 'company_country', 'country_id', 'dict_country' , 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_company_country2quote_company', 'company_country', 'quote_company_id', 'quote_company' , 'id', 'CASCADE', 'CASCADE');

        $this->createTable('company_resort', [
            'quote_company_id' => $this->integer(11)->notNull(),
            'resort_id' => $this->integer(11)->notNull(),
            'service_resort_id' => $this->integer(11)->notNull()
        ], $tableOptions);

        $this->createIndex('uk_company_resort', 'company_resort', ['quote_company_id','resort_id'], true);
        $this->createIndex('idx_company', 'company_resort', 'quote_company_id');
        $this->addForeignKey('fk_company_resort2dict_resort', 'company_resort', 'resort_id', 'dict_resort' , 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_company_resort2quote_company', 'company_resort', 'quote_company_id', 'quote_company' , 'id', 'CASCADE', 'CASCADE');

        $this->createTable('company_airport', [
            'quote_company_id' => $this->integer(11)->notNull(),
            'airport_id' => $this->integer(11)->notNull(),
            'service_airport_id' => $this->integer(11)->notNull()
        ], $tableOptions);

        $this->createIndex('uk_company_airport', 'company_airport', ['quote_company_id','airport_id'], true);
        $this->createIndex('idx_company', 'company_airport', 'quote_company_id');
        $this->addForeignKey('fk_company_airport2dict_airport', 'company_airport', 'airport_id', 'dict_airport' , 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_company_airport2quote_company', 'company_airport', 'quote_company_id', 'quote_company' , 'id', 'CASCADE', 'CASCADE');

        $this->execute("INSERT INTO quote_company (id, image, company_name) VALUES (4, 'skikings.png', 'SkiKings')");

        $this->execute("INSERT INTO company_country SELECT 4, id, id FROM dict_country");
        $this->execute("INSERT INTO company_resort SELECT 4, id, id FROM dict_resort");
        $this->execute("INSERT INTO company_airport SELECT 4, id, id FROM dict_airport");

        $this->createTable('travel_quote', [
            'id' => $this->primaryKey(),
            'country_id' => $this->integer(11),
            'resort_id' => $this->integer(11),
            'airport_id' => $this->integer(11),
            'date' => $this->date(),
            'duration' => $this->smallInteger(),
            'passengers' => $this->smallInteger()
        ], $tableOptions);

        $this->createIndex('idx_country', 'travel_quote', 'country_id');
        $this->createIndex('idx_resort', 'travel_quote', 'resort_id');
        $this->createIndex('idx_airport', 'travel_quote', 'airport_id');

        $this->addForeignKey('fk_travel_quote2dict_country', 'travel_quote', 'country_id', 'dict_country', 'id');
        $this->addForeignKey('fk_travel_quote2dict_resort', 'travel_quote', 'resort_id', 'dict_resort', 'id');
        $this->addForeignKey('fk_travel_quote2dict_airport', 'travel_quote', 'airport_id', 'dict_airport', 'id');

    }

    public function safeDown()
    {
        echo "m171004_104643_add_travel_quote_tables cannot be reverted.\n";

        return false;
    }
}
