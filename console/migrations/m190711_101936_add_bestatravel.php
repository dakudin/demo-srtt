<?php

use yii\db\Migration;

class m190711_101936_add_bestatravel extends Migration
{
    public function safeUp()
    {

        $this->execute('INSERT INTO quote_company SET id=10, image="best_at_travel.png", company_name="Best At Travel", method_name="createQuoteBestAtTravel", info="We`re a passionate family-run travel company with over 30 years` experience in creating tailor-made luxury holidays and tours around the world. From the moment you get in touch with our Best at Travel experts to the time you return from your holiday you can relax and have peace of mind knowing you`re travelling with a certified ABTA and ATOL certified company, guaranteeing complete financial protection."');

        $this->batchInsert('quote_company_category',
            ['quote_company_id', 'enquiry_category_id'],
            [
                [10,2],
                [10,3],
            ]
        );

        $this->batchInsert('quote_company_destination',
            ['quote_company_id', 'destination_value', 'geo_country', 'geo_country_code', 'geo_city', 'geo_region'],
            [
                [10, '83', 'Argentina', 'AR', '', ''],
                [10, '89', 'Barbados', 'BB', '', ''],
                [10, '100', 'Brazil', 'BR', '', ''],
                [10, '177', 'Cambodia', 'KH', '', ''],
                [10, '334', 'Canada', 'CA', '', ''],
                [10, '113', 'Chile', 'CL', '', ''],
                [10, '116', 'Colombia', 'CO', '', ''],
                [10, '117', 'Costa Rica', 'CR', '', ''],
                [10, '118', 'Cuba', 'CU', '', ''],
                [10, '418', 'Ecuador', 'EC', '', ''],
                [10, '161', 'Honduras', 'HN', '', ''],
                [10, '168', 'India', 'IN', '', ''],
                [10, '165', 'Indonesia', 'ID', '', ''],
                [10, '174', 'Japan', 'JP', '', ''],
                [10, '173', 'Hashemite Kingdom of Jordan', 'JO', '', ''],
                [10, '175', 'Kenya', 'KE', '', ''],
                [10, '216', 'Malaysia', 'MY', '', ''],
                [10, '213', 'Maldives', 'MV', '', ''],
                [10, '215', 'Mexico', 'MX', '', ''],
                [10, '217', 'Mozambique', 'MZ', '', ''],
                [10, '204', 'Myanmar', 'MM', '', ''],
                [10, '229', 'Oman', 'OM', '', ''],
                [10, '230', 'Panama', 'PA', '', ''],
                [10, '231', 'Peru', 'PE', '', ''],
                [10, '296', 'South Africa', 'ZA', '', ''],
                [10, '190', 'Sri Lanka', 'LK', '', ''],
                [10, '274', 'Tanzania', 'TZ', '', ''],
                [10, '264', 'Thailand', 'TH', '', ''],
                [10, '276', 'Uganda', 'UG', '', ''],
                [10, '336', 'United States', 'US', '', ''],
                [10, '284', 'Vietnam', 'VN', '', ''],
                [10, '297', 'Zambia', 'ZM', '', ''],
            ]
        );
    }

    public function safeDown()
    {
        echo "m190711_101936_add_bestatravel cannot be reverted.\n";

        return false;
    }
}
