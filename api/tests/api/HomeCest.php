<?php
/**
 * Created by Kudin Dmitry
 * Date: 23.10.2018
 * Time: 10:40
 */

namespace api\tests\api;

use api\tests\ApiTester;

class HomeCest
{
    public function mainPage(ApiTester $I)
    {
        $I->sendGET('/');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }
}