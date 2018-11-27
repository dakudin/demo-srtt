<?php

use yii\db\Migration;

class m171115_143511_add_filters2travel extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('dict_board_basis', [
            'id' => $this->primaryKey(),
            'name' => $this->string(30)->notNull()->unique()
        ], $tableOptions);

        $this->execute('INSERT INTO dict_board_basis (id, name) VALUES (1, "Room only")');
        $this->execute('INSERT INTO dict_board_basis (id, name) VALUES (2, "Room & Breakfast")');
        $this->execute('INSERT INTO dict_board_basis (id, name) VALUES (3, "Half board")');
        $this->execute('INSERT INTO dict_board_basis (id, name) VALUES (4, "Full board")');
        $this->execute('INSERT INTO dict_board_basis (id, name) VALUES (5, "All inclusive")');
        $this->execute('INSERT INTO dict_board_basis (id, name) VALUES (6, "Catered Accommodation")');
        $this->execute('INSERT INTO dict_board_basis (id, name) VALUES (7, "Self Catering")');

        $this->createTable('dict_hotel_grade', [
            'id' => $this->primaryKey(),
            'name' => $this->string(3)->notNull()->unique()
        ], $tableOptions);

        $this->execute('INSERT INTO dict_hotel_grade (id, name) VALUES (1, "0")');
        $this->execute('INSERT INTO dict_hotel_grade (id, name) VALUES (2, "1")');
        $this->execute('INSERT INTO dict_hotel_grade (id, name) VALUES (3, "1.5")');
        $this->execute('INSERT INTO dict_hotel_grade (id, name) VALUES (4, "2")');
        $this->execute('INSERT INTO dict_hotel_grade (id, name) VALUES (5, "2.5")');
        $this->execute('INSERT INTO dict_hotel_grade (id, name) VALUES (6, "3")');
        $this->execute('INSERT INTO dict_hotel_grade (id, name) VALUES (7, "3.5")');
        $this->execute('INSERT INTO dict_hotel_grade (id, name) VALUES (8, "4")');
        $this->execute('INSERT INTO dict_hotel_grade (id, name) VALUES (9, "4.5")');
        $this->execute('INSERT INTO dict_hotel_grade (id, name) VALUES (10, "5")');

        $this->createTable('company_board_basis', [
            'quote_company_id' => $this->integer(11)->notNull(),
            'board_basis_id' => $this->integer(11)->notNull(),
            'service_board_basis_id' => $this->string(10)->notNull()
        ], $tableOptions);

        $this->createIndex('uk_company_board_basis', 'company_board_basis', ['quote_company_id','board_basis_id'], true);
        $this->createIndex('idx_company', 'company_board_basis', 'quote_company_id');
        $this->addForeignKey('fk_company_board_basis2dict_resort', 'company_board_basis', 'board_basis_id', 'dict_board_basis' , 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_company_board_basis2quote_company', 'company_board_basis', 'quote_company_id', 'quote_company' , 'id', 'CASCADE', 'CASCADE');

        $this->execute('INSERT INTO company_board_basis (quote_company_id, board_basis_id, service_board_basis_id) VALUES (5, 1, "MPLN5D")');
        $this->execute('INSERT INTO company_board_basis (quote_company_id, board_basis_id, service_board_basis_id) VALUES (5, 2, "MPLN1D")');
        $this->execute('INSERT INTO company_board_basis (quote_company_id, board_basis_id, service_board_basis_id) VALUES (5, 3, "MPLN2D")');
        $this->execute('INSERT INTO company_board_basis (quote_company_id, board_basis_id, service_board_basis_id) VALUES (5, 4, "MPLN3D")');
        $this->execute('INSERT INTO company_board_basis (quote_company_id, board_basis_id, service_board_basis_id) VALUES (5, 5, "MPLN4D")');

        $this->execute('INSERT INTO company_board_basis (quote_company_id, board_basis_id, service_board_basis_id) VALUES (4, 5, "AI")');
        $this->execute('INSERT INTO company_board_basis (quote_company_id, board_basis_id, service_board_basis_id) VALUES (4, 2, "BB")');
        $this->execute('INSERT INTO company_board_basis (quote_company_id, board_basis_id, service_board_basis_id) VALUES (4, 6, "SD")');
        $this->execute('INSERT INTO company_board_basis (quote_company_id, board_basis_id, service_board_basis_id) VALUES (4, 4, "FB")');
        $this->execute('INSERT INTO company_board_basis (quote_company_id, board_basis_id, service_board_basis_id) VALUES (4, 3, "HB")');
        $this->execute('INSERT INTO company_board_basis (quote_company_id, board_basis_id, service_board_basis_id) VALUES (4, 1, "RO")');
        $this->execute('INSERT INTO company_board_basis (quote_company_id, board_basis_id, service_board_basis_id) VALUES (4, 7, "SC")');


        $this->createTable('company_hotel_grade', [
            'quote_company_id' => $this->integer(11)->notNull(),
            'hotel_grade_id' => $this->integer(11)->notNull(),
            'service_hotel_grade_id' => $this->string(10)->notNull()
        ], $tableOptions);

        $this->createIndex('uk_company_hotel_grade', 'company_hotel_grade', ['quote_company_id','hotel_grade_id'], true);
        $this->createIndex('idx_company', 'company_hotel_grade', 'quote_company_id');
        $this->addForeignKey('fk_company_hotel_grade2dict_resort', 'company_hotel_grade', 'hotel_grade_id', 'dict_hotel_grade' , 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_company_hotel_grade2quote_company', 'company_hotel_grade', 'quote_company_id', 'quote_company' , 'id', 'CASCADE', 'CASCADE');

        $this->execute('INSERT INTO company_hotel_grade (quote_company_id, hotel_grade_id, service_hotel_grade_id) VALUES (5, 6, "HTGR1D")');
        $this->execute('INSERT INTO company_hotel_grade (quote_company_id, hotel_grade_id, service_hotel_grade_id) VALUES (5, 8, "HTGR2D")');
        $this->execute('INSERT INTO company_hotel_grade (quote_company_id, hotel_grade_id, service_hotel_grade_id) VALUES (5, 10, "HTGR3D")');

        $this->execute('INSERT INTO company_hotel_grade (quote_company_id, hotel_grade_id, service_hotel_grade_id) VALUES (4, 1, "0")');
        $this->execute('INSERT INTO company_hotel_grade (quote_company_id, hotel_grade_id, service_hotel_grade_id) VALUES (4, 4, "2")');
        $this->execute('INSERT INTO company_hotel_grade (quote_company_id, hotel_grade_id, service_hotel_grade_id) VALUES (4, 5, "2.5")');
        $this->execute('INSERT INTO company_hotel_grade (quote_company_id, hotel_grade_id, service_hotel_grade_id) VALUES (4, 6, "3")');
        $this->execute('INSERT INTO company_hotel_grade (quote_company_id, hotel_grade_id, service_hotel_grade_id) VALUES (4, 7, "3.5")');
        $this->execute('INSERT INTO company_hotel_grade (quote_company_id, hotel_grade_id, service_hotel_grade_id) VALUES (4, 8, "4")');
        $this->execute('INSERT INTO company_hotel_grade (quote_company_id, hotel_grade_id, service_hotel_grade_id) VALUES (4, 9, "4.5")');
        $this->execute('INSERT INTO company_hotel_grade (quote_company_id, hotel_grade_id, service_hotel_grade_id) VALUES (4, 10, "5")');

        $this->createTable('travel_quote_hotel_grade', [
            'travel_quote_id' => 'INTEGER(11) NOT NULL',
            'dict_hotel_grade_id' => 'INTEGER(11) NOT NULL',
        ], $tableOptions);

        $this->createIndex('uk_travel_quote_hotel_grade', 'travel_quote_hotel_grade', ['travel_quote_id', 'dict_hotel_grade_id'], TRUE);
        $this->createIndex('idx_travel_quote_id', 'travel_quote_hotel_grade', 'travel_quote_id');
        $this->addForeignKey('fk_travel_quote_hotel_grade2dict_hotel_grade' , 'travel_quote_hotel_grade', 'dict_hotel_grade_id', 'dict_hotel_grade', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_travel_quote_hotel_grade2travel_quote' , 'travel_quote_hotel_grade', 'travel_quote_id', 'travel_quote', 'id', 'CASCADE', 'CASCADE');

        $this->createTable('travel_quote_board_basis', [
            'travel_quote_id' => 'INTEGER(11) NOT NULL',
            'dict_board_basis_id' => 'INTEGER(11) NOT NULL',
        ], $tableOptions);

        $this->createIndex('uk_travel_quote_board_basis', 'travel_quote_board_basis', ['travel_quote_id', 'dict_board_basis_id'], TRUE);
        $this->createIndex('idx_travel_quote_id', 'travel_quote_board_basis', 'travel_quote_id');
        $this->addForeignKey('fk_travel_quote_board_basis2dict_board_basis' , 'travel_quote_board_basis', 'dict_board_basis_id', 'dict_board_basis', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_travel_quote_board_basis2travel_quote' , 'travel_quote_board_basis', 'travel_quote_id', 'travel_quote', 'id', 'CASCADE', 'CASCADE');

    }

    public function safeDown()
    {
        echo "m171115_143511_add_filters2travel cannot be reverted.\n";

        return false;
    }
}
