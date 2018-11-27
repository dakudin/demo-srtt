<?php

use yii\db\Migration;

class m170922_082044_modify_company_names extends Migration
{
    public function safeUp()
    {
		$this->execute("UPDATE quote_company SET company_name='My Home Move Conveyancing' WHERE id=1");
		$this->execute("UPDATE quote_company SET company_name='HomeWard Legal Conveyancing' WHERE id=2");
    }

    public function safeDown()
    {
        echo "m170922_082044_modify_company_names cannot be reverted.\n";

        return false;
    }

}
