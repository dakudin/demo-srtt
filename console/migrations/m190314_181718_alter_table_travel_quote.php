<?php

use yii\db\Migration;

class m190314_181718_alter_table_travel_quote extends Migration
{
    public function safeUp()
    {
        $this->addColumn('travel_quote', 'is_rated', $this->boolean()->notNull()->defaultValue(false));
        $this->addColumn('travel_quote', 'is_rate_email_sent', $this->boolean()->notNull()->defaultValue(false));
        $this->execute('UPDATE travel_quote SET is_rate_email_sent=1');

        $this->createIndex('uk_company_rating', 'company_rating', ['quote_company_id', 'travel_quote_id'], true);
    }

    public function safeDown()
    {
        $this->dropColumn('travel_quote', 'is_rated');
    }
}
