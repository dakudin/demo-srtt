<?php

use yii\db\Migration;

class m181004_113109_alter_user_email extends Migration
{
    public function safeUp()
    {
        $this->dropIndex('username', 'user');
        $this->dropIndex('email', 'user');

        $this->alterColumn('user', 'email', $this->string()->unique());
        $this->alterColumn('user', 'username', $this->string());
    }

    public function safeDown()
    {
        $this->alterColumn('user', 'username', $this->string()->notNull()->unique());
        $this->alterColumn('user', 'email', $this->string()->notNull()->unique());
    }
}
