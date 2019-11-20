<?php

/**
 * Created by Kudin Dmitry.
 * Date: 09.10.2017
 * Time: 17:17
 */

namespace common\components\quotes\travel\ski\skikings;

use Yii;
use common\components\quotes\travel\TravelQuoteBase;
use common\models\TravelQuote;

class SkiKingsQuote extends TravelQuoteBase
{
    protected static $formRequestUrl = 'https://www.skikings.co.uk/submit-form.php';

    protected static $enquiryPageUrl = 'https://www.skikings.co.uk/contact-us/';

    /**
     * The associated array containing full form fields values
     */
    protected $formFields = [
        'enquire_title' => '', //Mr
        'enquire_firstname' => '', //Jack
        'enquire_surname' => '', //Brown
        'enquire_email' => '', //d1237875@urhen.com
        'enquire_phone' => '', //78782934
        'enquire_postcode' => '', //e1 1je
        'formatted_address' => '',
        'enquire_offer_details' => '',
        'enquire_company' => '',
        'enquire_address1' => '',
        'enquire_address2' => '',
        'enquire_address3' => '',
        'enquire_address4' => '',
        'enquire_address5' => '',
        'enquire_town' => '',
        'enquire_county' => '',
        'enquire_country' => 'United Kingdom', //United+Kingdom
        'enquire_sub_building' => '',
        'enquire_building_name' => '',
        'enquire_building_number' => '',
        'enquire_street' => '',
        'enquire_ad' => '', //	Number of adults (2)
        'enquire_ch' => '', // Number of children (1)
        'enquire_dep_date' => '', // Prefferred departure date
        'enquire_message' => '', // Details
        'enquire_newsletter' => 'No',
        'enquire_post' => 'No',
        'form-name' => 'contact-form',
        'enquire_brochure' => '0',
        'enquire_type' => 'general',
        'current_url' => 'https://www.skikings.co.uk/contact-us/'
    ];

    /**
     * @param TravelQuote $quote
     * @param integer $companyId
     * @param boolean $sendRealQuote
     */
    public function __construct(TravelQuote $quote, $companyId, $sendRealQuote){
        $this->companyId = $companyId;
        $this->categoryId = $quote->category_id;
        $this->mainPageUrl = 'https://www.skikings.co.uk/';
        $this->formSenderSDKPath = dirname(__FILE__);
        $this->debug=true;
        $this->sendRealQuote = $sendRealQuote;

        parent::__construct($quote);
    }

//URL: https://www.skikings.co.uk/submit-form.php
//Request method: POST
//
//Host: www.skikings.co.uk
//User-Agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:69.0) Gecko/20100101 Firefox/69.0
//Accept: */*
//Accept-Language: ru-RU,ru;q=0.8,en-US;q=0.5,en;q=0.3
//Accept-Encoding: gzip, deflate, br
//Content-Type: application/x-www-form-urlencoded; charset=UTF-8
//X-Requested-With: XMLHttpRequest
//Content-Length: 673
//Connection: keep-alive
//Referer: https://www.skikings.co.uk/contact-us/
//Cookie: __cfduid=dcff357bb20e95416e178a8b088c56dc71574185665; PHPSESSID=eoeslb469jvrnp948im4kvk1b4; __ski__=eoeslb469jvrnp948im4kvk1b4; _ga=GA1.3.1116941820.1574185668; _gid=GA1.3.605608192.1574185668; _fbp=fb.2.1574185668125.470207538; _hjid=cb34bf44-9786-403d-a91b-309aaf96a91f; _hjIncludedInSample=1; sr-data=%7B%22uid%22%3A%228641574185669779%22%2C%22platform%22%3A%22windows%22%2C%22os%22%3A%22windows%22%2C%22browser%22%3A%22Mozilla%20Firefox%22%2C%22device%22%3A%22Desktop%20%2F%20Laptop%22%2C%22ip%22%3A%2281.17.138.185%22%2C%22country_code%22%3A%22UA%22%7D; sr-cur=Tue%20Nov%2019%202019%2019%3A47%3A49%20GMT%2B0200%20(%D0%92%D0%BE%D1%81%D1%82%D0%BE%D1%87%D0%BD%D0%B0%D1%8F%20%D0%95%D0%B2%D1%80%D0%BE%D0%BF%D0%B0%2C%20%D1%81%D1%82%D0%B0%D0%BD%D0%B4%D0%B0%D1%80%D1%82%D0%BD%D0%BE%D0%B5%20%D0%B2%D1%80%D0%B5%D0%BC%D1%8F)
//
//
//POST parameters
//enquire_title	Mr
//enquire_firstname	Jack
//enquire_surname	Brown
//enquire_email	d1237875@urhen.com
//enquire_phone	78782934
//enquire_postcode	e11je
//formatted_address
//enquire_offer_details
//enquire_company
//enquire_address1
//enquire_address2
//enquire_address3
//enquire_address4
//enquire_address5
//enquire_town
//enquire_county
//enquire_country	United+Kingdom
//enquire_sub_building
//enquire_building_name
//enquire_building_number
//enquire_street
//enquire_ad	2
//enquire_ch	1
//enquire_dep_date	25
//enquire_message	to+France
//enquire_newsletter	No
//enquire_post	No
//form-name	contact-form
//enquire_brochure	0
//enquire_type	general
//current_url	https://www.skikings.co.uk/contact-us/
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

        if(!$this->isPageGood($result['Response'], '#Thank you for your enquiry#', 'Error Page: Didn`t find correct response'))
            return false;

        $this->resultPage = $result['Response'];

        return true;
    }

    /**
     * @return bool
     */
    protected function fillData()
    {
        $this->formFields['enquire_postcode'] = $this->quote->address_postcode;

        $this->formFields['enquire_title'] = $this->quote->user_title;
        $this->formFields['enquire_firstname'] = $this->quote->user_first_name;
        $this->formFields['enquire_surname'] = $this->quote->user_last_name;
        $this->formFields['enquire_phone'] = $this->quote->phone;
        $this->formFields['enquire_email'] = $this->quote->email;

        $roomInfo = $this->quote->getAdultsChildAgesInfo();
        $this->formFields['enquire_ad'] = $roomInfo['adultsCount'];
        $this->formFields['enquire_ch'] = $roomInfo['childrenCount'];
        $this->formFields['enquire_dep_date'] = empty($this->quote->date) ? 'Anytime' : $this->quote->date;

        $this->formFields['enquire_message'] = implode(
            "\r\n",
            $this->quote->getQuoteInfoByFields([
                TravelQuote::COUNTRY_TEXT_FIELD,
                TravelQuote::CITY_TEXT_FIELD,
                TravelQuote::AIRPORT_TEXT_FIELD,
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
        if(empty($this->formFields['enquire_title']) || empty($this->formFields['enquire_firstname']) || empty($this->formFields['enquire_surname'])){
            Yii::warning("Couldn't use SkiKings due to user name is wrong");
            return false;
        }

        if(empty($this->formFields['enquire_phone'])){
            Yii::warning("Couldn't use SkiKings due to phone is wrong ({$this->quote->phone})");
            return false;
        }

        if(empty($this->formFields['enquire_email'])){
            Yii::warning("Couldn't use SkiKings due to email is wrong ({$this->quote->email})");
            return false;
        }

        if(empty($this->formFields['enquire_postcode'])){
            Yii::warning("Couldn't use SkiKings due to postcode address is wrong ({$this->quote->address_postcode})");
            return false;
        }

        if(empty($this->formFields['enquire_ad']) || is_string($this->formFields['enquire_ch'])){
            Yii::warning("Couldn't use SkiKings due to adults count or children count is wrong");
            return false;
        }

        if(empty($this->formFields['enquire_dep_date'])){
            Yii::warning("Couldn't use SkiKings due to departure date is wrong ({$this->quote->date})");
            return false;
        }

        return true;
    }
}