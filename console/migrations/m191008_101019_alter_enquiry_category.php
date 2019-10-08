<?php

use yii\db\Migration;

class m191008_101019_alter_enquiry_category extends Migration
{
    public function safeUp()
    {
        $this->execute("UPDATE enquiry_category SET `image`='city-breaks.png' WHERE `alias`='city_breaks'");
        $this->execute("UPDATE enquiry_category SET `image`='car-hire.png' WHERE `alias`='car_hire'");
        $this->execute("UPDATE enquiry_category SET `image`='food-and-drink.png' WHERE `alias`='food_n_drink'");
        $this->execute("UPDATE enquiry_category SET `image`='home-and-garden.png' WHERE `alias`='home_n_garden'");
    }

    public function safeDown()
    {
        echo "m191008_101019_alter_enquiry_category cannot be reverted.\n";

        return false;
    }
}
