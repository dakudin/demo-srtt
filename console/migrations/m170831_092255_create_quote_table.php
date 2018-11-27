<?php

use yii\db\Migration;

/**
 * Handles the creation of table `quote`.
 */
class m170831_092255_create_quote_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
		$tableOptions = null;
		if ($this->db->driverName === 'mysql') {
			// http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
			$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
		}

        $this->createTable('instant_quote', [
            'id' => $this->primaryKey(),
			'first_name' => $this->string()->notNull(),
			'last_name' => $this->string()->notNull(),
			'email' => $this->string()->notNull(),
			'phone' => $this->string(20)->notNull(),
			'type' => "ENUM('buy', 'buy_n_sell', 'sell', 'remortgage') NOT NULL",
			'buying_price' => $this->money(8,2),
			'property_type' => "ENUM('freehold', 'leasehold') NOT NULL DEFAULT 'freehold'",
			'has_buying_mortgage' => $this->boolean()->notNull()->defaultValue(false),
			'is_new_build' => $this->boolean()->notNull()->defaultValue(false),
			'is_second_purchase' => $this->boolean()->notNull()->defaultValue(false),
			'selling_price' => $this->money(8,2),
			'selling_property_type' => "ENUM('freehold', 'leasehold') NOT NULL DEFAULT 'freehold'",
			'has_selling_mortgage' => $this->boolean()->notNull()->defaultValue(false),
			'remortgage_price' => $this->money(8,2),
			'remortgage_property_type' => "ENUM('freehold', 'leasehold') NOT NULL DEFAULT 'freehold'",
			'transfer_of_enquity' => $this->boolean()->notNull()->defaultValue(false),
			'email_subscribed' => $this->boolean()->notNull()->defaultValue(false),
        ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('instant_quote');
    }
}
