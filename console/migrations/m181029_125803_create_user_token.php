<?php

use yii\db\Migration;

class m181029_125803_create_user_token extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }


        $this->createTable(
            '{{%user_token}}',
            [
                'id' => 'INTEGER NOT NULL AUTO_INCREMENT',
                'user_id' => 'INTEGER NOT NULL',
                'access_token' => 'varchar(41) DEFAULT NULL',
                'token_type' => 'varchar(255) DEFAULT NULL',
                'expires_in' => 'int(11) DEFAULT NULL',
                'refresh_token' => 'varchar(41) DEFAULT NULL',
                'refresh_expiration_in' => 'int(11) DEFAULT NULL',
                'PRIMARY KEY (`id`)',
                'UNIQUE (`access_token`)',
                'UNIQUE (`refresh_token`)'
            ], $tableOptions
        );

        $this->createIndex('idx-token-user_id', '{{%user_token}}', 'user_id');

        $this->addForeignKey(
            'fk_user_token_to_user',
            '{{%user_token}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE',
            'RESTRICT'
        );
    }

    public function safeDown()
    {
        $this->dropIndex('fk_user_token_to_user', '{{%user_token}}');
        $this->dropTable('{{%user_token}}');
    }
}
