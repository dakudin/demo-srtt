<?php

/**
 * Created by Kudin Dmitry.
 * Date: 09.10.2017
 * Time: 17:17
 */

namespace common\components\quotes\travel\ski\skikings;

use common\components\quotes\travel\TravelQuoteBase;
use common\models\TravelQuote;
use common\models\Category;
use common\models\CompanyCountry;
use common\models\CompanyAirport;
use common\models\CompanyResort;
use common\models\CompanyBoardBasis;
use common\models\CompanyHotelGrade;
use yii\helpers\ArrayHelper;

class SkiKingsQuote extends TravelQuoteBase
{
    /**
     * The associated array containing full form fields values
     */
    protected $formFields = [
        'search_country' => 0, // service Country ID
        'search_resort' => 0, // service Resort ID
        'search_departure' => 0, // service departure airport ID
        'search_date' => '', // departure date in format `2018-01-21`, if empty string then any date
        'search_duration' => 0, // travel duration in days; 0 if any duration
        'search_passengers' => 2, //number of passengers for traveling
    ];

    protected $boardBasis = ['AI', 'BB', 'SD', 'FB', 'HB', 'RO', 'SC'];
    protected $hotelGrade = ['0', '2', '2.5', '3', '3.5', '4', '4.5', '5'];

    protected $hotelFullStar = 'flaticon-star';
    protected $hotelHalfStar = 'half-star';

    /**
     * @param TravelQuote $quote
     */
    public function __construct(TravelQuote $quote){
        $this->companyId = 4;
        $this->categoryId = Category::SKI;
        $this->mainPageUrl = 'http://www.skikings.co.uk/';
        $this->formSenderSDKPath = dirname(__FILE__);
        $this->debug=true;

        parent::__construct($quote);
    }

    /**
     * Send fields for creating new enquiry to page http://www.skikings.co.uk/submit-form.php
     * @param $params array
     * @return bool
     */
    public function sendEnquiry($params)
    {
        if(!isset($params['current_url']) || empty($params['current_url'])) return false;

        //send form to site
        $result = $this->pageGetter->sendRequest($this->getSendEnquiryPageUrl(), 'POST', $params, $params['current_url'], false);

        if($result['Status'] == "FAIL"){
            self::log($result['StatusDetails'] . "\r\n" . $result['Response']);
            return false;
        }

        if(!$this->isPageGood($result['Response'], '#Thank you for your enquiry#', 'Error Page: Didn`t find required phrase `search-results-list`'))
            return false;

        return true;
    }

    /**
     * @return bool
     */
    protected function fillData()
    {
        //need to select country or resort for searching
        if(empty($this->quote->resortIDs) && empty($this->quote->countryIDs) && !empty($this->quote->regionIDs)){
            return false;
        }

        if(!empty($this->quote->countryIDs)){
            $company = CompanyCountry::findOne(['quote_company_id' => $this->companyId, 'country_id' => $this->quote->countryIDs]);

            //do not use this service if country is not in dictionary
            if(is_null($company)) return false;

            $this->formFields['search_country'] = $company->service_country_id;
        }

        if(!empty($this->quote->resortIDs)){
            $resort = CompanyResort::findOne(['quote_company_id' => $this->companyId, 'resort_id' => $this->quote->resortIDs]);

            //do not use this service if resort is not in dictionary
            if(is_null($resort)) return false;

            $this->formFields['search_resort'] = $resort->service_resort_id;
        }

        if(!empty($this->quote->airportIDs)){
            $airport = CompanyAirport::findOne(['quote_company_id' => $this->companyId, 'airport_id' => $this->quote->airportIDs]);

            //do not use this service if airport is not in dictionary
            if(is_null($airport)) return false;

            $this->formFields['search_departure'] = $airport->service_airport_id;
        }

        if(!empty($this->quote->date)){
            $this->formFields['search_date'] = $this->quote->date;
        }

        if(!empty($this->quote->duration)){
            $this->formFields['search_duration'] = $this->quote->duration;
        }

        if(!empty($this->quote->passengers)){
            $this->formFields['search_passengers'] = $this->quote->passengers;
        }

        return true;
    }

    // Go to page http://www.skikings.co.uk/search/results.php
    protected function sendForm()
    {
        //send form to site
        $result = $this->pageGetter->sendRequest($this->getRequestPageUrl(), 'POST', $this->formFields, $this->mainPageUrl, false);

        if($result['Status'] == "FAIL"){
            self::log($result['StatusDetails'] . "\r\n" . $result['Response']);
            return false;
        }

//      $result = [
//         'Response' => file_get_contents($this->formSenderSDKPath . '\response1.txt')
//      ];

        if(!$this->isPageGood($result['Response'], '#search-results-list#', 'Error Page: Didn`t find required phrase `search-results-list`'))
            return false;

        //if set additional filters or page number not equal to 1 then request the additional page
        if($this->isNeedAdditionalRequest()){
            //http://www.skikings.co.uk/search/results/?sid=182&accommodation_type=&board_basis=&star_rating=&resort=&page=2
            $requestUrl = $this->getRequestPageUrlWithParams($result['Response']);

//            self::log($result['Response']);
//            echo $requestUrl . "\r\n" . $result['Response']; die;
            if(!$requestUrl) return false;

            //send form to site
            $result = $this->pageGetter->sendRequest($requestUrl, 'GET', [], $requestUrl, false);
//            echo $requestUrl . "\r\n" . $result['Response']; die;

            if($result['Status'] == "FAIL"){
                self::log($result['StatusDetails'] . "\r\n" . $result['Response']);
                return false;
            }

            if(!$this->isPageGood($result['Response'], '#search-results-list#', 'Error Page: Didn`t find required phrase `search-results-list`'))
                return false;
        }

        $this->resultPage = $result['Response'];

        return true;
    }

    /**
     * Detect if need request additional page with additional filters and page number
     * @return bool
     */
    protected function isNeedAdditionalRequest(){
        return count($this->quote->travelQuoteBoardBasis) < count($this->boardBasis)
            || count($this->quote->travelQuoteHotelGrade) < count($this->hotelGrade)
            || $this->quote->page_number > 1;
    }

    protected function getSendEnquiryPageUrl(){
        return $this->mainPageUrl . 'submit-form.php';
    }

    protected function getRequestPageUrl(){
        return $this->mainPageUrl . 'search/results.php';
    }


    protected function getRequestPageUrlWithParams($previousPage){
        $sessionId = $this->parseElement('#\?sid=(\d{1,})#s', $previousPage, 'Session ID');
        if($sessionId){
            $url = $this->mainPageUrl . 'search/results/?sid=' . (int)$sessionId
                . '&page=' . $this->quote->page_number;
            $url .= $this->getBoardBasisParams();
            $url .= $this->getHotelGradeParams();
            return $url;
        }
        return false;
    }

    /**
     * Prepare board basis for request params
     * @return string
     */
    protected function getBoardBasisParams()
    {
        $boardsBasis = $this->quote->travelQuoteBoardBasis;

        if(!(count($boardsBasis)>0 && count($boardsBasis) < count($this->boardBasis)))
            return '';

        $boardBasisIDs = [];
        foreach ($boardsBasis as $boardBasis) {
            $boardBasisIDs[] = $boardBasis->dict_board_basis_id;
        }

        if (count($boardBasisIDs) == 0) return '';

        $boardsBasis = CompanyBoardBasis::findAll(['quote_company_id' => $this->companyId, 'board_basis_id' => $boardBasisIDs]);

        if (is_null($boardsBasis)) return '';

        return '&board_basis=' . urlencode(implode(',', ArrayHelper::map($boardsBasis, 'board_basis_id', 'service_board_basis_id')));
    }

    /**
     * Prepare hotel grade`s for request params
     * @return string
     */
    protected function getHotelGradeParams()
    {
        $hotelGrades = $this->quote->travelQuoteHotelGrade;

        if(!(count($hotelGrades)>0 && count($hotelGrades) < count($this->hotelGrade)))
            return '';

        $hotelGradeIDs = [];

        foreach($hotelGrades as $hotelGrade){
            $hotelGradeIDs[] = $hotelGrade->dict_hotel_grade_id;
        }

        if(count($hotelGradeIDs)==0) return '';

        $hotelGrades = CompanyHotelGrade::findAll(['quote_company_id' => $this->companyId, 'hotel_grade_id' => $hotelGradeIDs]);

        if(is_null($hotelGrades)) return '';

        return '&star_rating=' . urlencode(implode(',', ArrayHelper::map($hotelGrades, 'hotel_grade_id', 'service_hotel_grade_id')));
    }


    protected function parseForm()
    {
        $patternHtml = '#"search-results-list"(.*?)<footer#s';
        $html = $this->parseElement($patternHtml, $this->resultPage, 'Resorts container');

        return $this->parseResortBlock($html);
    }

    protected function parseResortBlock($content){
        $patternResorts = '#search-result a-link"(.*?)class="\s?grid-12#s';
        $patternHotel = '#<h2><strong>(.*?)<\/strong#s';
        $patternResort = '#<br>(.*?)<\/h2#s';
        $patternImage = '#<div[^>]*?class="search-result-img".*?background:url\((.*?)\)#s';
        $patternDetailUrl = '#<p[^>]*?class="more-button"[^>]*?><a href="(.*?)"#s';
        $patternPrice = '#<strong>&pound;(.*?)<\/strong>#s';
        $patternDescription = '#<p class="description">(.*?)<\/p>#s';
        $patternInfoBlock = '#<p class="durdate">\s?<span>(.*?)<\/span>\s?<span>(.*?)<\/span>\s?<span>(.*?)<\/span>\s?<span>(.*?)<\/span><\/p>#s';

        if(preg_match_all($patternResorts, $content, $matches)){
            if(isset($matches[1]) && is_array($matches[1])){
                for($i=0; $i<count($matches[1]); $i++){
                    $info = [];
                    $resort = $matches[1][$i];

                    $hotelName = $this->parseElement($patternHotel, $resort, 'Hotel name');
                    $resortName = $this->parseElement($patternResort, $resort, 'Resort name');
                    $imageUrl = $this->getRealImageUrl($this->parseElement($patternImage, $resort, 'Image url'));
                    $detailUrl = $this->parseElement($patternDetailUrl, $resort, 'Detail url');
                    $price = $this->parseElement($patternPrice, $resort, 'Price');
                    $description = $this->parseElement($patternDescription, $resort, 'Description');
                    $infoBlock = $this->parseRows($patternInfoBlock, $resort);

                    $hotelStar = 0;
                    foreach($infoBlock as $key=>$value){
                        if(strpos($value[0], $this->hotelFullStar) === false){
                            $info[] = strip_tags($value[0]);
                        }else{
                            $hotelStar = $this->getHotelStar($value[0]);
                        }
                    }

                    $this->parsedData->addResort($hotelName, $resortName, $imageUrl, $detailUrl, $price, $hotelStar,
                        $description, $info);

                }
            }
        };

        return count($this->parsedData->resorts)>0;
    }

    protected function getHotelStar($block){
        $stars = substr_count($block, $this->hotelFullStar);

        if(substr_count($block, $this->hotelHalfStar)==1){
            $stars = $stars-0.5;
        }

        return $stars;
    }

    protected function getRealImageUrl($url){
        $pattern = '#https:\/\/stewarttravel\.imgix\.net\/(.*?)\?#';

        $realUrl =  $this->parseElement($pattern, $url, 'Image real url');
        if(!$realUrl) return $url;

        return urldecode($realUrl);
    }
}