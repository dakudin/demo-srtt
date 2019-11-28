<?php

use yii\db\Migration;

class m191124_131918_add_inghams_co_uk extends Migration
{
    public function safeUp()
    {
        $this->execute('INSERT INTO quote_company SET id=11, image="inghams.png", company_name="Inghams", method_name="createQuoteInghams", info="With over 80 years of operating Ski and Lakes & Mountains holidays, it`s no surprise Inghams is expert at delivering award winning holidays to its loyal guests. The foundation of our success is the deep and long-lasting relationships with our partner hoteliers and other suppliers. These enduring partnerships and friendships are fundamental in creating the best holidays and value for our customers."');

        $this->insert('quote_company_category', [
            'quote_company_id' => 11,
            'enquiry_category_id' => 3
        ]);

        $this->addColumn('dict_airport', 'inghams_value',  $this->string(30));

        $this->execute("UPDATE dict_airport SET inghams_value='Belfast' WHERE id=30"); // Belfast
        $this->execute("UPDATE dict_airport SET inghams_value='Birmingham' WHERE id=20"); // Birmingham
        $this->execute("UPDATE dict_airport SET inghams_value='Bristol' WHERE id=16"); // Bristol
        $this->execute("UPDATE dict_airport SET inghams_value='Edinburgh' WHERE id=6"); // Edinburgh
        $this->execute("UPDATE dict_airport SET inghams_value='Glasgow' WHERE id=7"); // Glasgow
        $this->execute("UPDATE dict_airport SET inghams_value='Leeds Bradford' WHERE id=19"); // Leeds / Bradford
        $this->execute("UPDATE dict_airport SET inghams_value='London Heathrow' WHERE id=27"); // London Heathrow
        $this->execute("UPDATE dict_airport SET inghams_value='London Gatwick' WHERE id=5"); // London Gatwick
        $this->execute("UPDATE dict_airport SET inghams_value='London Stansted' WHERE id=21"); // London Stansted
        $this->execute("UPDATE dict_airport SET inghams_value='Manchester' WHERE id=9"); // Manchester
        $this->execute("UPDATE dict_airport SET inghams_value='Newcastle' WHERE id=11"); // Newcastle
        $this->execute("UPDATE dict_airport SET inghams_value='Southampton' WHERE id=26"); // Southampton
        $this->execute("UPDATE dict_airport SET inghams_value='Liverpool' WHERE id=10"); // Liverpool
        $this->execute("UPDATE dict_airport SET inghams_value='London Luton' WHERE id=22"); // Luton
        $this->execute("UPDATE dict_airport SET inghams_value='East Midlands' WHERE id=18"); // East Midlands

        $this->execute("DELETE FROM quote_company_category WHERE enquiry_category_id=3 AND quote_company_id IN (6,7,9,10) LIMIT 4");
    }

    public function safeDown()
    {
        echo "m191124_131918_add_inghams_co_uk cannot be reverted.\n";

        return false;
    }
}
