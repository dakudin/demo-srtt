<?php
/**
 * Created by Kudin Dmitry.
 * User: Monk
 * Date: 24.07.2018
 * Time: 14:30
 */

namespace common\components\quotes\travel\eshores;

use Yii;
use common\components\quotes\travel\TravelQuoteBase;
use common\models\Category;
use common\models\TravelQuote;

class EShoresQuote extends TravelQuoteBase
{
    /**
     * The associated array containing full form fields values
     */
    protected $formFields = [
        'inpFirstName' => '', //user first name
        'inpSurname' => '', // user last name
        'inpEmail' => '', // user email
        'inpPhone' => '', // contact phone
        'txtEnquiry' => ['', ''], // 2 fields with same names
        'selAdults' => '', // adults count with range 1-20,20+
        'selChildren' => '', //child count with range 0-9
        'childage' => ['0','0','0','0','0','0','0','0','0'], //child ages 0-12;
        'datepicker' => ['', '', ''], //date, month and year;
        'selHeardAbout' => 'Internet Search',
        'inpFormType' => 'Request a Quote',
        'gclid' => '',
        'keyword' => '-'
    ];

    /**
     * @var int maximum count of children can be in form
     */
    protected $maxChildren = 9;

    /**
     * @var int maximum count of adults can be in form, if more than add + to it
     */
    protected $maxAdults = 20;

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

    /**
     * @param int $adultsCount
     */
    protected function fillAdultsCount($adultsCount){
        if($adultsCount > $this->maxAdults)
            $this->formFields['selAdults'] = (string)$this->maxAdults . '+';
        else
            $this->formFields['selAdults'] = $adultsCount;
    }

    /**
     * @param int $childCount
     * @param array $ages
     */
    protected function fillChildrenInfo($childCount, $ages){
        $this->formFields['selChildren'] = $childCount;
        $i=0;
        foreach($ages as $age){
            $this->formFields['childage'][$i] = $age;
            $i++;
        }
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
                TravelQuote::USER_BEST_TIME2CONTACT,
            ])
        );

        return true;
    }

    /**
     * Send fields for creating new enquiry to page https://www.eshores.co.uk/includes/sendenquiry.asp
     * @param $params array
     * @return bool
     */
    public function sendForm()
    {
        //send form to site
        $result = $this->pageGetter->sendRequest($this->getSendEnquiryPageUrl(), 'POST', $this->getUrlDecodedFields());

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
     * @return string
     */
    protected function getUrlDecodedFields(){
        $result = '';

        foreach($this->formFields as $key=>$param){

            if($result!='')
                $result .= '&';

            if(is_array($param)){
                foreach($param as $index=>$value){
                    if($index!=0)
                        $result .= '&';

                    $result .= $key . '=' . urlencode($value);
                }
            }else{
                $result .= $key . '=' . urlencode($param);
            }
        }

        return $result;
    }

    protected function getSendEnquiryPageUrl(){
        return $this->mainPageUrl . 'includes/sendenquiry.asp';
    }

    protected function getRequestPageUrl(){
        return $this->mainPageUrl . 'contact-us.asp';
    }

}

