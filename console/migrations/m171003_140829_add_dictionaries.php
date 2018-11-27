<?php

use yii\db\Migration;

class m171003_140829_add_dictionaries extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('dict_country', [
            'id' => $this->primaryKey(),
            'name' => $this->string(30)->notNull()->unique()
        ], $tableOptions);

        $this->createTable('dict_resort', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->notNull()->unique(),
            'dict_country_id' => $this->integer(11)->notNull()
        ], $tableOptions);

        $this->createIndex('idx_dict_country', 'dict_resort', 'dict_country_id');
        $this->addForeignKey('fk_dict_resort2dict_country', 'dict_resort', 'dict_country_id', 'dict_country', 'id');

        $this->createTable('dict_airport', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->notNull()->unique()
        ], $tableOptions);


        $this->execute('INSERT INTO dict_country (id, name) VALUES (6, "Andorra")');
        $this->execute('INSERT INTO dict_country (id, name) VALUES (1, "Austria")');
        $this->execute('INSERT INTO dict_country (id, name) VALUES (7, "Bulgaria")');
        $this->execute('INSERT INTO dict_country (id, name) VALUES (11, "Canada")');
        $this->execute('INSERT INTO dict_country (id, name) VALUES (2, "France")');
        $this->execute('INSERT INTO dict_country (id, name) VALUES (3, "Italy")');
        $this->execute('INSERT INTO dict_country (id, name) VALUES (4, "Switzerland")');
        $this->execute('INSERT INTO dict_country (id, name) VALUES (10, "USA")');

        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (118,"Alpe d\'Huez",2)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (241,"Arabba",3)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (139,"Arinsal",6)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (70,"Aspen",10)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (98,"Avoriaz",2)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (143,"Bad Gastein",1)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (144,"Bad Hofgastein",1)');

        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (59,"Banff",11)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (163,"Bansko",7)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (178,"Bardonecchia",3)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (71,"Beaver Creek",10)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (56,"Big White",11)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (164,"Borovets",7)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (73,"Breckenridge",10)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (182,"Cervinia",3)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (24,"Chamonix",2)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (183,"Champoluc",3)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (169,"Chamrousse",2)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (74,"Copper Mountain",10)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (185,"Cortina",3)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (269,"Corvara",3)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (18,"Courchevel",2)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (186,"Courmayeur",3)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (133,"Davos",4)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (145,"Ellmau",1)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (63,"Fernie",11)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (239,"Filzmoos",1)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (94,"Flaine",2)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (127,"Galtur",1)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (201,"Grindelwald",4)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (76,"Heavenly",10)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (223,"Hinterglemm",1)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (291,"Hochsolden",1)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (238,"Igls",1)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (128,"Ischgl",1)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (77,"Jackson Hole",10)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (58,"Jasper",11)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (39,"Kaprun",1)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (281,"Katschberg",1)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (149,"Kitzbuhel",1)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (15,"Klosters",4)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (275,"Kronplatz",3)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (151,"Kuhtai",1)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (171,"La Clusaz",2)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (287,"La Massana",6)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (40,"La Plagne",2)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (41,"La Rosiere",2)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (105,"La Tania",2)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (188,"La Thuile",3)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (270,"La Villa",3)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (60,"Lake Louise",11)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (50,"Lech",1)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (25,"Les Arcs",2)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (292,"Les Bruyeres",2)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (121,"Les Deux Alpes",2)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (20,"Les Gets",2)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (106,"Les Menuires",2)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (224,"Livigno",3)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (189,"Madonna di Campiglio",3)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (290,"Maria Alm",1)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (152,"Mayrhofen",1)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (22,"Meribel",2)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (42,"Morzine",2)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (244,"Murren",4)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (135,"Nendaz",4)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (103,"Niederau",1)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (44,"Obergurgl",1)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (165,"Pamporovo",7)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (61,"Panorama",11)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (81,"Park City",10)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (140,"Pas de la Casa",6)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (190,"Passo Tonale",3)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (45,"Peisey-Vallandry",2)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (250,"Pragelato",3)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (293,"Reberty 2000",2)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (167,"Revelstoke",11)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (130,"Saalbach",1)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (46,"Saas Fee",4)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (285,"San Cassiano",3)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (194,"Sauze d\'Oulx",3)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (156,"Seefeld",1)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (48,"Selva",3)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (122,"Serre Chevalier",2)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (195,"Sestriere",3)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (158,"Solden",1)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (142,"Soldeu & El Tarter",6)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (102,"Soll",1)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (17,"St. Anton",1)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (215,"St. Christoph",1)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (16,"St. Moritz",4)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (84,"Steamboat",10)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (55,"Sun Peaks",11)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (23,"Tignes",2)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (57,"Tremblant",11)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (89,"Vail",10)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (26,"Val d\'Isere",2)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (180,"Val di Fassa",3)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (51,"Val Thorens",2)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (112,"Valmorel",2)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (19,"Verbier",4)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (123,"Villars",4)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (209,"Wengen",4)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (54,"Whistler",11)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (90,"Winter Park",10)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (104,"Zell am See",1)');
        $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (21,"Zermatt",4)');

        $this->execute('INSERT INTO dict_airport (id, name) VALUES (43,"Accommodation Only")');
        $this->execute('INSERT INTO dict_airport (id, name) VALUES (39,"Belfast City")');
        $this->execute('INSERT INTO dict_airport (id, name) VALUES (42,"Aberdeen")');
        $this->execute('INSERT INTO dict_airport (id, name) VALUES (30,"Belfast Intl")');
        $this->execute('INSERT INTO dict_airport (id, name) VALUES (20,"Birmingham")');
        $this->execute('INSERT INTO dict_airport (id, name) VALUES (12,"Bournemouth")');
        $this->execute('INSERT INTO dict_airport (id, name) VALUES (16,"Bristol")');
        $this->execute('INSERT INTO dict_airport (id, name) VALUES (3,"Cardiff")');
        $this->execute('INSERT INTO dict_airport (id, name) VALUES (23,"Doncaster")');
        $this->execute('INSERT INTO dict_airport (id, name) VALUES (40,"Dublin")');
        $this->execute('INSERT INTO dict_airport (id, name) VALUES (18,"East Midlands")');
        $this->execute('INSERT INTO dict_airport (id, name) VALUES (6,"Edinburgh")');
        $this->execute('INSERT INTO dict_airport (id, name) VALUES (13,"Exeter")');
        $this->execute('INSERT INTO dict_airport (id, name) VALUES (5,"Gatwick")');
        $this->execute('INSERT INTO dict_airport (id, name) VALUES (7,"Glasgow")');
        $this->execute('INSERT INTO dict_airport (id, name) VALUES (27,"Heathrow")');
        $this->execute('INSERT INTO dict_airport (id, name) VALUES (41,"Inverness")');
        $this->execute('INSERT INTO dict_airport (id, name) VALUES (19,"Leeds Bradford")');
        $this->execute('INSERT INTO dict_airport (id, name) VALUES (10,"Liverpool")');
        $this->execute('INSERT INTO dict_airport (id, name) VALUES (22,"Luton")');
        $this->execute('INSERT INTO dict_airport (id, name) VALUES (9,"Manchester")');
        $this->execute('INSERT INTO dict_airport (id, name) VALUES (11,"Newcastle")');
        $this->execute('INSERT INTO dict_airport (id, name) VALUES (26,"Southampton")');
        $this->execute('INSERT INTO dict_airport (id, name) VALUES (21,"Stansted")');
    }

    public function safeDown()
    {
        echo "m171003_140829_add_dictionaries cannot be reverted.\n";

        return false;
    }
}
