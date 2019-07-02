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

//https://www.flightcentre.co.uk/holidays/australia
//valid UK phone number 00441234123456
class FCentreTravelQuote extends TravelQuoteBase
{
    protected $formUrl = 'https://data.fclmedia.com/sendEnquiry';

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
        'pageUrl' => 'https://www.flightcentre.co.uk/holidays/australia',
        'country' => 'UK',
        'validationTemplate' => 'uk/fc/basicHoneypotValidate.ftl',
        'failUrl' => '/contact-us/failure',
        'forwardUrl' => '/contact-us/success',
        'productEnquire' => 'no',
        'js' => 'true',

        'departName' => '', // airport - get from dict (London Heathrow, London Gatwick, Aberdeen, Belfast, Birmingham, Bournemouth, Dublin, Edinburgh, Glasgow, Leeds, Manchester, Newcastle)
        'destName' => '', // destination - get from `destination_value` field of `quote_company_destination` table
        'departDate' => '', // departure date '12/07/2019'
        'returnDate' => '', // return date '18/07/2019'
        'flight_class' => '', // flight class (economy/premium/business/first
        'numTravel' => '', // adults plus children count (1,2,3,4,5,6,7,8,9,10+)
        'quoteText' => '', // quote text
        'cus_title' => '', // user title
        'firstName' => '',  //user first name
        'surname' => '', // user last name
        'phone' => '', // contact phone '00441234123456'
        'email' => '', // user email
        'todaysDate' => '', // current date '28/06/2019'
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
    protected function getNumberPassengers()
    {

    }

    /**
     * @param int $adultsCount
     */
    protected function fillPassengersCount($adultsCount){
        if($adultsCount > $this->maxAdults)
            $this->formFields['selAdults'] = (string)$this->maxAdults . '+';
        else
            $this->formFields['selAdults'] = $adultsCount;
    }

    /**
     * @inheritdoc
     */
    protected function fillData()
    {
        $roomInfo = $this->quote->getAdultsChildAgesInfo();

        if($roomInfo['childrenCount'] > $this->maxChildren){
            Yii::info("Couldn't use eShores.co.uk due to count of children more then " . $this->maxChildren);
            return false;
        }

        $this->fillAdultsCount($roomInfo['adultsCount']);

        $this->fillChildrenInfo($roomInfo['childrenCount'], $roomInfo['childAges']);

        $this->formFields['inpFirstName'] = $this->quote->user_first_name;
        $this->formFields['inpSurname'] = $this->quote->user_last_name;
        $this->formFields['inpPhone'] = $this->quote->phone;
        $this->formFields['inpEmail'] = $this->quote->email;

        if(empty($this->quote->date)) {
            Yii::info("Couldn't use eShores.co.uk due to didn't set preferred date of traveling");
            return false;
        }

        $date = \DateTime::createFromFormat('Y-m-d', $this->quote->date);
        if($date !== false) {
            $this->formFields['datepicker'][0] = $date->format('d');
            $this->formFields['datepicker'][1] = $date->format('m');
            $this->formFields['datepicker'][2] = $date->format('Y');
        }else{
            return false;
        }

        $this->formFields['txtEnquiry'][1] = implode(
            "\r\n",
            $this->quote->getQuoteInfoByFields([
                TravelQuote::COUNTRY_TEXT_FIELD,
                TravelQuote::CITY_TEXT_FIELD,
                TravelQuote::AIRPORT_TEXT_FIELD,
                TravelQuote::FLIGHT_CATEGORY_TEXT_FIELD,
                TravelQuote::DURATION_TEXT_FIELD ,
                TravelQuote::TOTAL_BUDGET_TEXT_FIELD,
                TravelQuote::DETAIL_TEXT_FIELD,
            ])
        );

        return true;
    }

}