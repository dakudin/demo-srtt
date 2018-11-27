<?php

use yii\db\Migration;

class m180810_060737_alter_quote_company extends Migration
{
    public function safeUp()
    {
        $this->execute("INSERT INTO quote_company VALUES (6, 'eshores.png', 'eShores.co.uk'),
                (7, 'designer_travel.png', 'Designer Travel'),
                (8, 'travel_counsellors.png', 'Travel Counsellors')"
        );
    }

    public function safeDown()
    {
        echo "m180810_060737_alter_quote_company cannot be reverted.\n";

        return false;
    }
}
