<?php
/**
 * Created by Kudin Dmitry.
 * User: Monk
 * Date: 14.08.2018
 * Time: 14:30
 */

namespace common\components\quotes\travel\travelcounsellors;

use common\components\quotes\travel\TravelQuoteBase;
use common\models\Category;
use common\models\TravelQuote;

class TravelCounsellorsQuote extends TravelQuoteBase
{
    /**
     * The associated array containing full form fields values
     */
    //contactTitle=Mr&contactForename=John&contactSurname=Green&contactEmailAddress=m1495244%40nwytg.com&contactPhone=&contactEnquiryDetails=Spain&street=&Terms=on&hp-field=
    protected $formFields = [
        'contactTitle' => '', // user title
        'contactForename' => '', // user first name
        'contactSurname' => '', // user last name
        'contactPhone' => '', // user phone
        'contactEmailAddress' => '', // user email
        'contactEnquiryDetails' => '', // enquiry detail
        'street' => '',
        'Terms' => 'on',
        'hp-field' => ''
    ];

    /**
     * @param TravelQuote $quote
     * @param integer $companyId
     * @param boolean $sendRealQuote
     */
    public function __construct(TravelQuote $quote, $companyId, $sendRealQuote){
        $this->companyId = $companyId;
        $this->categoryId = $quote->category_id;
        $this->mainPageUrl = 'https://www.travelcounsellors.co.uk/';
        $this->formSenderSDKPath = dirname(__FILE__);
        $this->debug=true;
        $this->sendRealQuote = $sendRealQuote;

        parent::__construct($quote);
    }

    /**
     * @inheritdoc
     */
    protected function fillData()
    {
        $this->formFields['contactTitle'] = $this->quote->user_title;
        $this->formFields['contactForename'] = $this->quote->user_first_name;
        $this->formFields['contactSurname'] = $this->quote->user_last_name;
        $this->formFields['contactPhone'] = $this->quote->phone;
        $this->formFields['contactEmailAddress'] = $this->quote->email;

        $this->formFields['contactEnquiryDetails'] = implode(
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

        return true;
    }

    /**
     * Send fields for creating new enquiry to page https://www.travelcounsellors.co.uk/sarah.belbin
     * @return bool
     */
    public function sendForm()
    {
        //send form to site
        $result = $this->pageGetter->sendRequest(
            $this->getSendEnquiryPageUrl(),
            'POST',
            $this->formFields,
            $this->getRequestPageUrl(),
            false,
            false,
            true
        );

        if($result['Status'] == "FAIL"){
            self::log($result['StatusDetails'] . "\r\n" . $result['Response']);
            return false;
        }

        if(!$this->isJsonGood($result['Response']))
            return false;

        $this->resultPage = $result['Response'];

        return true;
    }

    protected function getSendEnquiryPageUrl(){
        return $this->mainPageUrl . 'sarah.belbin';
    }

    protected function getRequestPageUrl(){
        return $this->mainPageUrl . 'sarah.belbin';
    }

    /**
     * Detecting is remote page was got correct
     *
     * @param  string  $json
     * @return boolean
     */
    protected function isJsonGood($json)
    {
        $object = json_decode($json);
        if (json_last_error() === JSON_ERROR_NONE) {
            if(!isset($object->success)){
                $this->log("Result for solicitor with ID " . $this->companyId . " with wrong JSON\r\n" . $json);
                return false;
            }
        } else {
            $this->log("Result for solicitor with ID " . $this->companyId . " is not JSON format\r\n" . $json);
            return false;
        }

        return true;
    }


}

