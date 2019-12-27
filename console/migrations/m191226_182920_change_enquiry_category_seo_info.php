<?php

use yii\db\Migration;

class m191226_182920_change_enquiry_category_seo_info extends Migration
{
    public function safeUp()
    {
        $this->addColumn('enquiry_category', 'seo_detail', $this->string(1000));

        // ski
        $this->execute('UPDATE enquiry_category SET seo_title="Ski Holidays 2020 | Ski Deals | Sortit",'
            .' seo_h1="Skiing & Snowboarding Holidays 2020. Create your ski deal",'
            .' seo_description="A lot of services in one place. Ski holidays ? Cheap ? All inclusive ? Family ? Ski packages ? Short ski breaks",'
            .' seo_detail="Ski and Snowboard Holidays to hundreds of Ski Resorts in Europe (France, Switzerland, Austria and more) and America (Canada and the United States). Everything from cheap last minute ski deals and ski holidays to the very best in fully catered, luxury ski chalets. Tired of searching for hours to find what you want? Fill the form below. Select trusted, reviewed, hand-picked providers who will offer great deals and solutions for ski holiday you need."'
            .' WHERE `alias`="ski" LIMIT 1');

        // beach
        $this->execute('UPDATE enquiry_category SET seo_title="Beach Holidays 2020/2021 | Best Beach Holidays | Sortit",'
            .' seo_h1="Beach Holidays. Find your best sunny beach holiday deal",'
            .' seo_description="A lot of services in one place. Beach holidays ? Sunny ? Cheap ? All inclusive ? City breaks ? Different destinations",'
            .' seo_detail="From soft, white sands to pebbly coves where it is just you, your family and the sea, a beach holiday is the dream ticket for relaxation and a healthy dose of fun in the sun. Tired of searching for hours to find what you want? Fill the form below. Select trusted, reviewed, hand-picked providers who will offer great deals and solutions for beach holiday you need."'
            .' WHERE `alias`="beach" LIMIT 1');

        // holidays
        $this->execute('UPDATE enquiry_category SET seo_title="Last Minute Holidays | Cheap Holidays | Sortit"'
            .' seo_description="A lot of services in one place. ? Luxury holidays ? Cheap and All inclusive holidays ? City breaks ? Holiday packages",'
            .' WHERE `alias`="holidays" LIMIT 1');


    }

    public function safeDown()
    {
        echo "m191226_182920_change_enquiry_category_seo_info cannot be reverted.\n";

        return false;
    }
}
