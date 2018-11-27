<?php

use yii\db\Migration;

class m170918_120153_add_homewardlegals extends Migration
{
    public function safeUp()
    {
		$this->addColumn('instant_quote', 'buying_postcode', 'VARCHAR(8)');
		$this->addColumn('instant_quote', 'selling_postcode', 'VARCHAR(8)');
		$this->addColumn('instant_quote', 'remortgage_postcode', 'VARCHAR(8)');

		$this->execute("INSERT IGNORE INTO quote_company (id, `image`, `company_name`) VALUES (1, 'my-home-move.png', 'MyHomeMove')");
		$this->execute("INSERT IGNORE INTO quote_company (id, `image`, `company_name`) VALUES (2, 'home-war-legal.png', 'HomeWardLegal')");

		$this->alterColumn('quote_response_detail', 'description', 'varchar(1000) NOT NULL');
    }

    public function safeDown()
    {
        echo "m170918_120153_add_homewardlegals cannot be reverted.\n";

        return false;
    }
}
