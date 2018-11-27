<?php

use yii\db\Migration;

class m170929_190100_add_birdandco_solicitor extends Migration
{
    public function safeUp()
    {
		$this->addColumn('instant_quote', 'help_to_buy', 'TINYINT(1) NOT NULL DEFAULT 0');
		$this->addColumn('instant_quote', 'sdlt_additional', "TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Is this purchase going to result in you owning more than one residential property?'");

		$this->execute("INSERT IGNORE INTO quote_company (id, `image`, `company_name`) VALUES (3, 'bird_and_co.png', 'Bird & Co. Solicitors')");
    }

    public function safeDown()
    {
        echo "m170929_190100_add_birdandco_solicitor cannot be reverted.\n";

        return false;
    }
}
