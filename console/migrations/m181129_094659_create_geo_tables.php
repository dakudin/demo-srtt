<?php

use yii\db\Migration;

class m181129_094659_create_geo_tables extends Migration
{
    /**
     *
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%geo_country}}', [
            'continent_code' => $this->string(2)->notNull(),
            'continent_name' => $this->string(50)->notNull(),
            'country_code' => $this->string(2)->notNull(),
            'country_name' => $this->string(100)->notNull()->unique(),
            'is_in_european_union' => $this->integer(4)->notNull(),
        ], $tableOptions);

        $this->addPrimaryKey('pk_geo_country', '{{%geo_country}}', 'country_code');

        $this->createTable('{{%geo_region}}', [
            'country_code' => $this->string(2)->notNull(),
            'region_code' => $this->string(2)->notNull(),
            'name' => $this->string(100)->notNull(),
        ], $tableOptions);

        $this->createIndex('uk_geo_region', '{{%geo_region}}', ['country_code' , 'region_code'], true);
        $this->createIndex('idx_country_code', '{{%geo_region}}', 'country_code');
        $this->addForeignKey('fk_geo_region2geo_country', '{{%geo_region}}', 'country_code', '{{%geo_country}}', 'country_code', 'CASCADE', 'CASCADE');

        $this->createTable('{{%geo_city}}', [
            'id' => $this->primaryKey(),
            'country' => $this->string(2)->notNull(),
            'city' => $this->string(50)->notNull(),
            'accent_city' => $this->string(50)->notNull(),
            'region' => $this->string(2)->notNull(),
            'population' => $this->integer(),
            'latitude' => $this->float(),
            'longitude' => $this->float(),
        ], $tableOptions);

        $this->createIndex('idx_country', '{{%geo_city}}', 'country');
        $this->addForeignKey('fk_geo_city2geo_country', '{{%geo_city}}', 'country', '{{%geo_country}}', 'country_code', 'CASCADE', 'CASCADE');

        $this->createIndex('idx_region', '{{%geo_city}}', 'region');
    }

    public function safeDown()
    {
        echo "m181129_094659_create_geo_tables cannot be reverted.\n";

        return false;
    }
}
