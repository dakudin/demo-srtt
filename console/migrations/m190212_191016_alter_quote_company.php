<?php

use yii\db\Migration;

class m190212_191016_alter_quote_company extends Migration
{
    public function safeUp()
    {
        $this->addColumn('quote_company', 'info', 'text DEFAULT NULL');

        $this->execute('UPDATE quote_company SET info="eShores are a 15-strong team of dedicated personal travel consultants, based at our eShores head quarters in Rochdale, Greater Manchester. Our team is an ideal size to ensure that our combined knowledge covers every inch of the globe, so no matter where you want to go, we will work together to provide you with the best possible travel advice." WHERE id=6');

        $this->execute('UPDATE quote_company SET info="At Designer Travel, we have a passion for travel and customer service, which together with our extensive knowledge of the travel industry means we know where to look and what to recommend. Our travel experts are all experienced professionals and take great pride in offering a highly personalised service." WHERE id=7');

        $this->execute('UPDATE quote_company SET info="The innovative, entrepreneurial spirit that Travel Counsellors was founded on over 20 years ago is as life-changing now as it was then. Travel Counsellors was born out of the desire to serve customers with the best travel experiences possible, and to create inspiring career opportunities for people who have a passion for travel." WHERE id=8');
    }

    public function safeDown()
    {
        $this->dropColumn('quote_company', 'info');
    }
}
