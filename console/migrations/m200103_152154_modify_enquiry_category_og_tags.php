<?php

use yii\db\Migration;

class m200103_152154_modify_enquiry_category_og_tags extends Migration
{
    public function safeUp()
    {
        // beach
        $this->execute('UPDATE enquiry_category SET '
            .' og_description="A lot of services in one place. Cheap / All inclusive / City breaks"'
            .' WHERE `alias`="beach" LIMIT 1');

        // ski
        $this->execute('UPDATE enquiry_category SET '
            .' og_description="A lot of services in one place. Cheap / All inclusive / Ski packages"'
            .' WHERE `alias`="ski" LIMIT 1');

        // holidays
        $this->execute('UPDATE enquiry_category SET '
            .' og_description="A lot of services in one place. Luxury holidays / Cheap and All inclusive holidays"'
            .' WHERE `alias`="holidays" LIMIT 1');
    }

    public function safeDown()
    {
        echo "m200103_152154_modify_enquiry_category_og_tags cannot be reverted.\n";

        return false;
    }
}
