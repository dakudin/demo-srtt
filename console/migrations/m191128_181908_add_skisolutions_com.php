<?php

use yii\db\Migration;

class m191128_181908_add_skisolutions_com extends Migration
{
    public function safeUp()
    {
        $this->execute('INSERT INTO quote_company SET id=12, image="skisolutions.png", company_name="Ski Solutions", method_name="createQuoteSkiSolutions", info="Ski Solutions is Britain`s original tailor-made ski tour operator and largest specialist ski travel agency. We`ve been arranging ski holidays for over 30 years across Europe and North America, and have a pretty good idea of what`s needed for a truly memorable ski holiday."');

        $this->insert('quote_company_category', [
            'quote_company_id' => 12,
            'enquiry_category_id' => 3
        ]);
    }

    public function safeDown()
    {
        echo "m191128_181908_add_skisolutions_com cannot be reverted.\n";

        return false;
    }
}
