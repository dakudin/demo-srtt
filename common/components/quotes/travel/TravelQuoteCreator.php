<?php
/**
 * Created by Kudin Dmitry
 * Date: 09.10.2017
 * Time: 19:13
 */

namespace common\components\quotes\travel;

use common\components\quotes\travel\bestattravel\BestAtTravelQuote;
use common\components\quotes\travel\designtravel\DesignTravelQuote;
use common\components\quotes\travel\travelcounsellors\TravelCounsellorsQuote;
use common\models\TravelQuoteCountry;
use Yii;
//use common\components\quotes\travel\quoni\QuoniQuote;
use common\components\quotes\travel\ski\skikings\SkiKingsQuote;
use common\components\quotes\travel\ski\inghams\InghamsQuote;
use common\components\quotes\travel\ski\skisolutions\SkiSolutionQuote;
use common\components\quotes\travel\eshores\EShoresQuote;
use common\components\quotes\travel\flightcentre\FCentreTravelQuote;
use common\models\TravelQuote;
use common\models\QuoteCompany;
//use common\models\Category;
//use common\models\CompanyCountry;
//use common\models\CompanyAirport;
//use common\models\CompanyResort;
//use common\models\CompanyBoardBasis;
//use common\models\CompanyHotelGrade;

class TravelQuoteCreator extends \yii\base\Component
{
    /**
     * @var TravelQuote
     */
    protected $quote;

    protected $quoteResults;

    protected $quoteInfo;

    public function createQuote(TravelQuote $quote, $sendRealQuote){
        $this->quoteResults = [];
        $this->quoteInfo = [];

        if(is_a($quote, 'common\models\TravelQuote')){
            $this->quote = $quote;
        }

        $this->fillQuoteInfo();

        $this->createRemoteQuote($sendRealQuote);

        // detect companies for which enquiry was sent
        $companies = $this->getCompaniesWhichSentRequest();

        if(!empty($companies)) {
            $email = Yii::$app->mailer->compose()
                ->setFrom(Yii::$app->params['enquiryEmailSendFrom'])
                ->setTo(Yii::$app->params['enquiryEmailSendTo']);

            if (!empty(Yii::$app->params['enquiryEmailSendToBcc']))
                $email->setBcc(Yii::$app->params['enquiryEmailSendToBcc']);

            $email->setSubject('New enquiry')
                ->setTextBody($this->getQuoteMailText())
                ->setHtmlBody($this->getQuoteMailHtml())
                ->send();

            $this->sendQuoteInfoToResistant($companies);
        }

        return true;
    }

    /**
     * Send an auto email to go to the resistant
     * $companies array Companies for which enquiry was sent
     * @return bool
     */
    protected function sendQuoteInfoToResistant($companies){
        return Yii::$app->mailer->compose(
            ['html' => 'quoteInfoResistant-html', 'text' => 'quoteInfoResistant-text'],
            ['quote' => $this->quote, 'companies' => $companies]
        )
        ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
        ->setTo($this->quote->email)
        ->setSubject('New enquiry')
        ->send();
    }

    public function getCompaniesWhichSentRequest()
    {
        $companies = [];

        $parsedResults = unserialize($this->quote->parsed_results);
        if(is_array($parsedResults)) {
            foreach ($parsedResults as $parsedResult) {
                if (is_a($parsedResult, 'common\components\quotes\travel\TravelParsedResult')) {
                    $companies[$parsedResult->companyId] = [
                        'name' => $parsedResult->companyName,
                        'rating' => null,
                        'reviews' => null,
                    ];
                }
            }
        }

        $allCompanies = QuoteCompany::getCompaniesWithRatingByCategory($this->quote->category_id);
        foreach($allCompanies as $company){
            if(array_key_exists($company['id'], $companies)){
                $companies[$company['id']]['rating'] = $company['rating'];
                $companies[$company['id']]['reviews'] = $company['reviews'];
            }
        }


        return $companies;
    }

    protected function createRemoteQuote($sendRealQuote){
        $retailers = $this->quote->retailers;
        foreach($retailers as $retailer){
            // if quote company was selected by user then make an enquiry
            if(array_key_exists($retailer->id, $this->quote->quoteCompanyIDs))
                $this->createQuoteByCompany($retailer->method_name, $retailer->id, $sendRealQuote);
        }

        // store parsed info in quote
        $this->addResultsToQuote();
    }

    /**
     * Create quote for enquiry company
     * @param $methodNameForQuoteCreating
     */
    protected function createQuoteByCompany($methodNameForQuoteCreating, $companyId, $sendRealQuote){
        $this->$methodNameForQuoteCreating($companyId, $sendRealQuote);
    }

    public function getQuoteTextInfo()
    {
        return $this->getQuoteMailHtml();
    }

    protected function fillQuoteInfo()
    {
        $this->quoteInfo = [];

        $category = $this->quote->enquiryCategory;
        $message = 'Need a perfect ' . $category->name . ' quote';
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
    protected function createQuoteDesignTravel($companyId, $sendRealQuote){
        $quote = new DesignTravelQuote($this->quote, $companyId, $sendRealQuote);

        if($quote->MakeQuote()){
            $this->quoteResults[] = $quote->parsedData;
        }
    }

    /*
     * Create remote quote on TravelCounsellors site
     */
    protected function createQuoteTravelCounsellors($companyId, $sendRealQuote){
        $quote = new TravelCounsellorsQuote($this->quote, $companyId, $sendRealQuote);

        if($quote->MakeQuote()){
            $this->quoteResults[] = $quote->parsedData;
        }
    }

    /*
     * Create remote quote on eShores site
     */
    protected function createQuoteEShores($companyId, $sendRealQuote){
        $quote = new EShoresQuote($this->quote, $companyId, $sendRealQuote);

        if($quote->MakeQuote()){
            $this->quoteResults[] = $quote->parsedData;
        }
    }

    /*
     * Create remote quote on FlightCentre site
     */
    protected function createQuoteFlightCentre($companyId, $sendRealQuote){
        $quote = new FCentreTravelQuote($this->quote, $companyId, $sendRealQuote);

        if($quote->MakeQuote()){
            $this->quoteResults[] = $quote->parsedData;
        }
    }

    /*
     * Create remote quote on BestAtTravel site
     */
    protected function createQuoteBestAtTravel($companyId, $sendRealQuote){
        $quote = new BestAtTravelQuote($this->quote, $companyId, $sendRealQuote);

        if($quote->MakeQuote()){
            $this->quoteResults[] = $quote->parsedData;
        }
    }

    /*
     * Create remote quote on SkiKings site
     */
    protected function createQuoteSkiKings($companyId, $sendRealQuote){
        $quote = new SkiKingsQuote($this->quote, $companyId, $sendRealQuote);

        if($quote->MakeQuote()){
            $this->quoteResults[] = $quote->parsedData;
        }
    }

    /*
     * Create remote quote on Inghams site
     */
    protected function createQuoteInghams($companyId, $sendRealQuote){
        $quote = new InghamsQuote($this->quote, $companyId, $sendRealQuote);

        if($quote->MakeQuote()){
            $this->quoteResults[] = $quote->parsedData;
        }
    }

    /*
     * Create remote quote on Ski Solutions site
     */
    protected function createQuoteSkiSolutions($companyId, $sendRealQuote){
        $quote = new SkiSolutionQuote($this->quote, $companyId, $sendRealQuote);

        if($quote->MakeQuote()){
            $this->quoteResults[] = $quote->parsedData;
        }
    }

    /*
     * Create remote quote on Quoni site
     */
/*    protected function createQuoteQuoni(){
        $quote = new QuoniQuote($this->quote);

        if($quote->MakeQuote()){
            $this->quoteResults[] = $quote->parsedData;
        }
    }*/

    protected function addResultsToQuote(){
        $this->quote->parsed_results = serialize($this->quoteResults);
        $this->quote->update(false, ['parsed_results']);
    }
}