<?php

use yii\db\Migration;

class m190115_131629_create_table_enquiry_category extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%enquiry_category}}', [
            'id' => $this->primaryKey(),
            'tree' => $this->integer(),
            'lft' => $this->integer()->notNull(),
            'rgt' => $this->integer()->notNull(),
            'depth' => $this->integer()->notNull(),
            'name' => $this->string(50)->notNull()->unique(),
            'alias' => $this->string(50)->notNull()->unique(),
            'is_active' => $this->boolean()->notNull()->defaultValue(false),
            'is_visible' => $this->boolean()->notNull()->defaultValue(false),
            'image' => $this->string(50)->notNull(),
        ], $tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable('{{%enquiry_category}}');
    }
}
