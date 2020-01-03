<?php

use yii\db\Migration;

class m200103_154601_modify_enquiry_category extends Migration
{
    public function safeUp()
    {
        // ski
        $this->execute('UPDATE enquiry_category SET '
            .' og_image="/images/campaign/ski_holidays_f.jpg"'
            .' WHERE `alias`="ski" LIMIT 1');
    }

    public function safeDown()
    {
        echo "m200103_154601_modify_enquiry_category cannot be reverted.\n";

        return false;
    }
}
