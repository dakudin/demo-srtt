<?php

use yii\db\Migration;

class m171119_174354_add_paging_to_traveling extends Migration
{
    public function safeUp()
    {
        $this->addColumn('travel_quote', 'page_number', 'TINYINT UNSIGNED NOT NULL DEFAULT 1');
    }

    public function safeDown()
    {
        $this->dropColumn('travel_quote', 'page_number');
    }
}
