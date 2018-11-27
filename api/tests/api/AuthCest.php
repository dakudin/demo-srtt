<?php
/**
 * Created by Kudin Dmitry
 * Date: 24.10.2018
 * Time: 13:09
 */

namespace api\tests\api;

use \api\tests\ApiTester;
use common\fixtures\TokenFixture;
use common\fixtures\UserFixture;

class AuthCest
{
    public function _before(ApiTester $I)
    {
        $I->haveFixtures([
            'user' => [
                'class' => UserFixture::className(),
                'dataFile' => codecept_data_dir() . 'user.php'
            ],
            'token' => [
                'class' => TokenFixture::className(),
                'dataFile' => codecept_data_dir() . 'token.php'
            ],
        ]);
    }

    public function badMethod(ApiTester $I)
    {
        $I->sendGET('/auth');
        $I->seeResponseCodeIs(405);
        $I->seeResponseIsJson();
    }

    public function wrongCredentials(ApiTester $I)
    {
        $I->sendPOST('/auth', [
            'email' => 'sfriesen@jenkins.info',
            'password' => 'wrong-password',
        ]);
        $I->seeResponseCodeIs(422);
        $I->seeResponseContainsJson([
            'field' => 'password',
            'message' => 'Incorrect email or password.'
        ]);
    }

    public function success(ApiTester $I)
    {
        $I->sendPOST('/auth', [
            'email' => 'sfriesen@jenkins.info',
            'password' => 'password_0',
        ]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseJsonMatchesJsonPath('$.token');
        $I->seeResponseJsonMatchesJsonPath('$.expired');
    }
}