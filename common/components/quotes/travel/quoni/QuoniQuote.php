<?php
/**
 * Created by Kudin Dmitry.
 * Date: 19.10.2017
 * Time: 12:32
 */

namespace common\components\quotes\travel\quoni;

use common\components\quotes\travel\TravelQuoteBase;
use common\models\CompanyBoardBasis;
use common\models\CompanyHotelGrade;
use common\models\TravelQuote;
use common\models\Category;
use common\models\CompanyRegion;
use common\models\CompanyCountry;
use common\models\CompanyAirport;
use common\models\CompanyResort;
use common\models\TravelQuoteAirport;

class QuoniQuote extends TravelQuoteBase
{
    protected $fieldDestinationSelected = 'SELDST';
    /**
     * The associated array containing full form fields values
     */
    protected $formFields = [

        'TRANSD' => '01',

        'NRNTSD' => 0, // Duration in days count: 0 - Any; 3,4,5,6,7,8,9,10,11,12,13,14,15,16 days

        'DPDMYD' => '', // departure date '31/10/2017'

        //Price per person
//        'PPERFD' => 0,
//        'PPERTD' => 99999,
        'PPERFD' => 0,
        'PPERTD' => 99999,

        //airports
        'APL000' => 'on', //London All
        'APL001' => 'LHR', //London Heathrow
        'APL002' => 'LGW', //London Gatwick
        'APL003' => 'LTN', //London Luton
        'APL004' => 'STN', //London Stansted
        'APL005' => 'LCY', //London City
        'APO000' => 'on', //Other
        'APO001' => 'BHX', //Birmingham
        'APO002' => 'EDI', //Edinburgh
        'APO003' => 'GLA', //Glasgow
        'APO004' => 'MAN', //Manchester
        'APO005' => 'NCL', //Newcastle

//        'SELDST' => '', // 1 if checkbox Destinations was selected


        'HTLS1D' => 1,
        'HTLS2D' => 1,

        //Hotel grade
        'HTGR1D' => 1, // 3 star
        'HTGR2D' => 1, // 4 star
        'HTGR3D' => 1, // 5 star

        //Board basis
        'MPLN5D' => 'RO', // Room only (RO)
        'MPLN1D' => 'RB', // Room & Breakfast (RB)
        'MPLN2D' => 'HB', // Half board (HB)
        'MPLN3D' => 'FB', // Full board (FB)
        'MPLN4D' => 'ALL', // All inclusive (ALL)

        'TURS0D' => 'on',
        'TURS1D' => 'CR',
        'TURS2D' => 'ET',
        'TURS3D' => 'FD',
        'TURS4D' => 'TN',
        'TURS5D' => 'SF',

//        'SSNIDD' => '', // <input type="hidden" name="SSNIDD" value="21587029" />
//        'CRSRTS' => '',
        'HTALLD' => '',
        'HTBCHD' => '',
        'HTBTQD' => '',
        'HTROMD' => '',
        'HTSPAD' => '',
        'HTUNID' => '',
        'HTWCLD' => '',
        'HTLAKD' => '',
        'HTFAMD' => '',
        'HTWEDD' => '',
        'HTSNWD' => '',

    ];

    protected $originalFormFields;

    /**
     * @param TravelQuote $quote
     */
    public function __construct(TravelQuote $quote){
        $this->companyId = 5;
        $this->categoryId = Category::LUXURY;
        $this->mainPageUrl = 'http://booking.kuoni.co.uk/';
        $this->formSenderSDKPath = dirname(__FILE__);
        $this->debug=true;
        $this->originalFormFields = $this->formFields;

        parent::__construct($quote);
    }

    protected function addResortToForm()
    {
        $resortIDs = [];
        $resorts = $this->quote->travelQuoteResorts;
        foreach($resorts as $resort){
            $resortIDs[] = $resort->dict_resort_id;
        }

        $resorts = CompanyResort::findAll(['quote_company_id' => $this->companyId, 'resort_id' => $resortIDs]);

        //do not use this service if resort is not in dictionary
        if(is_null($resorts)) return false;

        $this->formFields[$this->fieldDestinationSelected] = 1;
        foreach($resorts as $resort){
            $this->formFields[$resort->service_resort_id] = 1;
        }

        return true;
    }

    protected function addCountryToForm()
    {
        $countryIDs = [];
        $countries = $this->quote->travelQuoteCountries;
        foreach($countries as $country){
            $countryIDs[] = $country->dict_country_id;
        }

        $countries = CompanyCountry::findAll(['quote_company_id' => $this->companyId, 'country_id' => $countryIDs]);

        //do not use this service if country is not in dictionary
        if(is_null($countries)) return false;

        $this->formFields[$this->fieldDestinationSelected] = 1;
        $countryIDs = [];
        foreach($countries as $country){
            $countryIDs[] = $country->country_id;
            $this->formFields[$country->service_country_id] = 1;
        }

        //add resorts from this country
        $resorts = CompanyCountry::getCompanyServiceResortsID($this->companyId, $countryIDs);
        if(is_array($resorts)) {
            foreach ($resorts as $resort) {
                $this->formFields[$resort['service_resort_id']] = 1;
            }
        }

        return true;
    }

    protected function addRegionToForm()
    {
        $regionIDs = [];
        $regions = $this->quote->travelQuoteRegions;
        foreach($regions as $region){
            $regionIDs[] = $region->dict_region_id;
        }

        $regions = CompanyRegion::findAll(['quote_company_id' => $this->companyId, 'region_id' => $regionIDs]);

        //do not use this service if regions is not in dictionary
        if(is_null($regions)) return false;

        $this->formFields[$this->fieldDestinationSelected] = 1;
        $regionIDs = [];
        foreach($regions as $region) {
            $this->formFields[$region->service_region_id] = 1;
            $regionIDs[] = $region->region_id;
        }

        //add countries from this region
        $countries = CompanyRegion::getCompanyServiceCountriesID($this->companyId, $regionIDs);
        if(is_array($countries)) {
            foreach ($countries as $country) {
                $this->formFields[$country['service_country_id']] = 1;
            }
        }

        //add resorts from this region
        $countries = CompanyRegion::getCompanyServiceResortsID($this->companyId, $regionIDs);
        if(is_array($countries)) {
            foreach ($countries as $country) {
                $this->formFields[$country['service_resort_id']] = 1;
            }
        }

        return true;
    }

    /**
     * Prepare form for airport`s fields
     * @return bool
     */
    protected function addAirportToForm()
    {
        $airportIDs = [];
        $airports = $this->quote->travelQuoteAirports;
        foreach($airports as $airport){
            $airportIDs[] = $airport->dict_airport_id;
        }

        if(count($airportIDs)==0) return true;

        $airports = CompanyAirport::findAll(['quote_company_id' => $this->companyId, 'airport_id' => $airportIDs]);

        //do not use this service if airport is not in dictionary
        if(is_null($airports)) return false;

        $airportIDs = [];
        foreach($airports as $airport){
            $airportIDs[] = $airport->service_airport_id;
        }

        foreach($this->formFields as $key=>$value){
            if(strpos($key, 'APL') === FALSE && strpos($key, 'APO') === FALSE) continue;

            if(!in_array($key, $airportIDs))
                unset($this->formFields[$key]);
        }

        return true;
    }

    /**
     * Prepare form for board basis`s fields
     * @return bool
     */
    protected function addBoardBasisToForm()
    {
        $boardBasisIDs = [];
        $boardsBasis = $this->quote->travelQuoteBoardBasis;
        foreach($boardsBasis as $boardBasis){
            $boardBasisIDs[] = $boardBasis->dict_board_basis_id;
        }

        if(count($boardBasisIDs)==0) return true;

        $boardsBasis = CompanyBoardBasis::findAll(['quote_company_id' => $this->companyId, 'board_basis_id' => $boardBasisIDs]);

        //do not use this service if board basis is not in dictionary
        if(is_null($boardsBasis)) return false;

        $boardBasisIDs = [];
        foreach($boardsBasis as $boardBasis){
            $boardBasisIDs[] = $boardBasis->service_board_basis_id;
        }

        foreach($this->formFields as $key=>$value){
            if(strpos($key, 'MPLN') === FALSE) continue;

            if(!in_array($key, $boardBasisIDs))
                unset($this->formFields[$key]);
        }

        return true;
    }

    /**
     * Prepare form for hotel grade`s fields
     * @return bool
     */
    protected function addHotelGradeToForm()
    {
        $hotelGradeIDs = [];
        $hotelGrades = $this->quote->travelQuoteHotelGrade;
        foreach($hotelGrades as $hotelGrade){
            $hotelGradeIDs[] = $hotelGrade->dict_hotel_grade_id;
        }

        if(count($hotelGradeIDs)==0) return true;

        $hotelGrades = CompanyHotelGrade::findAll(['quote_company_id' => $this->companyId, 'hotel_grade_id' => $hotelGradeIDs]);

        //do not use this service if hotel grade is not in dictionary
        if(is_null($hotelGrades)) return false;

        $hotelGradeIDs = [];
        foreach($hotelGrades as $hotelGrade){
            $hotelGradeIDs[] = $hotelGrade->service_hotel_grade_id;
        }

        foreach($this->formFields as $key=>$value){
            if(strpos($key, 'HTGR') === FALSE) continue;

            if(!in_array($key, $hotelGradeIDs))
                unset($this->formFields[$key]);
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    protected function fillData()
    {
        if(!empty($this->quote->travelQuoteResorts)){
            if(!$this->addResortToForm()) return false;
        }elseif(!empty($this->quote->travelQuoteCountries)){
            if(!$this->addCountryToForm()) return false;
        }elseif(!empty($this->quote->travelQuoteRegions)){
            if(!$this->addRegionToForm()) return false;
        }

        if(!empty($this->quote->travelQuoteAirports)){
            if(!$this->addAirportToForm()) return false;
        }
        if(!empty($this->quote->travelQuoteHotelGrade)){
            if(!$this->addHotelGradeToForm()) return false;
        }
        if(!empty($this->quote->travelQuoteBoardBasis)){
            if(!$this->addBoardBasisToForm()) return false;
        }

        if(!empty($this->quote->date)){

            $date = \DateTime::createFromFormat('Y-m-d', $this->quote->date);
            if($date !== false)
                $this->formFields['DPDMYD'] = $date->format('d/m/Y');
        }

        if(!empty($this->quote->duration)){
            $this->formFields['NRNTSD'] = $this->quote->duration;
        }

        return true;
    }

    protected function getRequestPageUrl(){
        return $this->mainPageUrl . 'ob/x1hlpan2';
    }


    // Go to page http://www.skikings.co.uk/search/results.php
    protected function sendForm()
    {
/*
        $result = [
            'Response' => file_get_contents($this->formSenderSDKPath . '\response1.txt')
        ];
*/
        //get first result
        $result = $this->pageGetter->sendRequest($this->getRequestPageUrl(), 'GET', $this->originalFormFields);

        if($result['Status'] == "FAIL"){
            self::log($result['StatusDetails'] . "\r\n" . $result['Response']);
            return false;
        }

        if(!$this->isPageGood($result['Response'], '#Destinations:#', 'Error Page: Didn`t find required phrase `Destinations:`'))
            return false;

        //detect Session ID
        $sessionId = $this->parseElement('#<input\stype="hidden"\sname="SSNIDD"\svalue="(.*?)"#s', $result['Response'], 'Session ID');
        if(!$sessionId) return false;

        $this->prepareFieldsForFormSending($sessionId);

        //send form to site
        $result = $this->pageGetter->sendRequest($this->getRequestPageUrl(), 'GET', $this->formFields);

        if($result['Status'] == "FAIL"){
            self::log($result['StatusDetails'] . "\r\n" . $result['Response']);
            return false;
        }

        $this->resultPage = $result['Response'];

        return true;
    }

    protected function prepareFieldsForFormSending($sessionId)
    {
        $this->formFields['TRANSD'] = '02';

        $this->formFields['SSNIDD'] = $sessionId;
        $this->formFields['CRSRTS'] = '';
        unset($this->formFields['HTALLD']);
        unset($this->formFields['HTBCHD']);
        unset($this->formFields['HTBTQD']);
        unset($this->formFields['HTROMD']);
        unset($this->formFields['HTSPAD']);
        unset($this->formFields['HTUNID']);
        unset($this->formFields['HTWCLD']);
        unset($this->formFields['HTLAKD']);
        unset($this->formFields['HTFAMD']);
        unset($this->formFields['HTWEDD']);
        unset($this->formFields['HTSNWD']);
}

    protected function parseForm()
    {
        $patternHtml = '#"offerLeft"(.*?)class="toppag"#s';
        $html = $this->parseElement($patternHtml, $this->resultPage, 'Resorts container');

        return $this->parseResortBlock($html);
    }

    protected function parseResortBlock($content){
        $patternResorts = '#"offer">(.*?)<\/div><\/div><\/div>#s';
        $patternHotel = '#<a[^>]*?title="(.*?)"[^>]*?>#s';
        $patternResort = '#<p[^>]*?class="resort"[^>]*?>(.*?)<\/p>#s';
        $patternImage = '#class="panoramic"[^<]*?<img[^>]*?src="(.*?)"[^>]*?>#s';
        $patternDetailUrl = '#<a[^>]*?href="(.*?)"[^>]*?>#s';
        $patternPrice = '#<p class="price">.*?(\d{1,})<\/p>#s';
        $patternHotelStar = '#star(\d{1,3})\.#s';
        $patternInfoBlock = '#<p class="offDets">(.*?)<\/p>#s';

        if(preg_match_all($patternResorts, $content, $matches)){
            if(isset($matches[1]) && is_array($matches[1])){
                for($i=0; $i<count($matches[1]); $i++){
                    $resort = $matches[1][$i];

                    $hotelName = $this->parseElement($patternHotel, $resort, 'Hotel name');
                    $resortName = $this->parseElement($patternResort, $resort, 'Resort name');
                    $imageUrl = $this->mainPageUrl . $this->parseElement($patternImage, $resort, 'Image url');
                    $detailUrl = $this->parseElement($patternDetailUrl, $resort, 'Detail url');
                    $price = $this->parseElement($patternPrice, $resort, 'Price');
                    $infoBlock = $this->parseElement($patternInfoBlock, $resort, 'Info block');
                    $infoBlock = strip_tags(str_replace('<br />', ',', $infoBlock));
                    $info = explode(',', $infoBlock);

                    $hotelStar = $this->getHotelStar($this->parseElement($patternHotelStar, $resort, 'Hotel stars'));

                    $this->parsedData->addResort($hotelName, $resortName, $imageUrl, $detailUrl, $price, $hotelStar,
                        '', $info);

                }
            }
        };

        return count($this->parsedData->resorts)>0;
    }

    protected function getHotelStar($block){
        return (int)$block/10;
   }

}