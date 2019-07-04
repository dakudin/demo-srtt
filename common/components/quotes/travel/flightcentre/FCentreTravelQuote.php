<?php

/**
 * Created by Kudin Dmitry.
 * Date: 27.06.2019
 * Time: 10:43
 */

namespace common\components\quotes\travel\flightcentre;

use Yii;
use common\components\quotes\travel\TravelQuoteBase;
use common\models\TravelQuote;
use common\models\DictAirport;
use common\models\QuoteCompanyDestination;

class FCentreTravelQuote extends TravelQuoteBase
{
    const FLIGHT_ECONOMY = 'economy';
    const FLIGHT_PREMIUM = 'premium';
    const FLIGHT_BUSINESS = 'business';
    const FLIGHT_FIRST = 'first';

    protected static $formRequestUrl = 'https://data.fclmedia.com/sendEnquiry';

    protected static $enquiryPageUrls = [
        'https://www.flightcentre.co.uk/holidays/north-america/canada',
        'https://www.flightcentre.co.uk/holidays/europe',
        'https://www.flightcentre.co.uk/holidays/australia',
        'https://www.flightcentre.co.uk/holidays/africa'
    ];

    /**
     * @var int maximum count of passengers, if more than add + to it
     */
    protected $maxPassengers = 10;

    /**
     * The associated array containing full form fields values
     */
    protected $formFields = [
        'hnpt' => 'TRAVEL',
        'keyword' => 'ukfc.priority',
        'eCommerceProdName' => 'holidays',
        'form_id' => 'holidays-enquiry-general-image',
        'destinationCountry' => '',
        'utm_source' => '(direct)',
        'utm_medium' => '(none)',
        'utm_campaign' => '(direct)',
        'routing_code' => 'ukfc.fbcquote',
        'bounceBackEmailTemplate' => 'uk/fc/bb-message-enquiry.ftl',
        'consultantEmailTemplate' => 'uk/fc/ct-message-enquiry.ftl',
        'enquiryCategory' => 'Holiday Package - General',
        'brand' => 'FCUK',
        'country' => 'UK',
        'validationTemplate' => 'uk/fc/basicHoneypotValidate.ftl',
        'failUrl' => 'https://www.flightcentre.co.uk/contact-us/failure',
        'forwardUrl' => 'https://www.flightcentre.co.uk/contact-us/success',
        'productEnquire' => 'no',
        'js' => 'true',

        'departName' => '', // airport - get from dict (London Heathrow, London Gatwick, Aberdeen, Belfast, Birmingham, Bournemouth, Dublin, Edinburgh, Glasgow, Leeds, Manchester, Newcastle)
        'destName' => '', // destination - get from `destination_value` field of `quote_company_destination` table
        'departDate' => '', // departure date '12/07/2019'
        'returnDate' => '', // return date '18/07/2019'
        'flight_class' => '', // flight class (economy/premium/business/first)
        'numTravel' => '', // adults plus children count (1,2,3,4,5,6,7,8,9,10+)
        'quoteText' => '', // quote text
        'cus_title' => '', // user title
        'firstName' => '',  //user first name
        'surname' => '', // user last name
        'phone' => '', // contact phone '00447434123456'
        'email' => '', // user email
        'todaysDate' => '', // current date '28/06/2019'
        'pageUrl' => '', //'https://www.flightcentre.co.uk/holidays/australia',
    ];

    /**
     * @param TravelQuote $quote
     * @param integer $companyId
     * @param boolean $sendRealQuote
     */
    public function __construct(TravelQuote $quote, $companyId, $sendRealQuote){
        $this->companyId = $companyId;
        $this->categoryId = $quote->category_id;
        $this->mainPageUrl = 'https://www.flightcentre.co.uk/';
        $this->formSenderSDKPath = dirname(__FILE__);
        $this->debug=true;
        $this->sendRealQuote = $sendRealQuote;

        parent::__construct($quote);
    }

    /**
     * Send fields for creating new enquiry to page for different countries randomly
     * @param $params array
     * @return bool
     */
    public function sendForm()
    {
        //send form to site
        $result = $this->pageGetter->sendRequest(static::$formRequestUrl, 'GET', $this->formFields, $this->getSendEnquiryPageUrl());

        if($result['Status'] == "FAIL"){
            self::log($result['StatusDetails'] . "\r\n" . $result['Response']);
            return false;
        }

        if(!$this->isPageGood($result['Response'], '#Thank you for your travel quote request#', 'Error Page: Didn`t find correct response'))
            return false;

        $this->resultPage = $result['Response'];

        return true;
    }

    //https://data.fclmedia.com/sendEnquiry?hnpt=TRAVEL&keyword=ukfc.priority&eCommerceProdName=holidays&form_id=holidays-enquiry-general-image&destinationCountry=&utm_source=(direct)&utm_medium=(none)&utm_campaign=(direct)&routing_code=ukfc.fbcquote&departName=London+Gatwick&destName=Spain%2CEurope&departDate=12%2F07%2F2019&returnDate=18%2F07%2F2019&flight_class=first&numTravel=2&quoteText=coast&cus_title=Mr&firstName=John&surname=Brown&phone=00441234123456&email=b2366946%40urhen.com&bounceBackEmailTemplate=uk%2Ffc%2Fbb-message-enquiry.ftl&todaysDate=28%2F06%2F2019&consultantEmailTemplate=uk%2Ffc%2Fct-message-enquiry.ftl&enquiryCategory=Holiday+Package+-+General&brand=FCUK&pageUrl=https%3A%2F%2Fwww.flightcentre.co.uk%2Fholidays%2Faustralia&country=UK&validationTemplate=uk%2Ffc%2FbasicHoneypotValidate.ftl&failUrl=%2Fcontact-us%2Ffailure&forwardUrl=%2Fcontact-us%2Fsuccess&productEnquire=no&js=true

    // HEADERS
//Accept: application/json, text/javascript, */*; q=0.01
//Origin: https://www.flightcentre.co.uk
//Referer: https://www.flightcentre.co.uk/holidays/australia
//User-Agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.100 Safari/537.36


/*
hnpt: TRAVEL
keyword: ukfc.priority
eCommerceProdName: holidays
form_id: holidays-enquiry-general-image
destinationCountry:
utm_source: (direct)
utm_medium: (none)
utm_campaign: (direct)
routing_code: ukfc.fbcquote
departName: London Gatwick
destName: Spain,Europe
departDate: 12/07/2019
returnDate: 18/07/2019
flight_class: first
numTravel: 2
quoteText: coast
cus_title: Mr
firstName: John
surname: Brown
phone: 00441234123456
email: b2366946@urhen.com
bounceBackEmailTemplate: uk/fc/bb-message-enquiry.ftl
todaysDate: 28/06/2019
consultantEmailTemplate: uk/fc/ct-message-enquiry.ftl
enquiryCategory: Holiday Package - General
brand: FCUK
pageUrl: https://www.flightcentre.co.uk/holidays/australia
country: UK
validationTemplate: uk/fc/basicHoneypotValidate.ftl
failUrl: /contact-us/failure
forwardUrl: /contact-us/success
productEnquire: no
js: true*/

//SUCCESSFUL RESULT CONTAIN
//<h3>Thank you for your travel quote request</h3>

    /**
     */
    protected function fillPassengersCount(){
        $roomInfo = $this->quote->getAdultsChildAgesInfo();
        $passengers = $roomInfo['adultsCount'] + $roomInfo['childrenCount'];

        if($passengers >= $this->maxPassengers)
            $this->formFields['numTravel'] = (string)$this->maxPassengers . '+';
        elseif($passengers != 0)
            $this->formFields['numTravel'] = $passengers;
    }

    // flight class (economy/premium/business/first)
    protected function fillFlightCategory()
    {
        switch($this->quote->flight_category){
            case TravelQuote::FLIGHT_BUSINESS :
                $this->formFields['flight_class'] = static::FLIGHT_BUSINESS;
                break;
            case TravelQuote::FLIGHT_PREMIUM :
                $this->formFields['flight_class'] = static::FLIGHT_PREMIUM;
                break;
            case TravelQuote::FLIGHT_ECONOMY :
                $this->formFields['flight_class'] = static::FLIGHT_ECONOMY;
                break;
        }
    }

    protected function fillDate()
    {
        if(empty($this->quote->date)) {
            return;
        }

        $date = \DateTime::createFromFormat('Y-m-d', $this->quote->date);
        if($date !== false) {
            $this->formFields['departDate'] = $date->format('d/m/Y');
            $this->formFields['returnDate'] = $date->add(new \DateInterval('P' . $this->quote->duration . 'D'))->format('d/m/Y');
            $date = new \DateTime();
            $this->formFields['todaysDate'] = $date->format('d/m/Y');
        }
    }

    protected function fillAirport()
    {
        $airport = DictAirport::getFlightCentreValueByName($this->quote->airport);
        if(!empty($airport))
            $this->formFields['departName'] = $airport;
    }

    protected function fillDestination()
    {
        $destination = QuoteCompanyDestination::getDestinationValue(
            $this->companyId, $this->quote->city, $this->quote->city, $this->quote->country);

        if($destination){
            $this->formFields['destName'] = $destination;
        }
    }

    // Validate UK phone number
    //var isValidUKPhoneNumber = function(number) {
    //    // Set a default value.
    //    var isValid = false;
    //
    //    // Validate UK landline numbers.
    //    if (/^(01)\d{8}$/g.test(number)) {
    //        isValid = true;
    //    }
    //    if (/^(01|02|03|05|08|09)\d{9}$/g.test(number)) {
    //        isValid = true;
    //    }
    //    if (/^(0500|0800)\d{6}$/g.test(number)) {
    //        isValid = true;
    //    }
    //
    //    // Validate mobile numbers.
    //    if (/^(?:(?:(?:00\s?|\+)44\s?|0)7(?:[45789]\d{2}|624)\s?\d{3}\s?\d{3})$/g.test(number)) {
    //        isValid = true;
    //    }
    //    if (/^(07624)\d{6}$/g.test(number)) {
    //        isValid = true;
    //    }
    //
    //    return isValid;
    //  }
    protected function fillPhone($phone)
    {
        $isValid = false;

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
        if (preg_match('/^(?:(?:(?:00\s?|\+)44\s?|0)7(?:[45789]\d{2}|624)\s?\d{3}\s?\d{3})$/', $phone, $matches) === 1){
            $isValid = true;
        }

        if (preg_match('/^(07624)\d{6}$/', $phone, $matches) === 1){
            $isValid = true;
        }

        if($isValid){
            $this->formFields['phone'] = $phone;
        }
    }

    /**
     * @inheritdoc
     */
    protected function fillData()
    {
        $this->fillPassengersCount();
        $this->fillFlightCategory();
        $this->fillDate();
        $this->fillAirport();
        $this->fillDestination();
        $this->fillPhone($this->quote->phone);
        $this->formFields['cus_title'] = $this->quote->user_title;
        $this->formFields['firstName'] = $this->quote->user_first_name;
        $this->formFields['surname'] = $this->quote->user_last_name;
        $this->formFields['email'] = $this->quote->email;
        $this->formFields['pageUrl'] = static::$enquiryPageUrls[rand(0, count(static::$enquiryPageUrls)-1)];

        $this->formFields['quoteText'] = implode(
            "\r\n",
            $this->quote->getQuoteInfoByFields([
                TravelQuote::TOTAL_BUDGET_TEXT_FIELD,
                TravelQuote::DETAIL_TEXT_FIELD,
            ])
        );

        return $this->isFormFilledGood();
    }

    protected function getSendEnquiryPageUrl(){
        return $this->formFields['pageUrl'];
    }

    protected function isFormFilledGood()
    {
        if(empty($this->formFields['departName'])){
            Yii::warning("Couldn't use FlightCentre due to airport is wrong ({$this->quote->airport})");
            return false;
        }

        if(empty($this->formFields['destName'])){
            Yii::warning("Couldn't use FlightCentre due to destination is wrong (didn't find destination by city:{$this->quote->city}; country: {$this->quote->country})");
            return false;
        }

        if(empty($this->formFields['departDate']) || empty($this->formFields['returnDate']) || empty($this->formFields['todaysDate'])){
            Yii::warning("Couldn't use FlightCentre due to departing date or returning date is wrong (date: {$this->quote->date}), duration: {$this->quote->duration})");
            return false;
        }

        if(empty($this->formFields['flight_class'])){
            Yii::warning("Couldn't use FlightCentre due to flight class is wrong ({$this->quote->flight_category})");
            return false;
        }

        if(empty($this->formFields['numTravel'])){
            Yii::warning("Couldn't use FlightCentre due to passenges count is wrong");
            return false;
        }

        if(empty($this->formFields['cus_title']) || empty($this->formFields['firstName']) || empty($this->formFields['surname'])){
            Yii::warning("Couldn't use FlightCentre due to user name is wrong");
            return false;
        }

        if(empty($this->formFields['phone'])){
            Yii::warning("Couldn't use FlightCentre due to phone is wrong ({$this->quote->phone})");
            return false;
        }

        if(empty($this->formFields['email'])){
            Yii::warning("Couldn't use FlightCentre due to email is wrong ({$this->quote->email})");
            return false;
        }

        return true;
    }
}