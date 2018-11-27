<?php
/**
 * Created by Kudin Dmitry
 * Date: 30.10.2018
 * Time: 20:52
 */

namespace common\components;

use Yii;
use yii\authclient\OAuth2;
use yii\helpers\Json;

/**
 * Amazon OAuth2
 *
 * At first need to register own application at <http://login.amazon.com/manageApps>.
 *
 * Sample `Callback URL`:
 *
 * `https://exampledomain.com/1_oauth/frontend/web/index.php/site/auth?authclient=amazon`
 *
 * Example application configuration:
 *
 * ```php
 * 'components' => [
 *     'authClientCollection' => [
 *         'class' => 'yii\authclient\Collection',
 *         'clients' => [
 *             'amazon' => [
 *                 'class' => 'yii\authclient\clients\Amazon',
 *                 'clientId' => 'amazon_client_id',
 *                 'clientSecret' => 'amazon_client_secret',
 *             ],
 *         ],
 *     ]
 *     // ...
 * ]
 * ```
 *
 * [EXAMPLE RESPONSE]
 *
 * Authorization URL:
 *
 * ```
 * https://www.amazon.com/ap/oa?client_id=amzn1.application-oa2-client.a0e54471f93d4381a217ad024d3f3e5a&response_type=code&redirect_uri=https://demo.demosortit.com/auth?authclient=amazon&xoauth_displayname=SortIt&scope=alexa:all&scope_data={"alexa:all":{"productID":"sortit_product_id","productInstanceAttributes":{"deviceSerialNumber":"12345"}}}&state=bc4a0fd3914e708c57b60160c5ba1d9cf44ff1d5da210d5ff49d0a548c55b339
 *
 * php
 * Array
 * (
 *  [client_id] => amzn1.application-oa2-client.a0e54471f93d4381a217ad024d3f3e5a
 *  [redirect_uri] => https://demo.demosortit.com/auth?authclient=amazon
 *  [response_type] => code
 *  [scope] => alexa:all
 *  [scope_data] => {"alexa:all":{"productID":"sortit_product_id","productInstanceAttributes":{"deviceSerialNumber":"12345"}}}
 *  [state] =>  bc4a0fd3914e708c57b60160c5ba1d9cf44ff1d5da210d5ff49d0a548c55b339
 *  [xoauth_displayname] => SortIt
 * )
 *
 * https://www.amazon.com/ap/signin?_encoding=UTF8&openid.mode=checkid_setup&openid.ns=http://specs.openid.net/auth/2.0&openid.claimed_id=http://specs.openid.net/auth/2.0/identifier_select&openid.pape.max_auth_age=0&ie=UTF8&openid.ns.pape=http://specs.openid.net/extensions/pape/1.0&openid.identity=http://specs.openid.net/auth/2.0/identifier_select&pageId=lwa&openid.assoc_handle=amzn_lwa_na&marketPlaceId=ATVPDKIKX0DER&arb=9faf1178-2e98-4d9f-b30c-10e17aed5c18&language=en_US&openid.return_to=https://na.account.amazon.com/ap/oa?marketPlaceId=ATVPDKIKX0DER&arb=9faf1178-2e98-4d9f-b30c-10e17aed5c18&language=en_US&enableGlobalAccountCreation=1&metricIdentifier=amzn1.application.9b64fe005d914f96b90769edb301bc66&signedMetricIdentifier=QrI5eSbuHHETWOE2r1eIbjNsVkZMWskWDMaQ/cZPnP0=
 * ```
 *
 * AccessToken Request:
 *
 * ```
 * https://api.amazon.com/auth/o2/token
 * ```
 *
 * AccessToken Response:
 *
 * ```
 * {"access_token":"Atza|IwEBIBwZ5x52Bkt2hMraELedoaLP6mtmuW_Y1rMJVuSUTRxJcXRRtZEdsQs9qYgSfnyr6xHxcxjxJ9u1e2NZmC0FU4m3eWB6JoptMLQH3StqfOyYJK8e1L2lz149DczqLo5G9wAVFPI3rvkwbEy75EHN71AHrXNk7XmXqiwxEtkHUN8L2xclRGupA-WclwQCcsNEev7G-f8x4OsUjEzOTRiewyzYGvVUI2Nx6PP5PSbkXKU4WUvUtb8zj6wOHh1WzS5Ubyz2mXOP7rQAsxdXsIFgxOm1kLSrsuIwocDh7Tim7WXxGj50WXpG7NB57SV4nHf3i5yj_eLtYGW3us_cZXHdOCgqQ2Ky-IjXcDSqNIF7KWuqrn5dXg95mMsC9z4SVoCi1aOzg_o7t1V_twuB97sUIfBMpYMVzGvDx5afn3N5eBJ8H95eDK6s4Y2UKgclTlMT1vTUnGaphxAf9kVacv0bkpgB7a9B8ALcfnYtg7HKn2u05x0OOUHSktmS6Tk6W55sK1GON60vqRwYUydvt4lquqhYLzPdMqVWt9LGUWVlAHOCQg","refresh_token":"Atzr|IwEBICEi_pAezBPPDro-sDLyjwiNZ773sZ5Ley77oVWQ0R_icstPyez-YgDrj0SLg2SfAPKZUV4fgox8DlvvRuf3uAXcZmQyFV9RHs3nNvqMCEiEmtHe0_hFtvxSSSwjs57tBaKoVQW_H7y19O4bnH4HmEV1nt6atRElBIYnIwkDvbfXRqx2van0a-g2UcNlcEL4dipkrFPPjj1WWhruzaIkal8bPlC_LaR0gP2RBwiJBp4wh8gt-h7cK1WiaV6OHJ75lMv45lHxc9Fg7KhvN9U9aV_zkeNKoHl8a7KgD_i-muC_eILjp5psJtSiE8QfW91Yeq-ZNXk1u-De4fQV-Nzt-GKmwhDjc3k9pQ_bQ0qUObf4Moa88c_707SNr-fW-qY7xB5OCW_rvdKDhhZr6Sk6e0R5tFoJ0QTjTWQ8ounhqjQkwZX5uX8Irlc8gX9JKKZU1XB-MSN5GNgwKTzEYEUpldhdG-e6yN5fAj4f1uDRrQlTgByhZcMeRwH7UUyka5UT7us","token_type":"bearer","expires_in":3600}
 * ```
 *
 * Request of `initUserAttributes()`:
 *
 * ```
 * https://api.amazon.com/auth/O2/tokeninfo?access_token=Atza%7CIwEBIJosLKZKHE5BFowqIt_dABUG37ZVlwD5UxrYvaXynLLVApiRS-8mibC-S6FgNwot2FunjIQmFky3C-AsG3G0n2TfIH_9MOjWTagbUuiZGc-NPc_AzAXCbL6N_RU582_UIM3kQadC8g36nlFscQDeE3hHmr63Stzsan9lpvgpNBCLBNKAZw0-P4nxJgOWGyFBme0O8nf_6xRfbR1C0lQyr1RMmAvJWHBJEC03T3NVATxa8trONBmEQyJIh8Br0SbpwbeR37QUD113uSh65vxLPt036oIraYJSvBXsL73so3JN_OKxmJISJzYEmSl1Ie_iDAepmkNLSc1vSXWo5yW6yiboTyg8paeLrX6cIZQ-jXR7mRTQ99vbt9NWDL52_sc2MzTemZR_ut3xlX986wXGkP0bS6hgfV5wFFFxT6yTdFhphZ0LfP2rj7bokly2C7XK_KEMwLLBVz3ohdt92PZNaGwOz6Aqm-DZrJyU5PCR-o3EWvyLWPeMXfMH8vphh59VpkvDl7YPEZF1duHk8or4fTnTYScnkrvijxpnMrDHGE73peVFNFoKa7SCMUAo6OW0k0k
 * ```
 *
 * Response of `initUserAttributes()`:
 *
 * ```
 * {"aud":"amzn1.application-oa2-client.c3b534c90a274981a45e53f47234f314","user_id":"amzn1.account.AHUQEJPGF47GOIO4UOPDWAHKTXCS","iss":"https://www.amazon.com","exp":3598,"app_id":"amzn1.application.f235c23fdd3c64845baed7a604820fad8","iat":1423863856}
 * ```
 *
 * ```php
 * Array
 * (
 *     [aud] => amzn1.application-oa2-client.c3b534c90a274981a45e53f47234f314
 *     [user_id] => amzn1.account.AHUQEJPGF47GOIO4UOPDWAHKTXCS
 *     [iss] => https://www.amazon.com
 *     [exp] => 3598
 *     [app_id] => amzn1.application.f235c23fdd3c64845baed7a604820fad8
 *     [iat] => 1423863856
 *     [provider] => amazon
 *     [openid] => amzn1.account.AHUQEJPGF47GOIO4UOPDWAHKTXCS
 * )
 * ```
 *
 * Request of `initUserInfoAttributes()`:
 *
 * ```
 * https://api.amazon.com//user/profile?access_token=Atza%7CIwEBIJosLKZKHE5BFowqIt_dABUG37ZVlwD5UxrYvaXynLLVApiRS-8mibC-S6FgNwot2FunjIQmFky3C-AsG3G0n2TfIH_9MOjWTagbUuiZGc-NPc_AzAXCbL6N_RU582_UIM3kQadC8g36nlFscQDeE3hHmr63Stzsan9lpvgpNBCLBNKAZw0-P4nxJgOWGyFBme0O8nf_6xRfbR1C0lQyr1RMmAvJWHBJEC03T3NVATxa8trONBmEQyJIh8Br0SbpwbeR37QUD113uSh65vxLPt036oIraYJSvBXsL73so3JN_OKxmJISJzYEmSl1Ie_iDAepmkNLSc1vSXWo5yW6yiboTyg8paeLrX6cIZQ-jXR7mRTQ99vbt9NWDL52_sc2MzTemZR_ut3xlX986wXGkP0bS6hgfV5wFFFxT6yTdFhphZ0LfP2rj7bokly2C7XK_KEMwLLBVz3ohdt92PZNaGwOz6Aqm-DZrJyU5PCR-o3EWvyLWPeMXfMH8vphh59VpkvDl7YPEZF1duHk8or4fTnTYScnkrvijxpnMrDHGE73peVFNFoKa7SCMUAo6OW0k0k
 * ```
 *
 * Response of `initUserInfoAttributes()`:
 *
 * ```
 * {"user_id":"amzn1.account.AHUQEJPGF47GOIO4UOPDWAHKTXCS","name":"johndoe","email":"johndoe@example.com"}"
 * ```
 *
 * ```php
 * Array
 * (
 *     [aud] => amzn1.application-oa2-client.c3b534c90a274981a45e53f47234f314
 *     [user_id] => amzn1.account.AHUQEJPGF47GOIO4UOPDWAHKTXCS
 *     [iss] => https://www.amazon.com
 *     [exp] => 1234
 *     [app_id] => amzn1.application.f235c23fdd3c64845baed7a604820fad8
 *     [iat] => 1423863856
 *     [provider] => amazon
 *     [openid] => amzn1.account.AHUQEJPGF47GOIO4UOPDWAHKTXCS
 *     [name] => johndoe
 *     [email] => johndoe@example.com
 *     [fullname] => John Doe
 * )
 * ```
 *
 * [REFERENCES]
 *
 * @see https://developer.amazon.com/docs/alexa-voice-service/authorize-companion-site.html
 * @see http://login.amazon.com/website
 * @see https://images-na.ssl-images-amazon.com/images/G/01/lwa/dev/docs/website-developer-guide._TTH_.pdf
 */

class AmazonAuthClient extends OAuth2
{
    /**
     * @inheritdoc
     */
    public $authUrl = 'https://www.amazon.com/ap/oa';

    /**
     * @inheritdoc
     */
    public $tokenUrl = 'https://api.amazon.com/auth/o2/token';

    /**
     * @inheritdoc
     */
    public $apiBaseUrl = 'https://api.amazon.com';

    /**
     * @inheritdoc
     */
    public $scope = 'alexa:all profile';
//    public $scope = 'alexa:all';

    public $productId = 'sortit_product_id';

    public $deviceSerialNumber = '12345';

    public $scopeData = [
        'alexa:all' => [
            'productID' => 'sortit_product_id',
            'productInstanceAttributes' => [
                'deviceSerialNumber' => '12345'
            ]
        ]
    ];

    /**
     * @inheritdoc
     */
    protected function defaultName()
    {
        return 'amazon';
    }

    /**
     * @inheritdoc
     */
    protected function defaultTitle()
    {
        return 'Amazon';
    }

    /**
     * @inheritdoc
     */
    public function buildAuthUrl(array $params = [])
    {
        $defaultParams = [
            'client_id' => $this->clientId,
            'response_type' => 'code',
            'redirect_uri' => $this->getReturnUrl(),
            'xoauth_displayname' => Yii::$app->name,
        ];
        if (!empty($this->scope)) {
            $defaultParams['scope'] = $this->scope;
        }
        if (!empty($this->scopeData)) {
            $scopeData['alexa:all']['productID'] = $this->productId;
            $scopeData['alexa:all']['productInstanceAttributes']['deviceSerialNumber'] = $this->deviceSerialNumber;
            $defaultParams['scope_data'] = Json::encode($this->scopeData);
        }

        if ($this->validateAuthState) {
            $authState = $this->generateAuthState();
            $this->setState('authState', $authState);
            $defaultParams['state'] = $authState;
        }

        return $this->composeUrl($this->authUrl, array_merge($defaultParams, $params));
    }

    /**
     * @inheritdoc
     */
    protected function defaultReturnUrl()
    {
        $params = Yii::$app->getRequest()->getQueryParams();
        unset($params['code']);
        unset($params['state']);
        unset($params['scope']);
        $params[0] = Yii::$app->controller->getRoute();

        return Yii::$app->getUrlManager()->createAbsoluteUrl($params);
    }

    /**
     * @inheritdoc
     */
    protected function defaultViewOptions() {
        return [
            'popupWidth' => 800,
            'popupHeight' => 600,
        ];
    }

    /**
     * @inheritdoc
     */
    protected function defaultNormalizeUserAttributeMap() {
        return [
            'provider' => function ($attributes) {
                return $this->defaultName();
            },
            'id' => 'user_id',
        ];
    }

    /**
     * UserInfo Normalize User Attribute Map
     *
     * @return array
     */
    protected function userInfoNormalizeUserAttributeMap() {
        return [
            'fullname' => 'name',
        ];
    }

    /**
     * Get user openid and other basic information.
     *
     * @return array
     */
    protected function initUserAttributes()
    {
//        return $this->api('/auth/O2/tokeninfo');
//        $this->scope = 'profile';
        return $this->api('/user/profile');
    }

    /**
     * Get extra user info.
     *
     * @return array
     */
    protected function initUserInfoAttributes()
    {
        return $this->api('/user/profile');
    }
}