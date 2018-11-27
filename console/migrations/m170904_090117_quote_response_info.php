<?php

use yii\db\Migration;

class m170904_090117_quote_response_info extends Migration
{
    public function safeUp()
    {
		$tableOptions = null;
		if ($this->db->driverName === 'mysql') {
			$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
		}


		$this->createTable('quote_company', [
				'id' => $this->primaryKey(),
				'image' => $this->string(50)->notNull(),
				'company_name' => $this->string(50)->unique(),
			],
			$tableOptions
		);

		$this->createTable('quote_response', [
			'id' => $this->primaryKey(),
			'instant_quote_id' => $this->integer()->notNull(),
			'quote_company_id' => $this->integer()->notNull(),
			'legal_fee' => $this->money(8,2)->notNull()->defaultValue(0),
			'vat' => $this->money(8,2)->notNull()->defaultValue(0),
			'disbursements' => $this->money(8,2)->notNull()->defaultValue(0),
			'stamp_duty' => $this->money(8,2)->notNull()->defaultValue(0),
			'total_amount' => $this->money(8,2)->notNull()->defaultValue(0),
			'reference_number' => $this->string(100)
			],
			$tableOptions
		);

		$this->createIndex('idx_instant_quote_id', 'quote_response', 'instant_quote_id');
		$this->createIndex('idx_quote_company_id', 'quote_response', 'quote_company_id');

		$this->addForeignKey('fk_quote_response2instant_quote', 'quote_response', 'instant_quote_id', 'instant_quote', 'id', 'CASCADE', 'CASCADE');
		$this->addForeignKey('fk_quote_response2quote_company', 'quote_response', 'quote_company_id', 'quote_company', 'id', 'CASCADE', 'CASCADE');

		$this->createTable('quote_response_detail', [
				'id' => $this->primaryKey(),
				'quote_response_id' => $this->integer()->notNull(),
				'description' => $this->string()->notNull(),
				'amount' => $this->money(8,2)->notNull()->defaultValue(0),
				'is_disbursements' => $this->boolean()->notNull()->defaultValue(false),
				'type' => "ENUM('buying','selling','undefined') NOT NULL",
			],
			$tableOptions
		);

		$this->createIndex('idx_quote_response_id', 'quote_response_detail', 'quote_response_id');
		$this->createIndex('idx_is_disbursements', 'quote_response_detail', 'is_disbursements');
		$this->createIndex('idx_type', 'quote_response_detail', 'type');

		$this->addForeignKey('fk_quote_response_detail2quote_response', 'quote_response_detail', 'quote_response_id', 'quote_response', 'id', 'RESTRICT', 'RESTRICT');


	}

    public function safeDown()
    {
		$this->dropForeignKey('fk_quote_response_detail2quote_response', 'quote_response_detail');

		$this->dropForeignKey('fk_quote_response2instant_quote', 'quote_response');
		$this->dropForeignKey('fk_quote_response2quote_company', 'quote_response');

		$this->dropTable('quote_company');
		$this->dropTable('quote_response_detail');
		$this->dropTable('quote_response');
    }

}
