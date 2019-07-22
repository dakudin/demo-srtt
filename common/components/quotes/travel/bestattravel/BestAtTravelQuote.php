<?php

/**
 * Created by Kudin Dmitry.
 * Date: 28.06.2019
 * Time: 18:30
 */

namespace common\components\quotes\travel\bestattravel;

use Yii;
use common\components\quotes\travel\TravelQuoteBase;
use common\models\TravelQuote;
use common\models\DictAirport;
use common\models\QuoteCompanyDestination;

class BestAtTravelQuote extends TravelQuoteBase
{
    const FLIGHT_ECONOMY = 'Economy';
    const FLIGHT_PREMIUM = 'Premium Economy';
    const FLIGHT_BUSINESS_OR_FIRST = 'Business / First';

    /**
     * @var int maximum count of adults (range 1-9)
     */
    protected $maxAdults = 9;

    /**
     * @var int maximum count of children (range 0-9)
     */
    protected $maxChildren = 9;

    protected static $formRequestUrl = 'https://www.bestattravel.co.uk/common/OnlineEnquiry';

    protected static $enquiryPageUrl = 'https://www.bestattravel.co.uk/contact-us';

    /**
     * The associated array containing full form fields values
     */
    protected $formFields = [
        'Title' => '', //Mr
        'FirstName' => '', //Tom
        'LastName' => '', //Smith
        'EmailAddress' => '', //b4369952@urhen.com
        'TelephoneNumber' => '', //487387399424
        'HolidayType' => '1', //1
        'Destination' => '', //AGP
        'Departure' => '', //BHX
        'DepartureDate' => '', //21/07/2019
        'ReturnDate' => '', //27/07/2019
        'Comments' => '', //sea+view
        'NewsLetter' => 'false', //false
        'Room1' => '',
        'Room2' => '',
        'Room3' => '',
        'NoAdults' => '', //2
        'NoChildren' => '', //1
        'NoInfants' => '0', //0
        'PassengerText' => '',
        'HotelBoardBasis' => 'Select', //Select
        'HotelID' => '',
        'HotelName' => '',
        'HotelTransfer' => '',
        'NoAdultsRoom1' => '0',
        'NoChildrenRoom1' => '0',
        'NoInfantsRoom1' => '0',
        'NoAdultsRoom2' => '0',
        'NoChildrenRoom2' => '0',
        'NoInfantsRoom2' => '0',
        'NoAdultsRoom3' => '0',
        'NoChildrenRoom3' => '0',
        'NoInfantsRoom3' => '0',
        'AgesRoom1' => '',
        'AgesRoom2' => '',
        'AgesRoom3' => '',
        'HolidayTypeName' => 'Flights & Hotels',
        'ProductName' => '', //Andalucia (AGP), Spain, Europe
        'McComments' => '', //+|+Flexibility:+Exact+dates+only+|+Best+time+to+contact:+after+7+p.m.+|+Travelled+before:+No
        'FlightClass' => '', // Economy
     ];

    /**
     * @param TravelQuote $quote
     * @param integer $companyId
     * @param boolean $sendRealQuote
     */
    public function __construct(TravelQuote $quote, $companyId, $sendRealQuote){
        $this->companyId = $companyId;
        $this->categoryId = $quote->category_id;
        $this->mainPageUrl = 'https://www.bestattravel.co.uk/';
        $this->formSenderSDKPath = dirname(__FILE__);
        $this->debug=true;
        $this->sendRealQuote = $sendRealQuote;

        parent::__construct($quote);
    }


//URL запроса:https://www.bestattravel.co.uk/common/OnlineEnquiry
//Метод запроса:POST
//
//Host: www.bestattravel.co.uk
//User-Agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:68.0) Gecko/20100101 Firefox/68.0
//Accept: text/html, */*; q=0.01
//Accept-Language: ru-RU,ru;q=0.8,en-US;q=0.5,en;q=0.3
//Accept-Encoding: gzip, deflate, br
//Referer: https://www.bestattravel.co.uk/contact-us
//Content-Type: application/x-www-form-urlencoded; charset=UTF-8
//X-Requested-With: XMLHttpRequest
//Content-Length: 768
//Connection: keep-alive
//Cookie: __cfduid=d83cd117216bf47842c59db6fcba4e9081561496674; __adal_id=b26b15f2-f27b-4e7e-ba73-5e21c7a43d99.1561496675.5.1563204644.1562963051.13165029-716a-4bf1-948f-0e0b5bfe2cdd; __adal_ca=so%3Ddirect%26me%3Dnone%26ca%3Ddirect%26co%3D%28not%2520set%29%26ke%3D%28not%2520set%29; __adal_cw=1561496674858; scarab.visitor=%226A3E497F80A5AE96%22; _ga=GA1.3.928214252.1561496676; ictf_master=vid~413c1c5f-b931-4efa-bdd8-56d34432bb9c; ictf_il928=rlt~1563204646~land~2_6115_direct_87457e7f6dd7e2cd8d6db09457cbcae2; ictf_in928=rlt~1563204646~land~2_6115_direct_87457e7f6dd7e2cd8d6db09457cbcae2; _fbp=fb.2.1561496677973.2072222756; BIGipServerPOOL-146.177.0.149-80=2472847552.20480.0000; _gid=GA1.3.1114335981.1563204646
//TE: Trailers
//
//Title	Mr
//FirstName	Tom
//LastName	Smith
//EmailAddress	b4369952@urhen.com
//TelephoneNumber	487387399424
//HolidayType	1
//Destination	AGP
//Departure	BHX
//DepartureDate	21/07/2019
//ReturnDate	27/07/2019
//Comments	sea+view
//NewsLetter	false
//Room1
//Room2
//Room3
//NoAdults	2
//NoChildren	1
//NoInfants	0
//PassengerText
//HotelBoardBasis	Select
//HotelID
//HotelName
//HotelTransfer
//NoAdultsRoom1	0
//NoChildrenRoom1	0
//NoInfantsRoom1	0
//NoAdultsRoom2	0
//NoChildrenRoom2	0
//NoInfantsRoom2	0
//NoAdultsRoom3	0
//NoChildrenRoom3	0
//NoInfantsRoom3	0
//AgesRoom1
//AgesRoom2
//AgesRoom3
//HolidayTypeName	Flights+&+Hotels
//ProductName	Andalucia+(AGP),+Spain,+Europe
//McComments	+|+Flexibility:+Exact+dates+only+|+Best+time+to+contact:+after+7+p.m.+|+Travelled+before:+No
//FlightClass	Economy

/*
Title=DR&FirstName=John&LastName=Brown&EmailAddress=b4972286%40urhen.com&TelephoneNumber=020345234435&HolidayType=1&Destination=YYC&Departure=LHR&DepartureDate=23%2F07%2F2019&ReturnDate=27%2F07%2F2019&Comments=&NewsLetter=false&Room1=&Room2=&Room3=&NoAdults=2&NoChildren=1&NoInfants=0&PassengerText=&HotelBoardBasis=Select&HotelID=&HotelName=&HotelTransfer=&NoAdultsRoom1=0&NoChildrenRoom1=0&NoInfantsRoom1=0&NoAdultsRoom2=0&NoChildrenRoom2=0&NoInfantsRoom2=0&NoAdultsRoom3=0&NoChildrenRoom3=0&NoInfantsRoom3=0&AgesRoom1=&AgesRoom2=&AgesRoom3=&HolidayTypeName=Flights+%26+Hotels&ProductName=Banff+(YYC)%2C+Canada&McComments=+%7C+Flexibility%3A+Exact+dates+only+%7C+Best+time+to+contact%3A+after+7p.m.+%7C+Amount+to+spend%3A+1000+%7C+Travelled+before%3A+No&FlightClass=Economy
 */
    /**
     * Send fields for creating new enquiry
     * @return bool
     */
    public function sendForm()
    {
        //send form to site
        $result = $this->pageGetter->sendRequest(static::$formRequestUrl, 'POST', $this->formFields, static::$enquiryPageUrl, false, false, true);

        if($result['Status'] == "FAIL"){
            self::log($result['StatusDetails'] . "\r\n" . $result['Response']);
            return false;
        }

        if(!$this->isPageGood($result['Response'], '#\d{5,10}#', 'Error Page: Didn`t find correct response'))
            return false;

        $this->resultPage = $result['Response'];

        return true;
    }

    protected function isPageGood($content, $pattern, $message)
    {
        if (!is_numeric($content)) {
            $this->log($message . "\r\n" . $content);
            return false;
        }

        return true;
    }

    protected function fillPassengersCount(){
        $roomInfo = $this->quote->getAdultsChildAgesInfo();

        if($roomInfo['adultsCount'] > 0 && $roomInfo['adultsCount'] <= $this->maxAdults)
            $this->formFields['NoAdults'] = $roomInfo['adultsCount'];

        if($roomInfo['childrenCount'] >= 0 && $roomInfo['childrenCount'] <= $this->maxChildren)
            $this->formFields['NoChildren'] = $roomInfo['childrenCount'];
    }

    protected function fillDate()
    {
        if(empty($this->quote->date)) {
            return;
        }

        $date = \DateTime::createFromFormat('Y-m-d', $this->quote->date);
        if($date !== false) {
            $this->formFields['DepartureDate'] = $date->format('d/m/Y');
            $this->formFields['ReturnDate'] = $date->add(new \DateInterval('P' . $this->quote->duration . 'D'))->format('d/m/Y');
        }
    }

    // flight class (economy/premium/business/first)
    protected function fillFlightCategory()
    {
        switch($this->quote->flight_category){
            case TravelQuote::FLIGHT_BUSINESS :
                $this->formFields['FlightClass'] = static::FLIGHT_BUSINESS_OR_FIRST;
                break;
            case TravelQuote::FLIGHT_PREMIUM :
                $this->formFields['FlightClass'] = static::FLIGHT_PREMIUM;
                break;
            case TravelQuote::FLIGHT_ECONOMY :
                $this->formFields['FlightClass'] = static::FLIGHT_ECONOMY;
                break;
        }
    }

    protected function fillAirport()
    {
        $airport = DictAirport::getBestAtTravelValueByName($this->quote->airport);
        if(!empty($airport))
            $this->formFields['Departure'] = $airport;
    }

    protected function fillDestination()
    {
        $destination = QuoteCompanyDestination::getDestinationValue(
            $this->companyId, $this->quote->city, $this->quote->city, $this->quote->country);

        if($destination){
            $this->formFields['ProductName'] = $destination;
            $destinationAirport = substr($destination, strpos($destination, '(')+1, 3);
            if($destinationAirport == strtoupper($destinationAirport))
                $this->formFields['Destination'] = $destinationAirport;
        }
    }

    protected function fillTitle()
    {
        $this->formFields['Title'] = $this->quote->user_title;

        if($this->quote->user_title == TravelQuote::USER_TITLE_DR)
            $this->formFields['Title'] = strtoupper(TravelQuote::USER_TITLE_DR);
    }

    //McComments	+|+Flexibility:+Exact+dates+only+|+Best+time+to+contact:+after+7+p.m.+|+Travelled+before:+No
    protected function fillMcComment()
    {
        $this->formFields['McComments'] = ' | Flexibility: Exact dates only | Best time to contact: '
            . $this->quote->best_time2contact;

        if(!empty($this->quote->budget))
            $this->formFields['McComments'] .= ' | Amount to spend: ' . $this->quote->budget;

        $this->formFields['McComments'] .= ' | Travelled before: No';
    }

    /**
     * @inheritdoc
     */
    protected function fillData()
    {
        $this->fillPassengersCount();
        $this->fillDate();
        $this->fillFlightCategory();
        $this->fillAirport();
        $this->fillDestination();
        $this->fillTitle();
        $this->fillMcComment();
        $this->formFields['TelephoneNumber'] = $this->quote->phone;
        $this->formFields['FirstName'] = $this->quote->user_first_name;
        $this->formFields['LastName'] = $this->quote->user_last_name;
        $this->formFields['EmailAddress'] = $this->quote->email;

        $this->formFields['Comments'] = implode(
            "\r\n",
            $this->quote->getQuoteInfoByFields([
                TravelQuote::TOTAL_BUDGET_TEXT_FIELD,
                TravelQuote::DETAIL_TEXT_FIELD,
            ])
        );

        return $this->isFormFilledGood();
    }

    protected function isFormFilledGood()
    {
        if(empty($this->formFields['ProductName']) || empty($this->formFields['Destination'])){
            Yii::warning("Couldn't use BestAtTravel due to destination is wrong (didn't find destination by city:{$this->quote->city}; country: {$this->quote->country})");
            return false;
        }

        if(empty($this->formFields['Departure'])){
            Yii::warning("Couldn't use BestAtTravel due to airport is wrong ({$this->quote->airport})");
            return false;
        }

        if(empty($this->formFields['DepartureDate']) || empty($this->formFields['ReturnDate'])){
            Yii::warning("Couldn't use BestAtTravel due to departing date or returning date is wrong (date: {$this->quote->date}), duration: {$this->quote->duration})");
            return false;
        }

        if(empty($this->formFields['NoAdults']) || is_string($this->formFields['NoChildren'])){
            Yii::warning("Couldn't use BestAtTravel due to adults count or children count is wrong or more than it can be");
            return false;
        }

        if(empty($this->formFields['Title']) || empty($this->formFields['FirstName']) || empty($this->formFields['LastName'])){
            Yii::warning("Couldn't use BestAtTravel due to user name is wrong");
            return false;
        }

        if(empty($this->formFields['TelephoneNumber'])){
            Yii::warning("Couldn't use BestAtTravel due to phone is wrong ({$this->quote->phone})");
            return false;
        }

        if(empty($this->formFields['EmailAddress'])){
            Yii::warning("Couldn't use BestAtTravel due to email is wrong ({$this->quote->email})");
            return false;
        }

        return true;
    }

}