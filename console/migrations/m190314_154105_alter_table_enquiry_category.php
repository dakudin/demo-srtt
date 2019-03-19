<?php

use yii\db\Migration;

class m190314_154105_alter_table_enquiry_category extends Migration
{
    public function safeUp()
    {
        $this->addColumn('enquiry_category', 'enquiry_class_name', $this->string(20));

        $this->execute('UPDATE enquiry_category SET enquiry_class_name="TravelQuote" WHERE id IN (2,3)');
    }

    public function safeDown()
    {
        $this->dropColumn('enquiry_category', 'enquiry_class_name');
    }
}
