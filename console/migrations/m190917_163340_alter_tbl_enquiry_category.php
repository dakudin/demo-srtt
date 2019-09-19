<?php

use yii\db\Migration;

class m190917_163340_alter_tbl_enquiry_category extends Migration
{
    public function safeUp()
    {
        $this->addColumn('enquiry_category', 'seo_title', $this->string(100));
        $this->addColumn('enquiry_category', 'seo_description', $this->string(160));
        $this->addColumn('enquiry_category', 'seo_keyword', $this->string(160));

        $this->execute('UPDATE enquiry_category SET seo_title="Create Beach quote - Sortit",'
            .' seo_description="Search for your perfect beach holiday.",'
            .' seo_keyword="Sortit, on the beach, holidays, beach holidays"'
            .' WHERE `alias`="beach" LIMIT 1');
        $this->execute('UPDATE enquiry_category SET seo_title="Create Ski quote - Sortit",'
            .' seo_description="Search for your perfect ski holiday in Andorra, Austria, France, Germany, Italy, USA and Canada. Ski trips and Ski vacations.",'
            .' seo_keyword="Sortit, ski, skiing, ski holidays, ski Andorra, ski Austria, ski France, ski Germany, ski Italy, ski USA, ski Canada"'
            .' WHERE `alias`="ski" LIMIT 1');

        $this->execute('UPDATE enquiry_category SET seo_title="Holidays - Sortit",'
            .' seo_description="Search holidays in beach, ski, city breaks, luxury, flights, cruises, activities and family categories.",'
            .' seo_keyword="beach, ski, city breaks, luxury, flights, cruises, activities, family"'
            .' WHERE `alias`="holidays" LIMIT 1');


    }

    public function safeDown()
    {
        $this->dropColumn('enquiry_category', 'seo_title');
        $this->dropColumn('enquiry_category', 'seo_description');
        $this->dropColumn('enquiry_category', 'seo_keyword');
    }
}
