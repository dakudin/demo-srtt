<?php

use yii\db\Migration;

class m190702_124934_alter_dictionaries_flight_centre extends Migration
{
    public function safeUp()
    {
        $this->addColumn('dict_airport', 'flightcentre_value',  $this->string(50));

        $this->execute("UPDATE dict_airport SET flightcentre_value='London Heathrow' WHERE id=27");
        $this->execute("UPDATE dict_airport SET flightcentre_value='London Gatwick' WHERE id=5");
        $this->execute("UPDATE dict_airport SET flightcentre_value='Aberdeen' WHERE id=42");
        $this->execute("UPDATE dict_airport SET flightcentre_value='Belfast' WHERE id=30");
        $this->execute("UPDATE dict_airport SET flightcentre_value='Birmingham' WHERE id=20");
        $this->execute("UPDATE dict_airport SET flightcentre_value='Bournemouth' WHERE id=12");
        $this->execute("UPDATE dict_airport SET flightcentre_value='Dublin' WHERE id=40");
        $this->execute("UPDATE dict_airport SET flightcentre_value='Edinburgh' WHERE id=6");
        $this->execute("UPDATE dict_airport SET flightcentre_value='Glasgow' WHERE id=7");
        $this->execute("UPDATE dict_airport SET flightcentre_value='Leeds' WHERE id=19");
        $this->execute("UPDATE dict_airport SET flightcentre_value='Manchester' WHERE id=9");
        $this->execute("UPDATE dict_airport SET flightcentre_value='Newcastle' WHERE id=11");
    }

    public function safeDown()
    {
        echo "m190702_124934_alter_dictionaries_flight_centre cannot be reverted.\n";

        return false;
    }
}
