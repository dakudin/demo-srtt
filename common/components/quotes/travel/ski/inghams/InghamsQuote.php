<?php
/**
 * Created by Kudin Dmitry
 * Date: 27.11.2019
 * Time: 15:44
 */

namespace common\components\quotes\travel\ski\inghams;

use Yii;
use common\components\quotes\travel\TravelQuoteBase;
use common\models\TravelQuote;
use common\models\DictAirport;
use common\components\Helper;

class InghamsQuote extends TravelQuoteBase
{
    /**
     * @var string Url which request form into iframe (main page)
     */
    protected static $enquiryPageUrl = 'https://www.inghams.co.uk/stay-in-touch/contact-us';

    /**
     * @var string Url which contains form
     */
    protected static $enquiryFormPageUrl = 'https://hotelplan.formstack.com/forms/inghams_customer_contact_form';

    /**
     * @var string Url for creating enquiry
     */
    protected static $formRequestUrl = 'https://hotelplan.formstack.com/forms/index.php';

    /**
     * @var int maximum count of adults (range 1-20)
     */
    protected $maxAdults = 20;

    /**
     * @var int maximum count of children (range 0-8)
     */
    protected $maxChildren = 9;


    /**
     * The associated array containing full form fields values
     */
    protected $formFields = [

        "form" => '', //"3239436",
        "viewkey" => '', //"uaG6i1kLRp",
        "password" => '',
        "hidden_fields" => '',
        "incomplete" => '',
        "incomplete_email" => '',
        "incomplete_password" => '',
        "referrer" => 'https://www.inghams.co.uk/stay-in-touch/contact-us',
        "referrer_type" => 'link',
        "_submit" => '1',
        "style_version" => '3',
        "latitude" => '',
        "longitude" => '',
        "viewparam" => '', //"464374",
        "field70405566" => 'New bookings & enquiries', // Which of our holidays are you interested in
        "field70405567-prefix" => '', //Prefix - Mr
        "field70405567-first" => '', //First name - John
        "field70405567-last" => '', //Last name - Brown
        "field70405570" => '', // phone 07911 163256
        "field70405577" => '', // email d1747417@urhen.com
        "field71459126" => '', // Number of Adults
        "field71459140" => '', // Number of Children (under 13)
        "field71459147" => '', // Airport
        "field70406056" => '',
        "field70406049" => '',
        "field70406059Format" => 'DMY',
        "field70406059D" => '', // Day (18)
        "field70406059M" => '', // Month (January)
        "field70406059Y" => '', // Year(2020)
        "field70408318" => '', // Message
        "field82438919[]" => 'Ski and Snowboard', //Which of our holidays are you interested in
        "nonce" => '', //"AX9fErWOSf9Woq6V"
    ];

    /**
     * @param TravelQuote $quote
     * @param integer $companyId
     * @param boolean $sendRealQuote
     */
    public function __construct(TravelQuote $quote, $companyId, $sendRealQuote){
        $this->companyId = $companyId;
        $this->categoryId = $quote->category_id;
        $this->mainPageUrl = 'https://www.inghams.co.uk/';
        $this->formSenderSDKPath = dirname(__FILE__);
        $this->debug=true;
        $this->sendRealQuote = $sendRealQuote;

        parent::__construct($quote);
    }

//Host: hotelplan.formstack.com
//User-Agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:70.0) Gecko/20100101 Firefox/70.0
//Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8
//Accept-Language: ru-RU,ru;q=0.8,en-US;q=0.5,en;q=0.3
//Accept-Encoding: gzip, deflate, br
//Content-Type: application/x-www-form-urlencoded
//Content-Length: 697
//Origin: https://hotelplan.formstack.com
//Connection: keep-alive
//Referer: https://hotelplan.formstack.com/forms/inghams_customer_contact_form
//Cookie: PHPSESSID=0add8d1c1aab8d116fbab820b1745bf2
//Upgrade-Insecure-Requests: 1

/*
{
"form":"3239436",
"viewkey":"uaG6i1kLRp",
"password":"",
"hidden_fields":"",
"incomplete":"",
"incomplete_email":"",
"incomplete_password":"",
"referrer":"https://www.inghams.co.uk/stay-in-touch/contact-us",
"referrer_type":"link",
"_submit":"1",
"style_version":"3",
"latitude":"",
"longitude":"",
"viewparam":"464374",
"field70405566":"New+bookings+&+enquiries",
"field70405567-prefix":"Mr",
"field70405567-first":"John",
"field70405567-last":"Brown",
"field70405570":"07911+163256",
"field70405577":"d1747417@urhen.com",
"field71459126":"1",
"field71459140":"0",
"field71459147":"Birmingham",
"field70406056":"",
"field70406049":"",
"field70406059Format":"DMY",
"field70406059D":"18",
"field70406059M":"January",
"field70406059Y":"2020",
"field70408318":"Hakuba+Japan",
"field82438919[]":"Ski+and+Snowboard",
"nonce":"AX9fErWOSf9Woq6V"}*/

    /**
     * Send fields for creating new enquiry
     * @return bool
     */
    public function sendForm()
    {
/*        $result = [
            'Response' => file_get_contents($this->formSenderSDKPath . '\form-page-html.txt')
        ];*/

        //get form page
        $result = $this->pageGetter->sendRequest(static::$enquiryFormPageUrl, 'GET', '', static::$enquiryPageUrl);

        if($result['Status'] == "FAIL"){
            self::log($result['StatusDetails'] . "\r\n" . $result['Response']);
            return false;
        }

        if(!$this->prepareHiddenFields($result['Response']))
            return false;

        //send form to site
        $result = $this->pageGetter->sendRequest(static::$formRequestUrl, 'POST', $this->formFields, static::$enquiryFormPageUrl);

        if(!$this->isPageGood($result['Response'], '#The form was submitted successfully#', 'Error Page: Didn`t find correct response'))
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
        $form = $this->parseElement('#<input\stype="hidden"\sname="form"\svalue="(.*?)"#s', $page, 'Inghams form page hidden field `form`');
        if(!$form) return false;

        $viewKey = $this->parseElement('#<input\stype="hidden"\sname="viewkey"\svalue="(.*?)"#s', $page, 'Inghams form page hidden field `viewkey`');
        if(!$viewKey) return false;

        $viewParam = $this->parseElement('#<input\stype="hidden"\sid="viewparam"\sname="viewparam"\svalue="(.*?)"#s', $page, 'Inghams form page hidden field `viewparam`');
        if(!$viewParam) return false;

        $this->formFields['form'] = $form;
        $this->formFields['viewkey'] = $viewKey;
        $this->formFields['viewparam'] = $viewParam;

        return true;
    }

    protected function fillPassengersCount(){
        $roomInfo = $this->quote->getAdultsChildAgesInfo();

        if($roomInfo['adultsCount'] > 0 && $roomInfo['adultsCount'] <= $this->maxAdults)
            $this->formFields['field71459126'] = $roomInfo['adultsCount'];

        if($roomInfo['childrenCount'] >= 0 && $roomInfo['childrenCount'] <= $this->maxChildren)
            $this->formFields['field71459140'] = $roomInfo['childrenCount'];
    }

    protected function fillDate()
    {
        if(empty($this->quote->date)) {
            return;
        }

        $date = \DateTime::createFromFormat('Y-m-d', $this->quote->date);
        if($date !== false) {
            $this->formFields['field70406059D'] = $date->format('d'); // Day (18)
            $this->formFields['field70406059M'] = $date->format('F'); // Month (January)
            $this->formFields['field70406059Y'] = $date->format('Y'); // Year(2020)
        }
    }

    protected function fillAirport()
    {
        $airport = DictAirport::getInghamsValueByName($this->quote->airport);
        if(!empty($airport))
            $this->formFields['field71459147'] = $airport;
    }

    protected function fillPhone($phone)
    {
        $isValid = false;
        $phone = str_replace(' ()', '', $phone);

        // Validate UK landline numbers.
        if (preg_match('/^(01)\d{8}$/', $phone, $matches) === 1){
            $isValid = true;
        }
        if (preg_match('/^(01|02|03|05|08|09)\d{9}$/', $phone, $matches) === 1){
            $isValid = true;
        }
        if (preg_match('/^(0500|0800)\d{6}$/', $phone, $matches) === 1){
            $isValid = true;
        }

        // Validate mobile numbers.
        if (preg_match('/^(?:(?:(?:00\s?|\+)44\s?|0)[1235789](?:[45789]\d{2}|624)\s?\d{3}\s?\d{3})$/', $phone, $matches) === 1){
            $isValid = true;
        }

        if (preg_match('/^(07624)\d{6}$/', $phone, $matches) === 1){
            $isValid = true;
        }

        if($isValid){
            $this->formFields['field70405570'] = $phone;
        }
    }

    /**
     * @return bool
     */
    protected function fillData()
    {
        //generate `nonce` field like in https://static.formstack.com/forms/js/3/scripts_3318d58a68.js
        //from form https://hotelplan.formstack.com/forms/inghams_customer_contact_form
        $this->formFields['nonce'] = Helper::generateRandomString(16);

        $this->fillPassengersCount();
        $this->fillDate();
        $this->fillAirport();
        $this->fillPhone($this->quote->phone);

        $this->formFields['field70405567-prefix'] = $this->quote->user_title;
        $this->formFields['field70405567-first'] = $this->quote->user_first_name;
        $this->formFields['field70405567-last'] = $this->quote->user_last_name;
        $this->formFields['field70405577'] = $this->quote->email;

        // details
        $this->formFields['field70408318'] = implode(
            "\r\n",
            $this->quote->getQuoteInfoByFields([
                TravelQuote::COUNTRY_TEXT_FIELD,
                TravelQuote::CITY_TEXT_FIELD,
                TravelQuote::FLIGHT_CATEGORY_TEXT_FIELD,
                TravelQuote::DURATION_TEXT_FIELD ,
                TravelQuote::TOTAL_BUDGET_TEXT_FIELD,
                TravelQuote::DETAIL_TEXT_FIELD,
                TravelQuote::USER_BEST_TIME2CONTACT,
            ])
        );

        return $this->isFormFilledGood();
    }



    protected function isFormFilledGood()
    {
        if(empty($this->formFields['field70405567-prefix']) || empty($this->formFields['field70405567-first']) || empty($this->formFields['field70405567-last'])){
            Yii::warning("Couldn't use Inghams due to user name is wrong");
            return false;
        }

        if(empty($this->formFields['field70405577'])){
            Yii::warning("Couldn't use Inghams due to email is wrong ({$this->quote->email})");
            return false;
        }

        if(empty($this->formFields['field71459126']) || is_string($this->formFields['field71459140'])){
            Yii::warning("Couldn't use Inghams due to adults count or children count is wrong");
            return false;
        }

        return true;
    }
}