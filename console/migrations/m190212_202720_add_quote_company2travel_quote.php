<?php

use yii\db\Migration;

class m190212_202720_add_quote_company2travel_quote extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%quote_company_category}}', [
                'id' => $this->primaryKey(),
                'quote_company_id' => $this->integer()->notNull(),
                'enquiry_category_id' => $this->integer()->notNull(),

            ], $tableOptions);

        $this->createIndex('idx_quote_company_id', 'quote_company_category', 'quote_company_id');
        $this->addForeignKey('fk_quote_company_category2quote_company', 'quote_company_category', 'quote_company_id', 'quote_company', 'id', 'CASCADE', 'CASCADE');
        $this->createIndex('idx_enquiry_category_id', 'quote_company_category', 'enquiry_category_id');
        $this->addForeignKey('fk_quote_company_category2enquiry_category', 'quote_company_category', 'enquiry_category_id', 'enquiry_category', 'id', 'CASCADE', 'CASCADE');
        $this->createIndex('uk_quote_company_category', 'quote_company_category', ['quote_company_id', 'enquiry_category_id'], true);
        $this->batchInsert('quote_company_category',
            ['quote_company_id', 'enquiry_category_id'],
            [
                [6,2],
                [7,2],
                [8,2],
                [6,3],
                [7,3]
            ]
        );

        $this->dropForeignKey('fk_travel_quote2category', 'travel_quote');
        $this->addForeignKey('fk_travel_quote2enquiry_category', 'travel_quote', 'category_id', 'enquiry_category', 'id', 'CASCADE', 'CASCADE');

    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_quote_company_category2quote_company', 'quote_company_category');
        $this->dropIndex('idx_quote_company_id', 'quote_company_category');
        $this->dropForeignKey('fk_quote_company_category2enquiry_category', 'quote_company_category');
        $this->dropIndex('idx_enquiry_category', 'quote_company_category');

        $this->dropTable('{{%quote_company_category}}');

        $this->addForeignKey('fk_travel_quote2category', 'travel_quote', 'category_id', 'category', 'id', 'CASCADE', 'CASCADE');

    }
}
