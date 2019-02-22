<?php
/**
 * Created by Kudin Dmitry.
 * User: Monk
 * Date: 09.08.2018
 * Time: 14:30
 */

namespace common\components\quotes\travel\designtravel;

use common\components\quotes\travel\TravelQuoteBase;
use common\models\Category;
use common\models\TravelQuote;

class DesignTravelQuote extends TravelQuoteBase
{
    /**
     * The associated array containing full form fields values
     */
    //action=SensesDesignerTravel_referral_create&type=enquiry&name=John&telephone=020388299483&email=m1474993%40nwytg.com&message=Spain
    protected $formFields = [
        'action' => 'SensesDesignerTravel_referral_create',
        'type' => 'enquiry',
        'name' => '', // user name
        'telephone' => '', // user phone
        'email' => '', // user email
        'message' => '' // enquiry detail
    ];

    /**
     * @param TravelQuote $quote
     * @param integer $companyId
     */
    public function __construct(TravelQuote $quote, $companyId){
        $this->companyId = $companyId;
        $this->categoryId = $quote->category_id;
        $this->mainPageUrl = 'https://designertravel.co.uk/';
        $this->formSenderSDKPath = dirname(__FILE__);
        $this->debug=true;

        parent::__construct($quote);
    }

    /**
     * @inheritdoc
     */
    protected function fillData()
    {
        $this->formFields['name'] = $this->quote->getUserFullName();

        $this->formFields['telephone'] = $this->quote->phone;

        $this->formFields['email'] = $this->quote->email;

        $this->formFields['message'] = implode(
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
     * Send fields for creating new enquiry to page https://designertravel.co.uk/wp-admin/admin-ajax.php
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

        if(!$this->isPageGood($result['Response'], '#Your Enquiry has been recorded#', 'Error Page: Didn`t find JSON correct response'))
            return false;

        $this->resultPage = $result['Response'];

        return true;
    }

    protected function getSendEnquiryPageUrl(){
        return $this->mainPageUrl . 'wp-admin/admin-ajax.php';
    }

    protected function getRequestPageUrl(){
        return $this->mainPageUrl . 'enquiry/';
    }

}

