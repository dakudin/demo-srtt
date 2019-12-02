<?php

use yii\db\Migration;

class m191202_150234_add_igluski_com extends Migration
{
    public function safeUp()
    {
        $this->execute('INSERT INTO quote_company SET id=13, image="igluski.png", company_name="Iglu Ski", method_name="createQuoteIgluSki", info="Iglu specialises in ski and snowboarding holidays. We are the largest ski travel agency in the UK, selling more ski holidays than any other travel agency and providing the widest selection of ski deals anywhere. Iglu Ski is now in its 20th year of trading and is proud to offer ski deals to over 200 ski resorts in 18 countries from over 60 ski tour operators."');

        $this->insert('quote_company_category', [
            'quote_company_id' => 13,
            'enquiry_category_id' => 3
        ]);
    }

    public function safeDown()
    {
        echo "m191202_150234_add_igluski_com cannot be reverted.\n";

        return false;
    }
}
