<?php

use yii\db\Migration;

class m191101_134102_change_enquiry_category_seo_info extends Migration
{
    public function safeUp()
    {
        $this->addColumn('enquiry_category', 'seo_h1', $this->string(250));

        // beach
        $this->execute('UPDATE enquiry_category SET seo_title="Beach holidays 2019 - Sortit",'
            .' seo_h1="Beach holidays 2019 - 2020. Find your best sunny beach holiday destination",'
            .' seo_description="The quote engine for beach holidays: sunny, cheap, all inclusive, city breaks, different destinations. A lot of services in one place",'
            .' seo_keyword="on the beach holidays, all inclusive beach holidays, cheap beach holidays"'
            .' WHERE `alias`="beach" LIMIT 1');

        // ski
        $this->execute('UPDATE enquiry_category SET seo_title="Ski holidays 2019 - Sortit",'
            .' seo_h1="Ski holidays 2019 - 2020. Create your ski deal",'
            .' seo_description="The quote engine for ski holidays: cheap, all inclusive, family, ski packages, short ski breaks. A lot of services in one place",'
            .' seo_keyword="all inclusive ski holidays, family ski, ski deals, cheap ski holidays"'
            .' WHERE `alias`="ski" LIMIT 1');

        // holidays
        $this->execute('UPDATE enquiry_category SET seo_title="Last minute holidays, cheap holidays, all inclusive holidays - Sortit",'
            .' seo_h1="",'
            .' seo_description="The quote engine for luxury, cheap and all inclusive holidays, city breaks and holiday packages. A lot of services in one place",'
            .' seo_keyword="last minute holidays, cheap holidays, city breaks"'
            .' WHERE `alias`="holidays" LIMIT 1');
    }

    public function safeDown()
    {
        echo "m191101_134102_change_enquiry_category_seo_info cannot be reverted.\n";

        return false;
    }
}
