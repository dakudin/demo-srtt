<?php

use yii\db\Migration;

class m200103_134823_modify_enquiry_category extends Migration
{
    public function safeUp()
    {
        $this->addColumn('enquiry_category', 'og_title', $this->string(250));
        $this->addColumn('enquiry_category', 'og_description', $this->string(250));
        $this->addColumn('enquiry_category', 'og_image', $this->string(250));

        // beach
        $this->execute('UPDATE enquiry_category SET og_title="Find your best sunny beach holiday 2020/2021.",'
            .' og_description="A lot of services in one place. Beach holidays / Sunny / Cheap / All inclusive / City breaks / Different destinations",'
            .' og_image="/images/campaign/beach_holidays.jpg"'
            .' WHERE `alias`="beach" LIMIT 1');

        // ski
        $this->execute('UPDATE enquiry_category SET og_title="Find your best ski holiday 2020/2021",'
            .' og_description="A lot of services in one place. Ski holidays / Cheap / All inclusive / Family / Ski packages / Short ski breaks",'
            .' og_image="/images/campaign/ski_holidays.jpg"'
            .' WHERE `alias`="ski" LIMIT 1');

        // holidays
        $this->execute('UPDATE enquiry_category SET og_title="Find your best holiday 2020/2021",'
            .' og_description="A lot of services in one place. Luxury holidays / Cheap and All inclusive holidays / City breaks / Holiday packages",'
            .' og_image="/images/campaign/holidays.jpg"'
            .' WHERE `alias`="holidays" LIMIT 1');

    }

    public function safeDown()
    {
        echo "m200103_134823_modify_enquiry_category cannot be reverted.\n";

        return false;
    }
}
