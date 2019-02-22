<?php

namespace common\models;

use Yii;
use \common\components\Helper;

/**
 * This is the model class for table "travel_quote".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $date
 * @property integer $duration
 * @property integer $passengers
 * @property string $details
 * @property string $parsed_results
 * @property integer $category_id
 * @property integer $page_number
 * @property integer|array $regionIDs
 * @property integer|array $countryIDs
 * @property integer|array $resortIDs
 * @property integer|array $airportIDs
 * @property array $boardBasisIDs
 * @property array $hotelGradeIDs
 * @property string $room_info
 * @property array $room
 * @property array $quoteCompanyIDs
 * @property string $flight_category
 * @property string $email
 * @property string $phone
 * @property string $user_title
 * @property string $user_first_name
 * @property string $user_last_name
 * @property string $address_street
 * @property string $address_town
 * @property string $address_county
 * @property string $address_postcode
 * @property string $budget
 * @property string $country
 * @property string $city
 * @property string $airport
 *
 * @property string $userFullName
 * @property User $user
 * @property EnquiryCategory $enquiryCategory
 * @property QuoteCompany[] $retailers
 * @property TravelQuoteAirport[] $travelQuoteAirports
 * @property DictAirport[] $dictAirports
 * @property TravelQuoteCountry[] $travelQuoteCountries
 * @property DictCountry[] $dictCountries
 * @property TravelQuoteRegion[] $travelQuoteRegions
 * @property DictRegion[] $dictRegions
 * @property TravelQuoteResort[] $travelQuoteResorts
 * @property DictResort[] $dictResorts
 * @property TravelQuoteBoardBasis[] $travelQuoteBoardBasis
 * @property DictBoardBasis[] $dictBoardBasis
 * @property TravelQuoteHotelGrade[] $travelQuoteHotelGrade
 * @property DictHotelGrade[] $dictHotelGrade
 */

class TravelQuote extends \yii\db\ActiveRecord
{
    const USER_TITLE_MR = 'Mr';
    const USER_TITLE_MRS = 'Mrs';
    const USER_TITLE_MISS = 'Miss';
    const USER_TITLE_MS = 'Ms';

    const FLIGHT_ECONOMY = 'economy';
    const FLIGHT_PREMIUM = 'premium';
    const FLIGHT_BUSINESS = 'business';

    const USER_ADDRESS_FIELD = 'user_address';
//    const REGION_TEXT_FIELD = 'region';
    const COUNTRY_TEXT_FIELD = 'country';
    const CITY_TEXT_FIELD = 'city';
//    const RESORT_TEXT_FIELD = 'resort';
    const AIRPORT_TEXT_FIELD = 'airport';
    const FLIGHT_CATEGORY_TEXT_FIELD = 'flight_category';
    const DEPARTURE_DATE_TEXT_FILED = 'departure_date';
    const DURATION_TEXT_FIELD = 'duration';
    const TOTAL_BUDGET_TEXT_FIELD = 'total_budget';
    const ROOMS_TEXT_FIELD = 'rooms_info';
    const DETAIL_TEXT_FIELD = 'details';

    const DEFAULT_COUNTRY = 'Any country';
    const DEFAULT_CITY = 'Any region/city';
    const DEFAULT_AIRPORT = 'Any airport';

    const CHILDREN_MIN_AGE = 0;
    const CHILDREN_MAX_AGE = 12;
    const MIN_CHILD_COUNT = 0;
    const MAX_CHILD_COUNT = 9;
    const MIN_ADULTS_COUNT = 1;
    const MAX_ADULTS_COUNT = 12;

//    public $regionIDs;
//    public $countryIDs;
//    public $resortIDs;
//    public $airportIDs;
    public $boardBasisIDs;
    public $hotelGradeIDs;
    public $room;
    public $quoteCompanyIDs;



    /**
     * Initialization
     * Set default values
     * @return void
     */
    public function init()
    {
        parent::init();

        $user = User::findOne(['id' => Yii::$app->user->id]);
        if($user){
            $this->setAttributes([
                'email' => $user->contact_email,
                'phone' => $user->contact_phone,
                'user_title' => $user->user_title,
                'user_first_name' => $user->user_first_name,
                'user_last_name' => $user->user_last_name,
                'address_street' => $user->address_street,
                'address_town' => $user->address_town,
                'address_county' => $user->address_county,
                'address_postcode' => $user->address_postcode,
            ]);
        }
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'travel_quote';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'duration', 'passengers', 'category_id', 'page_number'], 'integer'],
            [['user_id'], 'default', 'value'=> Yii::$app->user->id],
            [['details', 'parsed_results', 'room_info', 'budget'], 'string'],
            [['date'], 'date', 'format' => 'd M Y'],
            ['duration', 'in', 'range'=> [3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42]],
            ['passengers', 'in', 'range'=> [0,1,2,3,4,5,6,7,8]],
            [['room', 'quoteCompanyIDs', 'regionIDs', 'countryIDs', 'resortIDs', 'airportIDs', 'boardBasisIDs', 'hotelGradeIDs'], 'safe'],
            [['user_id', 'category_id', 'page_number', 'user_title', 'flight_category', 'user_first_name', 'user_last_name', 'phone', 'email'], 'required'],
            [['airport','country','city', 'address_street', 'address_town', 'address_county'], 'string', 'max' => 100],
            ['user_title', 'in', 'range' => [self::USER_TITLE_MISS, self::USER_TITLE_MR, self::USER_TITLE_MRS, self::USER_TITLE_MS]],
            ['flight_category', 'in', 'range' => [self::FLIGHT_ECONOMY, self::FLIGHT_PREMIUM, self::FLIGHT_BUSINESS]],
            ['phone', 'match', 'pattern' => Helper::REGEXP_PHONE],
            [['address_postcode'], 'match', 'pattern' => Helper::REGEXP_POSTCODE],
            [['email'], 'string', 'max' => 255],
            ['phone', 'string', 'max' => 20],
            ['budget', 'string', 'max' => 120],
            ['email', 'email'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => EnquiryCategory::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Date',
            'duration' => 'Duration',
            'passengers' => 'Passengers',
            'details' => 'Details',
            'parsed_results' => 'Parsed Results',
            'category_id' => 'Category ID',
            'regionIDs' => 'Region',
            'countryIDs' => 'Country',
            'country' => 'Country',
            'city' => 'Region / City',
            'airport' => 'Airport',
            'resortIDs' => 'Resort',
            'airportIDs' => 'Airport',
            'flight_category' => 'Flight category',
            'boardBasisIDs' => 'Board basis',
            'hotelGradeIDs' => 'Hotel grade',
            'email' => 'Email address',
            'phone' => 'Telephone',
            'user_title' => 'Title',
            'user_first_name' => 'First name',
            'user_last_name' => 'Last name',
            'address_street' => 'Street name',
            'address_town' => 'Town',
            'address_county' => 'County',
            'address_postcode' => 'Postcode',
            'budget' => 'Total Budget (approx.)'
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }
/*
        if(empty($this->country)) {
            $this->country = self::DEFAULT_COUNTRY;
        }

        if(empty($this->city)) {
            $this->city = self::DEFAULT_CITY;
        }

        if(empty($this->airport)) {
            $this->airport = self::DEFAULT_AIRPORT;
        }
*/
        if(!empty($this->date)) {
            $date = \DateTime::createFromFormat('d M Y', $this->date);
            if($date !==  false) {
                $this->date = $date->format('Y-m-d');
            }
        }

        $this->user->setProfileInfoForFirstValues($this->email, $this->phone, $this->user_title, $this->user_first_name,
            $this->user_last_name, $this->address_street, $this->address_town, $this->address_county, $this->address_postcode
        );

        $this->fillRoomInfo();

        // remove -,) and spaces from phone
        if(!empty($this->phone)) $this->phone = str_replace(['-', ',', '(', ')', ' '], '', $this->phone);

        return true;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    private function fillRoomInfo()
    {
        if(!empty($this->room)) {
            $this->room_info = serialize($this->room);
        }
    }

    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        //delete old regions, countries, resorts, airports if update
        if(!$insert){
//            TravelQuoteAirport::deleteAllByTravelQuote($this->id);
//            TravelQuoteCountry::deleteAllByTravelQuote($this->id);
//            TravelQuoteRegion::deleteAllByTravelQuote($this->id);
//            TravelQuoteResort::deleteAllByTravelQuote($this->id);
            TravelQuoteBoardBasis::deleteAllByTravelQuote($this->id);
            TravelQuoteHotelGrade::deleteAllByTravelQuote($this->id);
        }

        //add new regions, countries, resorts, airports
//        TravelQuoteAirport::addAirports($this->id, $this->airportIDs);
//        TravelQuoteRegion::addRegions($this->id, $this->regionIDs);
//        TravelQuoteCountry::addCountries($this->id, $this->countryIDs);
//        TravelQuoteResort::addResorts($this->id, $this->resortIDs);
        TravelQuoteBoardBasis::addBoardBasis($this->id, $this->boardBasisIDs);
        TravelQuoteHotelGrade::addHotelGrades($this->id, $this->hotelGradeIDs);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEnquiryCategory()
    {
        return $this->hasOne(EnquiryCategory::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRetailers()
    {
        return $this->hasMany(QuoteCompany::className(), ['id' => 'quote_company_id'])->viaTable('quote_company_category', ['enquiry_category_id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTravelQuoteAirports()
    {
        return $this->hasMany(TravelQuoteAirport::className(), ['travel_quote_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDictAirports()
    {
        return $this->hasMany(DictAirport::className(), ['id' => 'dict_airport_id'])->viaTable('travel_quote_airport', ['travel_quote_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTravelQuoteCountries()
    {
        return $this->hasMany(TravelQuoteCountry::className(), ['travel_quote_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDictCountries()
    {
        return $this->hasMany(DictCountry::className(), ['id' => 'dict_country_id'])->viaTable('travel_quote_country', ['travel_quote_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTravelQuoteRegions()
    {
        return $this->hasMany(TravelQuoteRegion::className(), ['travel_quote_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDictRegions()
    {
        return $this->hasMany(DictRegion::className(), ['id' => 'dict_region_id'])->viaTable('travel_quote_region', ['travel_quote_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTravelQuoteResorts()
    {
        return $this->hasMany(TravelQuoteResort::className(), ['travel_quote_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDictResorts()
    {
        return $this->hasMany(DictResort::className(), ['id' => 'dict_resort_id'])->viaTable('travel_quote_resort', ['travel_quote_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTravelQuoteBoardBasis()
    {
        return $this->hasMany(TravelQuoteBoardBasis::className(), ['travel_quote_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDictBoardBasis()
    {
        return $this->hasMany(DictBoardBasis::className(), ['id' => 'dict_board_basis_id'])->viaTable('travel_quote_board_basis', ['travel_quote_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTravelQuoteHotelGrade()
    {
        return $this->hasMany(TravelQuoteHotelGrade::className(), ['travel_quote_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDictHotelGrade()
    {
        return $this->hasMany(DictHotelGrade::className(), ['id' => 'dict_hotel_grade_id'])->viaTable('travel_quote_hotel_grade', ['travel_quote_id' => 'id']);
    }

    /**
     * @return array
     */
    public static function getListDuration()
    {
        $duration = [];
        for($i=3; $i<=42; $i++)
            $duration[$i] = $i;
        return $duration;
    }

    /**
     * @return array
     */
    public static function getListAdults()
    {
        return [1=>1, 2=>2, 3=>3, 4=>4, 5=>5, 6=>6, 7=>7, 8=>8];
    }
/*
    protected function fillDictionaryIDsAsInt($companyIDs){
        $this->airportIDs = 0;
        $this->regionIDs = 0;
        $this->countryIDs = 0;
        $this->resortIDs = 0;

        if(count($this->travelQuoteRegions)>0){
            $this->regionIDs = $this->travelQuoteRegions[0]->dict_region_id;
        }

        if(count($this->travelQuoteCountries)>0){
            $this->countryIDs = $this->travelQuoteCountries[0]->dict_country_id;
        }

        if(count($this->travelQuoteResorts)>0){
            $this->resortIDs = $this->travelQuoteResorts[0]->dict_resort_id;
        }

        if(count($this->travelQuoteAirports)>0){
            $this->airportIDs = $this->travelQuoteAirports[0]->dict_airport_id;
        }
    }
*/
/*
    public function fillDictionaryIDs($companyIDs){
        $this->boardBasisIDs = 0;
        $this->hotelGradeIDs = 0;

//        if($this->category_id == Category::SKI){
//            $this->fillDictionaryIDsAsInt($companyIDs);
//        }else {
//            $this->fillDictionaryIDsAsArray($companyIDs);
//        }

        $this->fillBoardBasisIDs($companyIDs);
        $this->fillHotelGradeIDs($companyIDs);
    }
*/
    public function setDefaultFilter(){
        $this->boardBasisIDs = 0;
        $this->hotelGradeIDs = 0;
        TravelQuoteBoardBasis::deleteAllByTravelQuote($this->id);
        TravelQuoteHotelGrade::deleteAllByTravelQuote($this->id);
    }


    /**
     * @param $companyIDs array
     */
/*
    protected function fillDictionaryIDsAsArray($companyIDs){
        $this->fillRegionIDs($companyIDs);
        $this->fillCountriesIDs($companyIDs);
        $this->fillResortsIDs($companyIDs);
        $this->fillAirportsIDs($companyIDs);
    }
*/
    /**
     * @param $companyIDs array
     */
/*
    protected function fillRegionIDs($companyIDs){
        $this->regionIDs = [];

        $regions = $this->travelQuoteRegions;
        //load selected regions
        if(count($regions)>0){
            foreach($regions as $region)
                $this->regionIDs[] = $region->dict_region_id;
        }
        //load all regions
        else{
            $regions = DictRegion::getRegionsByCompany($companyIDs);
            if(!empty($regions)) {
                foreach ($regions as $region)
                    $this->regionIDs[] = $region->id;
            }
        }
    }
*/
    /**
     * @param $companyIDs array
     */
/*
    protected function fillCountriesIDs($companyIDs){
        $this->countryIDs = [];

        //load selected countries
        $countries = $this->travelQuoteCountries;
        if(count($countries)>0){
            foreach($countries as $country)
                $this->countryIDs[] = $country->dict_country_id;
        }
        //load all countries
        else{
            $countries = DictCountry::getCountriesByCompany($companyIDs, $this->regionIDs);
            if(!empty($countries)) {
                foreach ($countries as $country)
                    $this->countryIDs[] = $country->id;
            }
        }
    }
*/
    /**
     * @param $companyIDs array
     */
/*
    protected function fillResortsIDs($companyIDs){
        $this->resortIDs = [];

        //load selected resorts
        $resorts = $this->travelQuoteResorts;
        if(count($resorts)>0){
            foreach($resorts as $resort)
                $this->resortIDs[] = $resort->dict_resort_id;
        }
        //load all resorts
        else{
            $resorts = DictResort::getResortsByCompany($companyIDs, $this->countryIDs);
            if(!empty($resorts)) {
                foreach ($resorts as $resort)
                    $this->resortIDs[] = $resort->id;
            }
        }
    }
*/
    /**
     * @param $companyIDs array
     */
/*
    protected function fillAirportsIDs($companyIDs){
        $this->airportIDs = [];

        //load selected airports
        $airports = $this->travelQuoteAirports;
        if(count($airports)>0){
            foreach($airports as $airport)
                $this->airportIDs[] = $airport->dict_airport_id;
        }
        //load all airports
        else{
            $airports = DictAirport::getAirportsByCompany($companyIDs);
            if(!empty($airports)) {
                foreach ($airports as $airport)
                    $this->airportIDs[] = $airport->id;
            }
        }
    }
*/
    /**
     * @param $companyIDs array
     */
    protected function fillBoardBasisIDs($companyIDs){
        $this->boardBasisIDs = [];

        //load selected boards basis
        $boardsBasis = $this->travelQuoteBoardBasis;
        if(count($boardsBasis)>0){
            foreach($boardsBasis as $boardBasis)
                $this->boardBasisIDs[] = $boardBasis->dict_board_basis_id;
        }
        //load all boards basis
        else{
            $boardsBasis = DictBoardBasis::getBoardBasisByCompany($companyIDs);
            if(!empty($boardsBasis)) {
                foreach ($boardsBasis as $boardBasis)
                    $this->boardBasisIDs[] = $boardBasis->id;
            }
        }
    }

    /**
     * @param $companyIDs array
     */
    protected function fillHotelGradeIDs($companyIDs){
        $this->hotelGradeIDs = [];

        //load selected hotel grades
        $hotelGrades = $this->travelQuoteHotelGrade;
        if(count($hotelGrades)>0){
            foreach($hotelGrades as $hotelGrade)
                $this->hotelGradeIDs[] = $hotelGrade->dict_hotel_grade_id;
        }
        //load all hotel grades
        else{
            $hotelGrades = DictHotelGrade::getHotelGradeByCompany($companyIDs);
            if(!empty($hotelGrades)) {
                foreach ($hotelGrades as $hotelGrade)
                    $this->hotelGradeIDs[] = $hotelGrade->id;
            }
        }
    }

    public static function getUserTitleList()
    {
        return [
            self::USER_TITLE_MR => self::USER_TITLE_MR,
            self::USER_TITLE_MRS => self::USER_TITLE_MRS,
            self::USER_TITLE_MISS => self::USER_TITLE_MISS,
            self::USER_TITLE_MS => self::USER_TITLE_MS,
        ];
    }

    public static function getFlightCategoryList()
    {
        return [
            self::FLIGHT_ECONOMY => ucfirst(self::FLIGHT_ECONOMY),
            self::FLIGHT_PREMIUM => ucfirst(self::FLIGHT_PREMIUM),
            self::FLIGHT_BUSINESS => ucfirst(self::FLIGHT_BUSINESS),
        ];
    }

    /**
     * @return string
     */
    public function getUserFullName()
    {
        return $this->user_title . ' ' . $this->user_first_name . ' ' . $this->user_last_name;
    }

    /**
     * @return string
     */
    protected function getQuoteUserAddress()
    {
        // address
        $userAddress = '';
        if(!empty($this->address_street)) {
            if(!empty($userAddress))
                $userAddress .= ', ';
            $userAddress .= $this->address_street;
        }
        if(!empty($this->address_town)) {
            if(!empty($userAddress))
                $userAddress .= ', ';
            $userAddress .= $this->address_town;
        }
        if(!empty($this->address_county)) {
            if(!empty($userAddress))
                $userAddress .= ', ';
            $userAddress .= $this->address_county;
        }
        if(!empty($this->address_postcode)) {
            if(!empty($userAddress))
                $userAddress .= ', ';
            $userAddress .= $this->address_postcode;
        }

        return 'User address: ' . $userAddress;
    }

    /**
     * @return string
     */
    protected function getQuoteRegionCityText()
    {
        $message = 'Region / City: ';
        if(!empty($this->city)) {
            $message .= $this->city;
        }else{
            $message .= 'Any';
        }

        return $message;
    }

    /**
     * @return string
     */
    protected function getQuoteCountryText()
    {
        //countries list
        $message = 'Countries: ';
        if(!empty($this->country)) {
            $message .= $this->country;
        }else{
            $message .= 'Any';
        }

        return $message;
    }

    /**
     * @return string
     */
/*
    protected function getQuoteResortText()
    {
        //resorts list
        $message = 'Resorts: ';
        $resorts = $this->dictResorts;
        if(count($resorts)>0) {
            foreach($resorts as $resort){
                $message .= $resort->name . ', ';
            }
            $message = trim($message, ' ,');
        }else{
            $message .= 'Any';
        }

        return $message;
    }
*/
    /*
     *
     */
    protected function getQuoteFlyingFromText()
    {
        //airports list
        $message = 'Flying from: ';
        if(!empty($this->airport)) {
            $message .= $this->airport;
        }else{
            $message .= 'Any';
        }

        return $message;
    }

    /**
     * @return string
     */
    protected function getQuoteFlightCategoryText()
    {
        return 'Flight category: ' . ucfirst($this->flight_category);
    }

    /**
     * @return string
     */
    protected function getDepartureDateText()
    {
        $message = 'Departure date: ';
        if(!empty($this->date)){
            $message .= $this->date;
        }else{
            $message .= 'Anytime';
        }

        return $message;
    }

    /**
     * @return string
     */
    protected function getDurationText()
    {
        $message = 'Nights: ';
        if (!empty($this->duration)) {
            $message .= $this->duration;
        } else {
            $message .= 'Any';
        }

        return $message;
    }

    /**
     * @return string
     */
    protected function getTotalBudgetText()
    {
        return (empty($this->budget)) ? '' : 'Total Budget: ' . $this->budget;
    }

    /**
     * @return string
     */
    protected function getRoomInfoText()
    {
        $rooms = unserialize($this->room_info);
        $roomNumber = 0;
        $message = '';
        foreach ($rooms as $room) {
            $roomNumber++;
            $message .= 'Room ' . $roomNumber . ' (Adults: ' . $room['adult'];
            if ($room['child'] > 0) {
                $message .= ', Children: ' . $room['child'] . ' ages(' . implode($room['childage'], ', ') . ')';
            }
            $message .= '); ';
        }

        return $message;
    }

    /**
     * @return array
     */
    public function getAdultsChildAgesInfo()
    {
        $rooms = unserialize($this->room_info);

        $result = [
            'adultsCount' => 0,
            'childrenCount' => 0,
            'childAges' => []
        ];

        foreach ($rooms as $room) {
            $result['adultsCount'] += (int)$room['adult'];

            if ($room['child'] > 0) {
                $result['childrenCount'] += (int)$room['child'];
                foreach($room['childage'] as $age)
                    $result['childAges'][] = (int)$age;
            }
        }

        return $result;
    }

    /**
     * @return string
     */
    protected function getDetailText()
    {
        return (empty($this->details)) ? '' : 'Details: ' . $this->details;
    }

    /**
     * @return array
     */
    public function getQuoteInfoByFields($fields)
    {
        $quoteInfo = [];

        foreach($fields as $field){
            switch ($field){
                case self::COUNTRY_TEXT_FIELD :
                    $quoteInfo[] = $this->getQuoteCountryText();
                    break;
                case self::CITY_TEXT_FIELD :
                    $quoteInfo[] = $this->getQuoteRegionCityText();
                    break;
                case self::AIRPORT_TEXT_FIELD :
                    $quoteInfo[] = $this->getQuoteFlyingFromText();
                    break;
                case self::FLIGHT_CATEGORY_TEXT_FIELD :
                    $quoteInfo[] = $this->getQuoteFlightCategoryText();
                    break;
                case self::DEPARTURE_DATE_TEXT_FILED :
                    $quoteInfo[] = $this->getDepartureDateText();
                    break;
                case self::DURATION_TEXT_FIELD :
                    $quoteInfo[] = $this->getDurationText();
                    break;
                case self::TOTAL_BUDGET_TEXT_FIELD :
                    $quoteInfo[] = $this->getTotalBudgetText();
                    break;
                case self::ROOMS_TEXT_FIELD :
                    $quoteInfo[] = $this->getRoomInfoText();
                    break;
                case self::DETAIL_TEXT_FIELD :
                    $quoteInfo[] = $this->getDetailText();
                    break;
                case self::USER_ADDRESS_FIELD :
                    $quoteInfo[] = $this->getQuoteUserAddress();
                    break;
            }
        }

        return $quoteInfo;
    }

}
