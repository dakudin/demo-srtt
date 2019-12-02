<?php
/**
 * Created by Kudin Dmitry
 * Date: 28.11.2019
 * Time: 20:26
 */

namespace common\components\quotes\travel\ski\skisolutions;

use Yii;
use common\components\quotes\travel\TravelQuoteBase;
use common\models\TravelQuote;


class SkiSolutionQuote extends TravelQuoteBase
{
    protected static $siteTitle = 'SkiSolution';
    /**
     * @var string Url which send form to first page (main page)
     */
    protected static $enquiryPageUrl = 'https://www.skisolutions.com/enquiries/new';

    /**
     * @var string Form ID which need to parse for first request
     */
    protected static $mainPageFormId = 'new_enquiry';

    /**
     * @var string url which contains form
     */
    protected $firstFormActionUrl = ''; // '//go.pardot.com/l/325681/2017-03-04/9d'

    /**
     * @var string url for creating enquiry
     */
    protected $secondFormActionUrl = ''; // https://www.skisolutions.com/enquiries

    protected $patternFormField = '#<input\stype="hidden"\sname="(.*?)"\svalue="(.*?)"#si';

    /**
     * The associated array containing full form fields values
     */
    protected $formFields = [
        'utf8' => '', // ✓
        'enquiry[referring_page]' => '',
        'enquiry[landing_page_url]' => 'https://www.skisolutions.com/enquiries/new',
        'enquiry[affiliate_link]' => '',
        'enquiry[first_name]' => '',
        'enquiry[last_name]' => '',
        'enquiry[email]' => '',
        'enquiry[phone]' => '', // 07911 163256
        'enquiry[message]' => '',
        'commit' => 'Send',
        'enquiry[holiday_detail_attributes][holiday_start]' => '',
        'enquiry[holiday_detail_attributes][travellers]' => '',
        'enquiry[properties]' => '',
        'enquiry[resorts]' => ''
    ];

    /**
     * The associated array containing parsed form fields
     */
    protected $parsedFormFields = [];

    /**
     * @param TravelQuote $quote
     * @param integer $companyId
     * @param boolean $sendRealQuote
     */
    public function __construct(TravelQuote $quote, $companyId, $sendRealQuote){
        $this->companyId = $companyId;
        $this->categoryId = $quote->category_id;
        $this->mainPageUrl = 'https://www.skisolutions.com/enquiries/new';
        $this->formSenderSDKPath = dirname(__FILE__);
        $this->debug=true;
        $this->sendRealQuote = $sendRealQuote;

        parent::__construct($quote);
    }

//=== 1-st form
//URL: https://go.pardot.com/l/325681/2017-03-04/9d
//Method: POST
//
//Host: go.pardot.com
//User-Agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:70.0) Gecko/20100101 Firefox/70.0
//Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8
//Accept-Language: ru-RU,ru;q=0.8,en-US;q=0.5,en;q=0.3
//Accept-Encoding: gzip, deflate, br
//Content-Type: application/x-www-form-urlencoded
//Content-Length: 509
//Origin: https://www.skisolutions.com
//Connection: keep-alive
//Referer: https://www.skisolutions.com/enquiries/new
//Upgrade-Insecure-Requests: 1

//=== 2-nd form
//URL: https://www.skisolutions.com/enquiries
//Method: POST
//
//Host: www.skisolutions.com
//User-Agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:70.0) Gecko/20100101 Firefox/70.0
//Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8
//Accept-Language: ru-RU,ru;q=0.8,en-US;q=0.5,en;q=0.3
//Accept-Encoding: gzip, deflate, br
//Content-Type: application/x-www-form-urlencoded
//Content-Length: 509
//Origin: https://go.pardot.com
//Connection: keep-alive
//Referer: https://go.pardot.com/l/325681/2017-03-04/9d
//Cookie: exit_modal_seen=yes; _ski_solutions_session=aitWcjIxMVZPMXdwa2lJL0RuTGNITGxBSURxOGdSUFZkWU9waXdBa2lhRXFrZXhqdW03RTdtRml6Tm04QytjVHNvdmRtbEkzcEUvcGlaTDdYS0tkVFNTajVvZHI3NENhKzRqUE4yTGxZa0JRcGl5eWdDTjNKUjhBWWozVngzcEFGaEtIYWlVcERQYlNsQWVuUWhJdDZRbTdlc0NwNjJNekFFVkFaT1B3YzZoMHpGWkR0blVmOS9sZ2ZYY2FHR0pVd0IyODBrNDZnblJsdHVqSUc0bldGYjZBMHAwZDBNRTNzamx5Szh6K1R2dnZhUmUvWFVWVzJvNjA3Z2JFSHJmYmQwVTRXS0t1bEhrOWcxMXZlSnQySGJkWEJtRWNhMFlaUE5CeU5zS3FVenNrOTJQWllJZmJLWFBwTms0czZ2cHFwLytIcmNzOTRFWE9aNGg1c0I5R0tWelVUK3hOVEFlN2dOOEFPR2RqaTNSZ1J2eitxNmI0a0dwajF2TDJJQ0g0UHczYmhDdFZEVm1CL3EzQnhKRnRlQT09LS16SkZmTWQ2WEYwVmhMS0tSM1hCcFJRPT0%3D--9f07097e78f7369604983cd4873f6d9b746338b8; _ga=GA1.2.81587284.1574965648; _gid=GA1.2.637121447.1574965648; _hjid=d1bb0e9b-b256-4ba6-891a-ad61b684151e; _hjIncludedInSample=1; adiV=1289346; adiVi=1721399; adiS=D3EDBAB361B97FC0D03B2A379B6CB518.numrep10; adiLP=1574965762857; ai_user=a6EaY|2019-11-28T18:27:28.733Z; __qca=P0-420364692-1574965647979; _fbp=fb.1.1574965649606.78466472; __lc.visitor_id.g1509622_185.group185=S1574965653.b66af3933d; __lc.visitor_id.g1509622_185.group185=S1574965653.b66af3933d; lc_window_state.group185=minimized; lc_window_state.group185=minimized; ai_session=WopKW|1574965657770|1574965657770; visitor_id325681=29547531; visitor_id325681-hash=7850461e825b57ad12f37c79150356d0d2747c1fb71e51d0637b7d44e457340a7a2a1d3b6388c3cf9891992a39477c1e36188197
//Upgrade-Insecure-Requests: 1

    /**
     * Send fields for creating new enquiry
     * @return bool
     */
    public function sendForm()
    {
        $result = [
            'Response' => file_get_contents($this->formSenderSDKPath . '\1.txt')
        ];

        //get form page
/*        $result = $this->pageGetter->sendRequest(static::$enquiryPageUrl, 'GET');

        if($result['Status'] == "FAIL"){
            self::log($result['StatusDetails'] . "\r\n" . $result['Response']);
            return false;
        }*/

        if(!$this->prepareHiddenFields($result['Response']))
            return false;

        $result = [
            'Response' => file_get_contents($this->formSenderSDKPath . '\form-page-html.txt')
        ];
//var_dump($this->firstFormActionUrl);
//var_dump($this->formFields); die;

        //send form to external site
//        $result = $this->pageGetter->sendRequest($this->firstFormActionUrl, 'POST', $this->formFields, static::$enquiryPageUrl);

        if(!$this->prepareNewFormFields($result['Response']))
            return false;
var_dump($this->secondFormActionUrl);
var_dump($this->parsedFormFields); die;
        //send parsed form to internal site https://www.skisolutions.com/enquiries with redirecting to https://www.skisolutions.com/thankyou by 302 code
//        $result = $this->pageGetter->sendRequest($this->secondFormActionUrl, 'POST', $this->parsedFormFields, $this->firstFormActionUrl);

        if(!$this->isPageGood($result['Response'], '#Thank you for enquiring with Ski Solutions#', 'Error Page: Didn`t find correct response'))
            return false;

        $this->resultPage = $result['Response'];

        return true;
    }

    /**
     * Detect form action and utf8 form field from first page
     * @param $page string
     * @return bool
     */
    protected function prepareHiddenFields($page)
    {
        $formAction = $this->parseElement(
            '#<form[^>]*?id="' . static::$mainPageFormId . '"\saction="(.*?)"#s',
            $page,
            static::$siteTitle . ' action form from URL: ' . static::$enquiryPageUrl
        );
        if(!$formAction) return false;

        $utf8 = $this->parseElement('#<input\sname="utf8"\stype="hidden"\svalue="(.*?)"#s', $page, static::$siteTitle . ' form page hidden field `utf8`');
        if(!$utf8) return false;

        $this->formFields['utf8'] = $utf8;

        if(strpos($formAction, 'http') === false)
            $this->firstFormActionUrl = 'https:' . $formAction;
        else
            $this->firstFormActionUrl = $formAction;

        return true;
    }

    /**
     * Parse form action and form fields for sending to https://www.skisolutions.com/enquirie
     * @param $page
     * @return bool
     */
    protected function prepareNewFormFields($page){
        $this->parsedFormFields = [];

        $form = $this->parseElement('#<form\sid="postform"[^>]*?action="(.*?)"#s', $page,  static::$siteTitle . ' second page form `postform`');
        if(!$form) return false;
        $this->secondFormActionUrl = $form;

        $form = $this->parseElement('#<form\sid="postform"[^>]*?>(.*?)</form>#s', $page,  static::$siteTitle . ' second page form `postform`');

        if(preg_match_all($this->patternFormField, $form, $matches)){
            if(isset($matches[1]) && isset($matches[2]) && is_array($matches[1]) && is_array($matches[2])){
                for($i=0; $i<count($matches[1]); $i++){

                    if(strpos($matches[1][$i], '>') !== false || strpos($matches[1][$i], '<') !== false || strpos($matches[2][$i], '>') !== false || strpos($matches[2][$i], '<') !== false){
                        Yii::error('Couldn`t use ' . static::$siteTitle  .' due to wrong form fields: //' . $matches[1][$i] . '//' . $matches[2][$i]);
                        return false;
                    }

                    $this->parsedFormFields[$matches[1][$i]] = $matches[2][$i];
                }
            }
        };

        if(empty($this->parsedFormFields)){
            $this->log(static::$siteTitle . ': Didn`t find form fields in:' . $page);
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    protected function fillData()
    {
        $this->formFields['enquiry[first_name]'] = $this->quote->user_first_name;
        $this->formFields['enquiry[last_name]'] = $this->quote->user_last_name;
        $this->formFields['enquiry[email]'] = $this->quote->email;
        $this->formFields['enquiry[phone]'] = $this->quote->phone;

        // details
        $this->formFields['enquiry[message]'] = implode(
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
        if(empty($this->formFields['enquiry[first_name]']) || empty($this->formFields['enquiry[last_name]'])){
            Yii::warning("Couldn't use " . static::$siteTitle . " due to user name is wrong");
            return false;
        }

        if(empty($this->formFields['enquiry[email]'])){
            Yii::warning("Couldn't use " . static::$siteTitle . " due to email is wrong ({$this->quote->email})");
            return false;
        }

        if(empty($this->formFields['enquiry[phone]'])){
            Yii::warning("Couldn't use " . static::$siteTitle . " due to phone is wrong");
            return false;
        }

        return true;
    }
}