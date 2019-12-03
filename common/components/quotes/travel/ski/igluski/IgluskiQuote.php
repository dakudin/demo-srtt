<?php
/**
 * Created by Kudin Dmitry
 * Date: 02.12.2019
 * Time: 14:58
 */

namespace common\components\quotes\travel\ski\igluski;

use Yii;
use common\components\quotes\travel\TravelQuoteBase;
use common\models\TravelQuote;

class IgluskiQuote extends TravelQuoteBase
{
    protected static $siteTitle = 'Igluski';

    /**
     * @var string Url which for getting and sending request
     */
    protected static $enquiryPageUrl = 'https://www.igluski.com/enquire';

    /**
     * @var int maximum count of adults (range 1-30)
     */
    protected $maxAdults = 30;

    /**
     * @var int maximum count of children (range 0-10)
     */
    protected $maxChildren = 10;

    /**
     * @var string pattern for required phone format
     */
    protected static $patternPhone = '#^\(?0( *\d\)?){9,10}$#s';


    /**
     * The associated array containing full form fields values
     */
    protected $formFields = [
        '__RequestVerificationToken' => '', //3IC0IoaVn_ED-llqkTKlGAbqd8yfWQAfGGsLPVEAq1xVwiWbAZoXvqXBZQitdffvSGryBN4eyTnSqDuvOu_GcrW0NPM1
        'HolidayId' => '',
        'InfinityTrackingId' => 'ad863ad0-1fd7-4178-854a-bed0c1a3c028', //ad863ad0-1fd7-4178-854a-bed0c1a3c028 - is generated by ict.infinity-tracking.net (I cannot emulate it)
        'EnquiryMailUUID' => '', //3e4ac255-9cc9-4278-a3e1-36da4a7bea96
        'Title' => '', // Mr
        'FirstName' => '', //John
        'LastName' => '', //Smith
        'Email' => '', //d2738005@urhen.com
        'PhoneNumber' => '', //0733948579
        'Adults' => '',
        'Children' => '',
        'AdditionalComments' => '', //	Need+a+ski+holiday+in+France
        'Newsletter' =>	'false',
        'IsAgreeToTandC' => 'false'
    ];

    /**
     * @param TravelQuote $quote
     * @param integer $companyId
     * @param boolean $sendRealQuote
     */
    public function __construct(TravelQuote $quote, $companyId, $sendRealQuote){
        $this->companyId = $companyId;
        $this->categoryId = $quote->category_id;
        $this->mainPageUrl = 'https://www.igluski.com/';
        $this->formSenderSDKPath = dirname(__FILE__);
        $this->debug=true;
        $this->sendRealQuote = $sendRealQuote;

        parent::__construct($quote);
    }

//URL: https://www.igluski.com/enquire
//Host: www.igluski.com
//User-Agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:70.0) Gecko/20100101 Firefox/70.0
//Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8
//Accept-Language: ru-RU,ru;q=0.8,en-US;q=0.5,en;q=0.3
//Accept-Encoding: gzip, deflate, br
//Referer: https://www.igluski.com/enquire
//Content-Type: application/x-www-form-urlencoded
//Content-Length: 434
//Origin: https://www.igluski.com
//Connection: keep-alive
//Cookie: __RequestVerificationToken=Xi-JdgZebMx26u-p3SP9Uhdo-ZHiBWmHsDsGD-NR-eX8gQySvT1XCj5BuqVtl16i70mn_DUVWukfJEmnrKrV3aj3Lus1; _gcl_au=1.1.1557715206.1575291755; _cs_c=1; _cs_id=01715c0a-35f1-af48-e1fb-91a82b8f8e8c.1575291757.1.1575291757.1575291757.1.1609455757161; _cs_s=1.1; _ga=GA1.2.1879165761.1575291757; _gid=GA1.2.305066770.1575291757; cto_lwid=20068c8b-8e69-49f5-99e0-71f674493070; ictf_master=vid~ad863ad0-1fd7-4178-854a-bed0c1a3c028; ictf_il1759=rlt~1575291763~land~2_11089_direct_7c308445e4172894002bfe0b1e1160e8; ictf_in1759=rlt~1575291763~land~2_11089_direct_7c308445e4172894002bfe0b1e1160e8; _hjid=c4a4561d-d496-47d1-a69a-500928ee499c; _fbp=fb.1.1575291758070.1460403250; _hjIncludedInSample=1; cto_bundle=YIH2W19vMWdjcXJGVG1tQUNielVGeERtemhZaFNmeGt4M2lycGhmdWJPeFpTaURtUTg3MGh6NzFXUzEzNkNFWE5yaE5tUndPeWNFRzFYdENhZWtjbHFNa3RpOUdhWVRFNFkyZWhhM3hjS3dRZ1ZTZ3NZcks2MGw4UHJqWXlFN1c0RVJWUw
//Upgrade-Insecure-Requests: 1
/*__RequestVerificationToken	3IC0IoaVn_ED-llqkTKlGAbqd8yfWQAfGGsLPVEAq1xVwiWbAZoXvqXBZQitdffvSGryBN4eyTnSqDuvOu_GcrW0NPM1
HolidayId
InfinityTrackingId	ad863ad0-1fd7-4178-854a-bed0c1a3c028
EnquiryMailUUID	3e4ac255-9cc9-4278-a3e1-36da4a7bea96
Title	Mr
FirstName	John
LastName	Smith
Email	d2738005@urhen.com
PhoneNumber	0733948579
Adults	2
Children	1
AdditionalComments	Need+a+ski+holiday+in+France
Newsletter	false
IsAgreeToTandC	false*/

    /**
     * Send fields for creating new enquiry
     * @return bool
     */
    public function sendForm()
    {
/*        $result = [
            'Response' => file_get_contents($this->formSenderSDKPath . '\home_page.html')
        ];*/

        //get form page
        $result = $this->pageGetter->sendRequest(static::$enquiryPageUrl, 'GET');

        if($result['Status'] == "FAIL"){
            self::log($result['StatusDetails'] . "\r\n" . $result['Response']);
            return false;
        }

        if(!$this->prepareHiddenFields($result['Response']))
            return false;

//var_dump($this->formFields); die;

        //send form to site
        $result = $this->pageGetter->sendRequest(static::$enquiryPageUrl, 'POST', $this->formFields, static::$enquiryPageUrl);

        if(!$this->isPageGood($result['Response'], '#Thank You For Your Enquiry#', 'Error Page: Didn`t find correct response'))
            return false;

        $this->resultPage = $result['Response'];

        return true;
    }

    /**
     * @param $page string
     * @return bool
     */
    protected function prepareHiddenFields($page)
    {
        $token = $this->parseElement('#<input\sname="__RequestVerificationToken"[^>]*?value="(.*?)"#s', $page, static::$siteTitle . ' page hidden field `__RequestVerificationToken`');
        if(!$token) return false;

        $mailKey = $this->parseElement('#<input[^>]*?name="EnquiryMailUUID"[^>]*?value="(.*?)"#s', $page, static::$siteTitle . ' page hidden field `EnquiryMailUUID`');
        if(!$mailKey) return false;

        $this->formFields['__RequestVerificationToken'] = $token;
        $this->formFields['EnquiryMailUUID'] = $mailKey;

        return true;
    }

    protected function fillPassengersCount(){
        $roomInfo = $this->quote->getAdultsChildAgesInfo();

        if($roomInfo['adultsCount'] > 0 && $roomInfo['adultsCount'] <= $this->maxAdults)
            $this->formFields['Adults'] = $roomInfo['adultsCount'];

        if($roomInfo['childrenCount'] >= 0 && $roomInfo['childrenCount'] <= $this->maxChildren)
            $this->formFields['Children'] = $roomInfo['childrenCount'];
    }

    protected function fillPhone($phone)
    {
        $phone = str_replace('+ ()', '', $phone);

        if (preg_match(static::$patternPhone, $phone, $matches) === 1){
            $this->formFields['PhoneNumber'] = $phone;
        }
    }

    /**
     * @return bool
     */
    protected function fillData()
    {
        $this->fillPassengersCount();
        $this->fillPhone($this->quote->phone);

        $this->formFields['Title'] = $this->quote->user_title;
        $this->formFields['FirstName'] = $this->quote->user_first_name;
        $this->formFields['LastName'] = $this->quote->user_last_name;
        $this->formFields['Email'] = $this->quote->email;

        // details
        $this->formFields['AdditionalComments'] = implode(
            "\r\n",
            $this->quote->getQuoteInfoByFields([
                TravelQuote::COUNTRY_TEXT_FIELD,
                TravelQuote::CITY_TEXT_FIELD,
                TravelQuote::AIRPORT_TEXT_FIELD,
                TravelQuote::FLIGHT_CATEGORY_TEXT_FIELD,
                TravelQuote::DEPARTURE_DATE_TEXT_FILED,
                TravelQuote::DURATION_TEXT_FIELD ,
                TravelQuote::TOTAL_BUDGET_TEXT_FIELD,
                TravelQuote::ROOMS_TEXT_FIELD,
                TravelQuote::DETAIL_TEXT_FIELD,
            ])
        );

        return $this->isFormFilledGood();
    }

    protected function isFormFilledGood()
    {
        if(empty($this->formFields['Title']) || empty($this->formFields['FirstName']) || empty($this->formFields['LastName'])){
            Yii::warning("Couldn't use " . static::$siteTitle . " due to user name is wrong");
            return false;
        }

        if(empty($this->formFields['Email'])){
            Yii::warning("Couldn't use " . static::$siteTitle . " due to email is wrong ({$this->quote->email})");
            return false;
        }

        if(empty($this->formFields['PhoneNumber'])){
            Yii::warning("Couldn't use " . static::$siteTitle . " due to phone is wrong ({$this->quote->phone})");
            return false;
        }

        if(empty($this->formFields['Adults']) || is_string($this->formFields['Children'])){
            Yii::warning("Couldn't use " . static::$siteTitle . " due to adults count or children count is wrong");
            return false;
        }

        return true;
    }
}