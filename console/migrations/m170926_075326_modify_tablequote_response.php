<?php

use yii\db\Migration;

class m170926_075326_modify_tablequote_response extends Migration
{
    public function safeUp()
    {
		$this->addColumn('quote_response', 'instruct_us_url', 'TEXT');
		$this->addColumn('quote_response', 'instruct_us_method', "ENUM('GET','POST') DEFAULT 'GET'");
		$this->addColumn('quote_response', 'instruct_us_is_multipart_form', 'TINYINT(1) DEFAULT 0');
		$this->addColumn('quote_response', 'instruct_us_params', 'TEXT');

    }

    public function safeDown()
    {
        echo "m170926_075326_modify_tablequote_response cannot be reverted.\n";

        return false;
    }
}
