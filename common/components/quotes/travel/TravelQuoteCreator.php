<?php
/**
 * Created by Kudin Dmitry
 * Date: 09.10.2017
 * Time: 19:13
 */

namespace common\components\quotes\travel;

use common\components\quotes\travel\designtravel\DesignTravelQuote;
use common\components\quotes\travel\travelcounsellors\TravelCounsellorsQuote;
use common\models\TravelQuoteCountry;
use Yii;
use common\components\quotes\travel\quoni\QuoniQuote;
use common\components\quotes\travel\ski\skikings\SkiKingsQuote;
use common\components\quotes\travel\eshores\EShoresQuote;
use common\models\TravelQuote;
use common\models\Category;
use common\models\CompanyCountry;
use common\models\CompanyAirport;
use common\models\CompanyResort;
use common\models\CompanyBoardBasis;
use common\models\CompanyHotelGrade;

class TravelQuoteCreator extends \yii\base\Component
{

    /**
     * @var TravelQuote
     */
    protected $quote;

    protected $quoteResults;

    protected $quoteInfo;

    public function createQuote(TravelQuote $quote){
        $this->quoteResults = [];
        $this->quoteInfo = [];

        if(is_a($quote, 'common\models\TravelQuote')){
            $this->quote = $quote;
        }

        $this->fillQuoteInfo();

//!!!!!        $this->createRemoteQuote();

        Yii::$app->mailer->compose()
            ->setFrom('enquiry@demosortit.com')
            ->setTo('dakudin@gmail.com')
//            ->setTo('charlie.hollinrake@gmail.com')
//            ->setBcc(['dakudin@gmail.com','belchev2007@gmail.com'])
            ->setSubject('New enquiry')
            ->setTextBody($this->getQuoteMailText())
            ->setHtmlBody($this->getQuoteMailHtml())
            ->send();

        $this->sendQuoteInfoToResistant();

        return true;
    }

    /**
     * Send an auto email to go to the resistant
     * @return bool
     */
    protected function sendQuoteInfoToResistant(){
        $companies = [];
        $parsedResults = unserialize($this->quote->parsed_results);
        if(is_array($parsedResults)) {
            foreach ($parsedResults as $parsedResult) {
                if (is_a($parsedResult, 'common\components\quotes\travel\TravelParsedResult')) {
                    $companies[] = $parsedResult->companyName;
                }
            }
        }


        return Yii::$app->mailer->compose(
            ['html' => 'quoteInfoResistant-html', 'text' => 'quoteInfoResistant-text'],
            ['quote' => $this->quote, 'companies' => $companies]
        )
        ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
        ->setTo($this->quote->email)
        ->setSubject('New enquiry')
        ->send();
    }

    protected function createRemoteQuote(){
        if($this->quote->category_id == Category::SKI) {
            // create quote on `eShores`
//            $this->createQuoteEShores();
        }

        if($this->quote->category_id == Category::LUXURY) {
            // create quote on `eShores`
            $this->createQuoteEShores();

            //create quote on `Design Travel`
            $this->createQuoteDesignTravel();

            //create quote on `Travel Counsellors`
            $this->createQuoteTravelCounsellors();
        }

        // store parsed info in quote
        $this->addResultsToQuote();

    }

    public function getQuoteTextInfo()
    {
        return $this->getQuoteMailHtml();
    }

    protected function fillQuoteInfo()
    {
        $this->quoteInfo = [];

        $message = '';
        if($this->quote->category_id == Category::SKI) {
            $message = 'Need a perfect skiing holidays';
        }elseif($this->quote->category_id == Category::LUXURY) {
            $message = 'Need a perfect beach quote';
        }
        $this->quoteInfo[] = $message;

        $this->quoteInfo[] = 'User : ' . $this->quote->getUserFullName();
        $this->quoteInfo[] = 'User email: ' . $this->quote->email;
        $this->quoteInfo[] = 'User phone: ' . $this->quote->phone;

        $arr = $this->quote->getQuoteInfoByFields([
            TravelQuote::USER_ADDRESS_FIELD,
            TravelQuote::COUNTRY_TEXT_FIELD,
            TravelQuote::CITY_TEXT_FIELD,
            TravelQuote::AIRPORT_TEXT_FIELD,
            TravelQuote::FLIGHT_CATEGORY_TEXT_FIELD,
            TravelQuote::DEPARTURE_DATE_TEXT_FILED,
            TravelQuote::DURATION_TEXT_FIELD ,
            TravelQuote::TOTAL_BUDGET_TEXT_FIELD,
            TravelQuote::ROOMS_TEXT_FIELD,
            TravelQuote::DETAIL_TEXT_FIELD,
        ]);

        $this->quoteInfo = array_merge($this->quoteInfo, $arr);
    }

    protected function getQuoteMailText()
    {
        $message = '';
        foreach($this->quoteInfo as $item){
            $message .= $item . "\r\n";
        }

        return $message;
    }

    protected function getQuoteMailHtml()
    {
        $message = '';
        foreach($this->quoteInfo as $item){
            $message .= '<p>' . htmlspecialchars($item) . '</p>';
        }

        return $message;
    }

    protected function getQuoteResistantMailText()
    {
        return $this->getQuoteMailText();
    }

    protected function getQuoteResistantMailHtml()
    {
        return $this->getQuoteMailHtml();
    }

    /*
     * Create remote quote on DesignTravel site
     */
    protected function createQuoteDesignTravel(){
        $quote = new DesignTravelQuote($this->quote);

        if($quote->MakeQuote()){
            $this->quoteResults[] = $quote->parsedData;
        }
    }

    /*
     * Create remote quote on TravelCounsellors site
     */
    protected function createQuoteTravelCounsellors(){
        $quote = new TravelCounsellorsQuote($this->quote);

        if($quote->MakeQuote()){
            $this->quoteResults[] = $quote->parsedData;
        }
    }

    /*
     * Create remote quote on eShores site
     */
    protected function createQuoteEShores(){
        $quote = new EShoresQuote($this->quote);

        if($quote->MakeQuote()){
            $this->quoteResults[] = $quote->parsedData;
        }
    }

    /*
     * Create remote quote on SkiKings site
     */
    protected function createQuoteSkiKings(){
        $quote = new SkiKingsQuote($this->quote);

        if($quote->MakeQuote()){
            $this->quoteResults[] = $quote->parsedData;
        }
    }

    /*
     * Create remote quote on Quoni site
     */
    protected function createQuoteQuoni(){
        $quote = new QuoniQuote($this->quote);

        if($quote->MakeQuote()){
            $this->quoteResults[] = $quote->parsedData;
        }
    }

    protected function addResultsToQuote(){
        $this->quote->parsed_results = serialize($this->quoteResults);
        $this->quote->update(false, ['parsed_results']);
    }
}