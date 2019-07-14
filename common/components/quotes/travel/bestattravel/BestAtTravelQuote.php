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

//https://www.bestattravel.co.uk/contact-us?PageId=31958#enquiry
class BestAtTravelQuote extends TravelQuoteBase
{

    /**
     * @param TravelQuote $quote
     * @param integer $companyId
     * @param boolean $sendRealQuote
     */
    public function __construct(TravelQuote $quote, $companyId, $sendRealQuote){
        $this->companyId = $companyId;
        $this->categoryId = $quote->category_id;
        $this->mainPageUrl = 'https://www.eshores.co.uk/';
        $this->formSenderSDKPath = dirname(__FILE__);
        $this->debug=true;
        $this->sendRealQuote = $sendRealQuote;

        parent::__construct($quote);
    }


/*
URL запроса:https://www.bestattravel.co.uk/common/OnlineEnquiry
Метод запроса:POST
 *
Host: www.bestattravel.co.uk
User-Agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:67.0) Gecko/20100101 Firefox/67.0
Accept: text/html, */*; q=0.01
Accept-Language: ru-RU,ru;q=0.8,en-US;q=0.5,en;q=0.3
Accept-Encoding: gzip, deflate, br
Referer: https://www.bestattravel.co.uk/contact-us?PageId=31958
Content-Type: application/x-www-form-urlencoded; charset=UTF-8
X-Requested-With: XMLHttpRequest
Content-Length: 928
Connection: keep-alive




Title	Mr
FirstName	John
LastName	Brown
EmailAddress	b4113658@urhen.com
TelephoneNumber	3994291993838
HolidayType	4
Destination	296
Departure	LBA
DepartureDate	12/7/2019
ReturnDate	13/7/2019
Comments
NewsLetter	false
Room1
Room2
Room3
NoAdults	2
NoChildren	1
NoInfants	0
PassengerText
HotelBoardBasis	Select
HotelID	1349
HotelName	Classic+Garden+Route
HotelTransfer
NoAdultsRoom1	0
NoChildrenRoom1	0
NoInfantsRoom1	0
NoAdultsRoom2	0
NoChildrenRoom2	0
NoInfantsRoom2	0
NoAdultsRoom3	0
NoChildrenRoom3	0
NoInfantsRoom3	0
AgesRoom1
AgesRoom2
AgesRoom3
HolidayTypeName	Private+and+Escorted+Tours
ProductName	South+Africa
McComments	+|+Tour+comment:+sea+view+|+Additional+where+to:+South+Africa+|+Month+of+Travel:+September+|+Year+of+Travel:+2019+|+Flexibility:+Exact+dates+only+|+Best+time+to+contact:+after+19+p.m.+|+Amount+to+spend:+1000+|+Travelled+before:+No
FlightClass	Economy


Responce: 697402

if all ok get result page
window.location.href = '/search/contactusthankyou' + "?BOSId=" + data;


=================================================
Host: www.bestattravel.co.uk
User-Agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:68.0) Gecko/20100101 Firefox/68.0
Accept: text/html, */*; q=0.01
Accept-Language: ru-RU,ru;q=0.8,en-US;q=0.5,en;q=0.3
Accept-Encoding: gzip, deflate, br
Referer: https://www.bestattravel.co.uk/contact-us?PageId=31958
Content-Type: application/x-www-form-urlencoded; charset=UTF-8
X-Requested-With: XMLHttpRequest
Content-Length: 924
Connection: keep-alive


Title	Mr
FirstName	John
LastName	Brown
EmailAddress	b4122299@urhen.com
TelephoneNumber	344245884993
HolidayType	4
Destination	213
Departure	LGW
DepartureDate	12/7/2019
ReturnDate	13/7/2019
Comments
NewsLetter	false
Room1
Room2
Room3
NoAdults	2
NoChildren	0
NoInfants	0
PassengerText
HotelBoardBasis	Select
HotelID	1349
HotelName	Classic+Garden+Route
HotelTransfer
NoAdultsRoom1	0
NoChildrenRoom1	0
NoInfantsRoom1	0
NoAdultsRoom2	0
NoChildrenRoom2	0
NoInfantsRoom2	0
NoAdultsRoom3	0
NoChildrenRoom3	0
NoInfantsRoom3	0
AgesRoom1
AgesRoom2
AgesRoom3
HolidayTypeName	Private+and+Escorted+Tours
ProductName	Maldives
McComments	+|+Tour+comment:+amazing+view+|+Additional+where+to:+South+Africa+|+Month+of+Travel:+October+|+Year+of+Travel:+2019+|+Flexibility:+Exact+dates+only+|+Best+time+to+contact:+after+7+p.m.+|+Amount+to+spend:+1000+|+Travelled+before:+No
FlightClass	Economy
 */
}