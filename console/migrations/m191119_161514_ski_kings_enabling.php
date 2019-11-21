<?php

use yii\db\Migration;

class m191119_161514_ski_kings_enabling extends Migration
{
    public function safeUp()
    {
        $this->update('quote_company', [
            'method_name' => 'createQuoteSkiKings',
            'info' => 'SkiKings is part of Stewart Travel (ABTA P6486) which is a trading name of Hays Travel Ltd and acts as an agent for fully bonded tour operators. Our objective is to listen to what our clients are looking for in a ski or snowboarding holiday and provide suitable options for them to book. We will also provide impartial and unbiased advice ensuring that they have the best options possible to book the perfect ski holiday. We have access to hundreds of ski holidays throughout the Alps. This then saves you the time and effort of searching through the internet as we will do the searching for you.'
        ], 'id=4');

        $this->insert('quote_company_category', [
            'quote_company_id' => 4,
            'enquiry_category_id' => 3
        ]);
    }

    public function safeDown()
    {
        echo "m191119_161514_ski_kings_enabling cannot be reverted.\n";

        return false;
    }
}
