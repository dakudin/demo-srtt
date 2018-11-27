<?php

use yii\db\Migration;

class m171013_142948_modify_dictionaries extends Migration
{
    public function safeUp()
    {
      $tableOptions = null;
      if ($this->db->driverName === 'mysql') {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
      }

      $this->createTable('dict_region', [
          'id' => $this->primaryKey(),
          'name' => $this->string(30)->notNull()->unique()
      ], $tableOptions);

      $this->execute('INSERT INTO dict_region (id, name) VALUES (1, "Africa & Indian Ocean")');
      $this->execute('INSERT INTO dict_region (id, name) VALUES (2, "Caribbean")');
      $this->execute('INSERT INTO dict_region (id, name) VALUES (3, "Europe")');
      $this->execute('INSERT INTO dict_region (id, name) VALUES (4, "Far East")');
      $this->execute('INSERT INTO dict_region (id, name) VALUES (5, "Indian Sub Continent")');
      $this->execute('INSERT INTO dict_region (id, name) VALUES (6, "North Africa & Middle East")');
      $this->execute('INSERT INTO dict_region (id, name) VALUES (7, "Central & South America")');
      $this->execute('INSERT INTO dict_region (id, name) VALUES (8, "Usa and Canada")');

      $this->addColumn('dict_country', 'dict_region_id', 'INT(11)');

      $this->execute('UPDATE dict_country SET dict_region_id=3 WHERE id=6');
      $this->execute('UPDATE dict_country SET dict_region_id=3 WHERE id=1');
      $this->execute('UPDATE dict_country SET dict_region_id=3 WHERE id=7');
      $this->execute('UPDATE dict_country SET dict_region_id=8 WHERE id=11');
      $this->execute('UPDATE dict_country SET dict_region_id=3 WHERE id=2');
      $this->execute('UPDATE dict_country SET dict_region_id=3 WHERE id=3');
      $this->execute('UPDATE dict_country SET dict_region_id=3 WHERE id=4');
      $this->execute('UPDATE dict_country SET dict_region_id=8 WHERE id=10');

      $this->alterColumn('dict_country', 'dict_region_id', 'INT(11) NOT NULL');
      $this->createIndex('idx_dict_region', 'dict_country', 'dict_region_id');
      $this->addForeignKey('fk_dict_country2dict_region', 'dict_country', 'dict_region_id', 'dict_region', 'id', 'CASCADE', 'CASCADE');

      $this->alterColumn('company_country', 'service_country_id', 'VARCHAR(10) DEFAULT NULL');
      $this->alterColumn('company_airport', 'service_airport_id', 'VARCHAR(10) DEFAULT NULL');
      $this->alterColumn('company_resort', 'service_resort_id', 'VARCHAR(10) DEFAULT NULL');

      $this->execute('INSERT INTO quote_company (id, image, company_name) VALUES (5, "kuoni.png", "Kuoni")');

      $this->createTable('company_region', [
          'quote_company_id' => $this->integer(11)->notNull(),
          'region_id' => $this->integer(11)->notNull(),
          'service_region_id' => $this->string(10)->notNull()
      ], $tableOptions);

      $this->createIndex('uk_company_region', 'company_region', ['quote_company_id','region_id'], true);
      $this->createIndex('idx_company', 'company_region', 'quote_company_id');
      $this->addForeignKey('fk_company_region2dict_region', 'company_region', 'region_id', 'dict_region' , 'id', 'CASCADE', 'CASCADE');
      $this->addForeignKey('fk_company_region2quote_company', 'company_region', 'quote_company_id', 'quote_company' , 'id', 'CASCADE', 'CASCADE');

      $this->execute('INSERT INTO company_region (quote_company_id, region_id, service_region_id) VALUES (5, 1, "A10000")');
      $this->execute('INSERT INTO company_region (quote_company_id, region_id, service_region_id) VALUES (5, 2, "A20000")');
      $this->execute('INSERT INTO company_region (quote_company_id, region_id, service_region_id) VALUES (5, 3, "A30000")');
      $this->execute('INSERT INTO company_region (quote_company_id, region_id, service_region_id) VALUES (5, 4, "A40000")');
      $this->execute('INSERT INTO company_region (quote_company_id, region_id, service_region_id) VALUES (5, 5, "A50000")');
      $this->execute('INSERT INTO company_region (quote_company_id, region_id, service_region_id) VALUES (5, 6, "A60000")');
      $this->execute('INSERT INTO company_region (quote_company_id, region_id, service_region_id) VALUES (5, 7, "A70000")');
      $this->execute('INSERT INTO company_region (quote_company_id, region_id, service_region_id) VALUES (5, 8, "A80000")');


/////Africa & Indian Ocean//////
      //Kenya
      $this->execute('INSERT INTO dict_country (id, name, dict_region_id) VALUES (12, "Kenya", 1)');
      $this->execute('INSERT INTO company_country (quote_company_id, country_id, service_country_id) VALUES (5, 12, "A10100")');

      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (294, "Nairobi", 12)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 294, "A10101")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (295, "Safari", 12)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 295, "A10102")');


      //Mauritius
      $this->execute('INSERT INTO dict_country (id, name, dict_region_id) VALUES (13, "Mauritius", 1)');
      $this->execute('INSERT INTO company_country (quote_company_id, country_id, service_country_id) VALUES (5, 13, "A10200")');

      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (296, "Mauritius", 13)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 296, "A10201")');

      //Maldives
      $this->execute('INSERT INTO dict_country (id, name, dict_region_id) VALUES (14, "Maldives", 1)');
      $this->execute('INSERT INTO company_country (quote_company_id, country_id, service_country_id) VALUES (5, 14, "A10300")');

      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (297, "Gan Island", 14)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 297, "A10301")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (298, "Maldives", 14)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 298, "A10302")');

      //Reunion Island
      $this->execute('INSERT INTO dict_country (id, name, dict_region_id) VALUES (15, "Reunion Island", 1)');
      $this->execute('INSERT INTO company_country (quote_company_id, country_id, service_country_id) VALUES (5, 15, "A10400")');

      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (299, "Reunion Island", 15)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 299, "A10401")');

      //Seychelles
      $this->execute('INSERT INTO dict_country (id, name, dict_region_id) VALUES (16, "Seychelles", 1)');
      $this->execute('INSERT INTO company_country (quote_company_id, country_id, service_country_id) VALUES (5, 16, "A10500")');

      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (300, "Mahe", 16)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 300, "A10501")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (301, "Silhouette Island", 16)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 301, "A10502")');

      //Tanzania
      $this->execute('INSERT INTO dict_country (id, name, dict_region_id) VALUES (17, "Tanzania", 1)');
      $this->execute('INSERT INTO company_country (quote_company_id, country_id, service_country_id) VALUES (5, 17, "A10600")');

      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (302, "Kilimanjaro", 17)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 302, "A10601")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (303, "Zanzibar", 17)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 303, "A10602")');

      //South Africa
      $this->execute('INSERT INTO dict_country (id, name, dict_region_id) VALUES (18, "South Africa", 1)');
      $this->execute('INSERT INTO company_country (quote_company_id, country_id, service_country_id) VALUES (5, 18, "A10700")');

      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (304, "Cape Town", 18)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 304, "A10701")');

/////Caribbean//////
      //Antigua
      $this->execute('INSERT INTO dict_country (id, name, dict_region_id) VALUES (19, "Antigua", 2)');
      $this->execute('INSERT INTO company_country (quote_company_id, country_id, service_country_id) VALUES (5, 19, "A20100")');

      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (305, "Antigua", 19)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 305, "A20101")');

      //Aruba
      $this->execute('INSERT INTO dict_country (id, name, dict_region_id) VALUES (20, "Aruba", 2)');
      $this->execute('INSERT INTO company_country (quote_company_id, country_id, service_country_id) VALUES (5, 20, "A20200")');

      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (306, "Aruba", 20)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 306, "A20201")');

      //Barbados
      $this->execute('INSERT INTO dict_country (id, name, dict_region_id) VALUES (21, "Barbados", 2)');
      $this->execute('INSERT INTO company_country (quote_company_id, country_id, service_country_id) VALUES (5, 21, "A20300")');

      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (307, "Barbados", 21)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 307, "A20301")');

      //Bermuda
      $this->execute('INSERT INTO dict_country (id, name, dict_region_id) VALUES (22, "Bermuda", 2)');
      $this->execute('INSERT INTO company_country (quote_company_id, country_id, service_country_id) VALUES (5, 22, "A20400")');

      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (308, "Bermuda", 22)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 308, "A20401")');

      //Bahamas
      $this->execute('INSERT INTO dict_country (id, name, dict_region_id) VALUES (23, "Bahamas", 2)');
      $this->execute('INSERT INTO company_country (quote_company_id, country_id, service_country_id) VALUES (5, 23, "A20500")');

      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (309, "Nassau", 23)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 309, "A20501")');

      //Cuba
      $this->execute('INSERT INTO dict_country (id, name, dict_region_id) VALUES (24, "Cuba", 2)');
      $this->execute('INSERT INTO company_country (quote_company_id, country_id, service_country_id) VALUES (5, 24, "A20600")');

      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (310, "Havana", 24)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 310, "A20601")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (311, "Jibacoa", 24)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 311, "A20602")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (312, "Cayo Santa Maria", 24)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 312, "A20603")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (313, "Varadero", 24)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 313, "A20604")');

      //Dominican Republic
      $this->execute('INSERT INTO dict_country (id, name, dict_region_id) VALUES (25, "Dominican Republic", 2)');
      $this->execute('INSERT INTO company_country (quote_company_id, country_id, service_country_id) VALUES (5, 25, "A20700")');

      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (314, "Bavero", 25)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 314, "A20701")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (315, "Bayahibe", 25)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 315, "A20702")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (316, "Punta Cana", 25)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 316, "A20703")');

      //Grenada
      $this->execute('INSERT INTO dict_country (id, name, dict_region_id) VALUES (26, "Grenada", 2)');
      $this->execute('INSERT INTO company_country (quote_company_id, country_id, service_country_id) VALUES (5, 26, "A20800")');

      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (317, "Grenada", 26)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 317, "A20801")');

      //Jamaica
      $this->execute('INSERT INTO dict_country (id, name, dict_region_id) VALUES (27, "Jamaica", 2)');
      $this->execute('INSERT INTO company_country (quote_company_id, country_id, service_country_id) VALUES (5, 27, "A20900")');

      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (318, "Jamaica", 27)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 318, "A20901")');

      //St Kitts and Nevis
      $this->execute('INSERT INTO dict_country (id, name, dict_region_id) VALUES (28, "St Kitts and Nevis", 2)');
      $this->execute('INSERT INTO company_country (quote_company_id, country_id, service_country_id) VALUES (5, 28, "A21000")');

      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (319, "Nevis", 28)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 319, "A21001")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (320, "St Kitts", 28)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 320, "A21002")');

      //St Lucia
      $this->execute('INSERT INTO dict_country (id, name, dict_region_id) VALUES (29, "St Lucia", 2)');
      $this->execute('INSERT INTO company_country (quote_company_id, country_id, service_country_id) VALUES (5, 29, "A21100")');

      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (321, "St Lucia", 29)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 321, "A21101")');

      //Trinidad and Tobago
      $this->execute('INSERT INTO dict_country (id, name, dict_region_id) VALUES (30, "Trinidad and Tobago", 2)');
      $this->execute('INSERT INTO company_country (quote_company_id, country_id, service_country_id) VALUES (5, 30, "A21200")');

      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (322, "Tobago", 30)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 322, "A21201")');

/////Europe//////
      //Cyprus
      $this->execute('INSERT INTO dict_country (id, name, dict_region_id) VALUES (31, "Cyprus", 3)');
      $this->execute('INSERT INTO company_country (quote_company_id, country_id, service_country_id) VALUES (5, 31, "A30100")');

      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (323, "Limassol", 31)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 323, "A30101")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (324, "Paphos - Cyprus", 31)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 324, "A30102")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (325, "Pissouri", 31)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 325, "A30103")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (326, "Polis", 31)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 326, "A30104")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (327, "Protaras", 31)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 327, "A30105")');

      //Spain
      $this->execute('INSERT INTO dict_country (id, name, dict_region_id) VALUES (32, "Spain", 3)');
      $this->execute('INSERT INTO company_country (quote_company_id, country_id, service_country_id) VALUES (5, 32, "A30200")');

      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (328, "Lanzarote", 32)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 328, "A30201")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (329, "Ibiza", 32)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 329, "A30202")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (330, "Menorca", 32)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 330, "A30203")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (331, "Mallorca", 32)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 331, "A30204")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (332, "Tenerife", 32)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 332, "A30205")');

      //Greece
      $this->execute('INSERT INTO dict_country (id, name, dict_region_id) VALUES (33, "Greece", 3)');
      $this->execute('INSERT INTO company_country (quote_company_id, country_id, service_country_id) VALUES (5, 33, "A30300")');

      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (333, "Crete", 33)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 333, "A30301")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (334, "Halkidiki", 33)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 334, "A30302")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (335, "Mykonos", 33)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 335, "A30303")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (336, "Navarino", 33)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 336, "A30304")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (337, "Rhodes", 33)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 337, "A30305")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (338, "Santorini", 33)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 338, "A30306")');

      //Croatia
      $this->execute('INSERT INTO dict_country (id, name, dict_region_id) VALUES (34, "Croatia", 3)');
      $this->execute('INSERT INTO company_country (quote_company_id, country_id, service_country_id) VALUES (5, 34, "A30400")');

      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (339, "Dubrovnik", 34)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 339, "A30401")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (340, "Hvar", 34)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 340, "A30402")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (341, "Split", 34)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 341, "A30403")');

      //Italy
      $this->execute('INSERT INTO company_country (quote_company_id, country_id, service_country_id) VALUES (5, 3, "A30500")');

      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (342, "Amalfi Coast", 3)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 342, "A30501")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (343, "Artimino", 3)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 343, "A30502")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (344, "Bellagio", 3)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 344, "A30503")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (345, "Blevio", 3)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 345, "A30504")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (346, "Fasano", 3)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 346, "A30505")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (347, "Rome", 3)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 347, "A30506")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (348, "Florence", 3)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 348, "A30507")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (349, "Ischia", 3)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 349, "A30508")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (350, "Lake Garda", 3)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 350, "A30509")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (351, "Lecce", 3)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 351, "A30510")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (352, "Menaggio", 3)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 352, "A30511")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (353, "Milan", 3)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 353, "A30512")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (354, "Positano", 3)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 354, "A30513")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (355, "Capri", 3)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 355, "A30514")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (356, "Ravello", 3)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 356, "A30515")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (357, "Sardinia North", 3)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 357, "A30516")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (358, "Sardinia South", 3)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 358, "A30517")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (359, "Sciacca", 3)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 359, "A30518")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (360, "Sorrento", 3)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 360, "A30519")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (361, "Taomina Mare", 3)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 361, "A30520")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (362, "Taormina", 3)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 362, "A30521")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (363, "Tremezzo", 3)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 363, "A30522")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (364, "Venice", 3)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 364, "A30523")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (365, "Verona", 3)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 365, "A30524")');

      //Malta
      $this->execute('INSERT INTO dict_country (id, name, dict_region_id) VALUES (35, "Malta", 3)');
      $this->execute('INSERT INTO company_country (quote_company_id, country_id, service_country_id) VALUES (5, 35, "A30600")');

      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (366, "Gozo", 35)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 366, "A30601")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (367, "Malta", 35)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 367, "A30602")');

      //Portugal
      $this->execute('INSERT INTO dict_country (id, name, dict_region_id) VALUES (36, "Portugal", 3)');
      $this->execute('INSERT INTO company_country (quote_company_id, country_id, service_country_id) VALUES (5, 36, "A30700")');

      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (368, "Algarve", 36)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 368, "A30701")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (369, "Cascais", 36)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 369, "A30702")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (370, "Funchal", 36)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 370, "A30703")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (371, "Madeira", 36)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 371, "A30704")');

      //Turkey
      $this->execute('INSERT INTO dict_country (id, name, dict_region_id) VALUES (37, "Turkey", 3)');
      $this->execute('INSERT INTO company_country (quote_company_id, country_id, service_country_id) VALUES (5, 37, "A30800")');

      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (372, "Belek", 37)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 372, "A30801")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (373, "Bodrum", 37)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 373, "A30802")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (374, "Datca Peninsula", 37)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 374, "A30803")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (375, "Fethiye", 37)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 375, "A30804")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (376, "Gocek", 37)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 376, "A30805")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (377, "Olu Deniz", 37)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 377, "A30806")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (378, "Sarigerme", 37)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 378, "A30807")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (379, "Turgutreis", 37)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 379, "A30808")');

////Far East//////
      //China
      $this->execute('INSERT INTO dict_country (id, name, dict_region_id) VALUES (38, "China", 4)');
      $this->execute('INSERT INTO company_country (quote_company_id, country_id, service_country_id) VALUES (5, 38, "A40100")');

      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (380, "Beijing", 38)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 380, "A40101")');

      //Hong Kong
      $this->execute('INSERT INTO dict_country (id, name, dict_region_id) VALUES (39, "Hong Kong", 4)');
      $this->execute('INSERT INTO company_country (quote_company_id, country_id, service_country_id) VALUES (5, 39, "A40200")');

      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (381, "Hong Kong", 39)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 381, "A40201")');

      //Indonesia
      $this->execute('INSERT INTO dict_country (id, name, dict_region_id) VALUES (40, "Indonesia", 4)');
      $this->execute('INSERT INTO company_country (quote_company_id, country_id, service_country_id) VALUES (5, 40, "A40300")');

      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (382, "Lombok", 40)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 382, "A40301")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (383, "Bali", 40)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 383, "A40302")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (384, "Gili Island", 40)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 384, "A40303")');

      //Cambodia
      $this->execute('INSERT INTO dict_country (id, name, dict_region_id) VALUES (41, "Cambodia", 4)');
      $this->execute('INSERT INTO company_country (quote_company_id, country_id, service_country_id) VALUES (5, 41, "A40400")');

      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (385, "Phnom Penh", 41)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 385, "A40401")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (386, "Siem Reap", 41)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 386, "A40402")');

      //Laos
      $this->execute('INSERT INTO dict_country (id, name, dict_region_id) VALUES (42, "Laos", 4)');
      $this->execute('INSERT INTO company_country (quote_company_id, country_id, service_country_id) VALUES (5, 42, "A40500")');

      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (387, "Luang Prabang", 42)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 387, "A40501")');

      //Malaysia
      $this->execute('INSERT INTO dict_country (id, name, dict_region_id) VALUES (43, "Malaysia", 4)');
      $this->execute('INSERT INTO company_country (quote_company_id, country_id, service_country_id) VALUES (5, 43, "A40600")');

      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (388, "Kota Kinabalu", 43)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 388, "A40601")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (389, "Kuching", 43)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 389, "A40602")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (390, "Kuala Lumpur", 43)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 390, "A40603")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (391, "Langkawi", 43)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 391, "A40604")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (392, "Penang", 43)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 392, "A40605")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (393, "Pangkor Laut", 43)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 393, "A40606")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (394, "Kuala Terennganu", 43)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 394, "A40607")');

      //Singapore
      $this->execute('INSERT INTO dict_country (id, name, dict_region_id) VALUES (44, "Singapore", 4)');
      $this->execute('INSERT INTO company_country (quote_company_id, country_id, service_country_id) VALUES (5, 44, "A40700")');

      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (395, "Singapore", 44)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 395, "A40701")');

      //Thailand
      $this->execute('INSERT INTO dict_country (id, name, dict_region_id) VALUES (45, "Thailand", 4)');
      $this->execute('INSERT INTO company_country (quote_company_id, country_id, service_country_id) VALUES (5, 45, "A40800")');

      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (396, "Bangkok", 45)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 396, "A40801")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (397, "Chiang Mai", 45)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 397, "A40802")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (398, "Phuket", 45)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 398, "A40803")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (399, "Hua Hin", 45)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 399, "A40804")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (400, "Khao Lak", 45)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 400, "A40805")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (401, "Koh Phang Ngan", 45)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 401, "A40806")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (402, "Krabi", 45)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 402, "A40807")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (403, "Krabi Rayavadee", 45)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 403, "A40808")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (404, "Koh Samet", 45)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 404, "A40809")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (405, "Lanta Yai", 45)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 405, "A40810")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (406, "Phang Nga", 45)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 406, "A40811")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (407, "Phi Phi Island", 45)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 407, "A40812")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (408, "Koh Samui", 45)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 408, "A40813")');

      //Vietnam
      $this->execute('INSERT INTO dict_country (id, name, dict_region_id) VALUES (46, "Vietnam", 4)');
      $this->execute('INSERT INTO company_country (quote_company_id, country_id, service_country_id) VALUES (5, 46, "A40900")');

      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (409, "Danang", 46)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 409, "A40901")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (410, "Hanoi", 46)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 410, "A40902")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (411, "Hoi An", 46)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 411, "A40903")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (412, "Phan Thiet", 46)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 412, "A40904")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (413, "Ho Chi Minh City", 46)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 413, "A40905")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (414, "Vietnam Tour", 46)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 414, "A40906")');

////Indian Sub Continent//////
      //India
      $this->execute('INSERT INTO dict_country (id, name, dict_region_id) VALUES (47, "India", 5)');
      $this->execute('INSERT INTO company_country (quote_company_id, country_id, service_country_id) VALUES (5, 47, "A50100")');

      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (415, "Delhi", 47)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 415, "A50101")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (416, "Goa", 47)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 416, "A50102")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (417, "Kerala", 47)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 417, "A50103")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (418, "Marari", 47)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 418, "A50104")');

      //Sri Lanka
      $this->execute('INSERT INTO dict_country (id, name, dict_region_id) VALUES (48, "Sri Lanka", 5)');
      $this->execute('INSERT INTO company_country (quote_company_id, country_id, service_country_id) VALUES (5, 48, "A50200")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (419, "Anuradhapura", 48)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 419, "A50201")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (420, "Beruwala", 48)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 420, "A50202")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (421, "Bentota", 48)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 421, "A50203")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (422, "Colombo", 48)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 422, "A50204")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (423, "Dickwella", 48)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 423, "A50205")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (424, "Galle", 48)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 424, "A50206")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (425, "Habarana", 48)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 425, "A50207")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (426, "Hambantota", 48)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 426, "A50208")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (427, "Kalutara", 48)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 427, "A50209")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (428, "Kandy", 48)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 428, "A50210")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (429, "Koggala", 48)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 429, "A50211")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (430, "Mount Lavinia", 48)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 430, "A50212")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (431, "Negombo", 48)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 431, "A50213")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (432, "Passikudah", 48)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 432, "A50214")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (433, "Tangalle", 48)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 433, "A50215")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (434, "Trincomalee", 48)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 434, "A50216")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (435, "Waikkal", 48)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 435, "A50217")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (436, "Weligama", 48)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 436, "A50218")');

////North Africa & Middle East//////
      //Arab Emirates
      $this->execute('INSERT INTO dict_country (id, name, dict_region_id) VALUES (49, "Arab Emirates", 6)');
      $this->execute('INSERT INTO company_country (quote_company_id, country_id, service_country_id) VALUES (5, 49, "A60100")');


      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (437, "Abu Dhabi", 49)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 437, "A60101")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (438, "Dubai", 49)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 438, "A60102")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (439, "Ras Al Khaimah", 49)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 439, "A60103")');

      //Egypt
      $this->execute('INSERT INTO dict_country (id, name, dict_region_id) VALUES (50, "Egypt", 6)');
      $this->execute('INSERT INTO company_country (quote_company_id, country_id, service_country_id) VALUES (5, 50, "A60200")');

      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (440, "Aswan", 50)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 440, "A60201")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (441, "Cairo", 50)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 441, "A60202")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (442, "Cruise Within Egypt", 50)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 442, "A60203")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (443, "El Gouna", 50)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 443, "A60204")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (444, "Hurghada", 50)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 444, "A60205")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (445, "Luxor", 50)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 445, "A60206")');

      //Morocco
      $this->execute('INSERT INTO dict_country (id, name, dict_region_id) VALUES (51, "Morocco", 6)');
      $this->execute('INSERT INTO company_country (quote_company_id, country_id, service_country_id) VALUES (5, 51, "A60300")');

      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (446, "Essaouira", 51)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 446, "A60301")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (447, "Marrakech", 51)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 447, "A60302")');

      //Oman
      $this->execute('INSERT INTO dict_country (id, name, dict_region_id) VALUES (52, "Oman", 6)');
      $this->execute('INSERT INTO company_country (quote_company_id, country_id, service_country_id) VALUES (5, 52, "A60400")');

      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (448, "Muscat", 52)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 448, "A60401")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (449, "Musandam Peninsula", 52)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 449, "A60402")');

      //Qatar
      $this->execute('INSERT INTO dict_country (id, name, dict_region_id) VALUES (53, "Qatar", 6)');
      $this->execute('INSERT INTO company_country (quote_company_id, country_id, service_country_id) VALUES (5, 53, "A60500")');

      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (450, "Doha", 53)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 450, "A60501")');

////Central & South America//////
      //Mexico
      $this->execute('INSERT INTO dict_country (id, name, dict_region_id) VALUES (54, "Mexico", 7)');
      $this->execute('INSERT INTO company_country (quote_company_id, country_id, service_country_id) VALUES (5, 54, "A70100")');

      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (451, "Cancun", 54)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 451, "A70101")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (452, "Playa Mujeres", 54)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 452, "A70102")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (453, "Playa Del Carmen", 54)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 453, "A70103")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (454, "Puerto Morelos", 54)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 454, "A70104")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (455, "Tulum", 54)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 455, "A70105")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (456, "Xcaret", 54)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 456, "A70106")');

////Usa and Canada//////
      $this->execute('INSERT INTO company_country (quote_company_id, country_id, service_country_id) VALUES (5, 10, "A80100")');

      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (457, "Las Vegas", 10)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 457, "A80101")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (458, "New York", 10)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 458, "A80102")');
      $this->execute('INSERT INTO dict_resort (id, name, dict_country_id) VALUES (459, "San Francisco", 10)');
      $this->execute('INSERT INTO company_resort (quote_company_id, resort_id, service_resort_id) VALUES (5, 459, "A80103")');


//Airports
      $this->execute('INSERT INTO company_airport (quote_company_id, airport_id, service_airport_id) VALUES (5, 27, "APL001")');
      $this->execute('INSERT INTO company_airport (quote_company_id, airport_id, service_airport_id) VALUES (5, 5, "APL002")');
      $this->execute('INSERT INTO company_airport (quote_company_id, airport_id, service_airport_id) VALUES (5, 22, "APL003")');
      $this->execute('INSERT INTO company_airport (quote_company_id, airport_id, service_airport_id) VALUES (5, 21, "APL004")');

      $this->execute('INSERT INTO dict_airport (id, name) VALUES (44,"London City")');
      $this->execute('INSERT INTO company_airport (quote_company_id, airport_id, service_airport_id) VALUES (5, 44, "APL005")');

      $this->execute('INSERT INTO company_airport (quote_company_id, airport_id, service_airport_id) VALUES (5, 20, "APO001")');
      $this->execute('INSERT INTO company_airport (quote_company_id, airport_id, service_airport_id) VALUES (5, 6, "APO002")');
      $this->execute('INSERT INTO company_airport (quote_company_id, airport_id, service_airport_id) VALUES (5, 7, "APO003")');
      $this->execute('INSERT INTO company_airport (quote_company_id, airport_id, service_airport_id) VALUES (5, 9, "APO004")');
      $this->execute('INSERT INTO company_airport (quote_company_id, airport_id, service_airport_id) VALUES (5, 11, "APO005")');
    }

    public function safeDown()
    {
        echo "m171013_142948_modify_dictionaries cannot be reverted.\n";

        return false;
    }
}
