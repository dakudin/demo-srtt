<?php

use yii\db\Migration;

class m190227_090731_create_table_company_rating extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%company_rating}}', [
            'id' => $this->primaryKey(),
            'rating' => $this->float(1)->notNull(),
            'quote_company_id' => $this->integer()->notNull(),
            'travel_quote_id' => $this->integer()
        ], $tableOptions);

        $this->createIndex('idx_quote_company_id', '{{%company_rating}}', 'quote_company_id');
        $this->createIndex('idx_travel_quote_id', '{{%company_rating}}', 'travel_quote_id');
        $this->addForeignKey('fk_quote_company_id2quote_company', '{{%company_rating}}', 'quote_company_id', '{{%quote_company}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_quote_company_id2travel_quote', '{{%company_rating}}', 'travel_quote_id', '{{%travel_quote}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        echo "m190227_090731_create_table_company_rating cannot be reverted.\n";

        return false;
    }
}
