<?php

use yii\db\Migration;

class m171027_144456_add_table_category extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('category', [
                'id' => $this->primaryKey(),
                'parent_id' => $this->integer()->defaultValue(null),
                'name' => $this->string(50)->notNull()->unique(),
                'active' => $this->boolean()->notNull()->defaultValue(false)
        ], $tableOptions);

        $this->createIndex('idx_parent_id', 'category', 'parent_id');
        $this->addForeignKey('fk_category2category', 'category', 'parent_id', 'category', 'id', 'CASCADE', 'CASCADE');

        $this->execute("INSERT INTO category (id, parent_id, name, active) VALUES (1, NULL, 'Conveyancing', 1)");
        $this->execute("INSERT INTO category (id, parent_id, name, active) VALUES (2, NULL, 'Travel', 1)");
        $this->execute("INSERT INTO category (id, parent_id, name, active) VALUES (3, 2, 'Luxury', 1)");
        $this->execute("INSERT INTO category (id, parent_id, name, active) VALUES (4, 2, 'Ski', 1)");

        $this->execute('DELETE FROM travel_quote');
        $this->addColumn('travel_quote', 'category_id', 'INT(11) NOT NULL');
        $this->createIndex('idx_category_id', 'travel_quote', 'category_id');
        $this->addForeignKey('fk_travel_quote2category', 'travel_quote', 'category_id', 'category', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        echo "m171027_144456_add_table_category cannot be reverted.\n";

        return false;
    }
}
