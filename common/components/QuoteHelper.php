<?php
/**
 * Created by Kudin Dmitry
 * Date: 16.03.2019
 * Time: 10:18
 */

namespace common\components;

use common\models\CompanyRating;
use common\models\TravelQuote;

class QuoteHelper
{
    const QUOTE_CONFIRMATION_TEXT = 'I confirm acceptance of the Terms and Conditions, Privacy and Cookies policies and for my details to be passed on to selected suppliers who will contact me directly by phone or email to provide personalised quotes.';

    const QUOTE_RATED = 1;
    const QUOTE_NOT_RATED = 0;

    const QUOTE_RATE_EMAIL_SENT = 1;
    const QUOTE_RATE_EMAIL_NOT_SENT = 0;

    static function getQuotePriceForView($amount){
        return $amount==0 ? 'Included' : '&pound;' . number_format($amount,2);
    }

    static function getQuoteMarketingConsent(){
        return 'I consent to sortit.com using my details to send marketing information by email. For more information on how your personal details will be used, please refer to our Privacy Policy'
//			. Html::a('Privacy Policy', Url::to(['privacy-policy'], ['target' => 'privacyAndCookies']))
        . ' and Cookie Policy.';
    }

    static function getTravelQuoteInfoById(TravelQuote $quote){
        $text = 'Leaving on ';

        if(!is_null($quote->date))
            $text .= '<span class="term-text">' . $quote->date . '</span>';
        else
            $text .= ' <span class="term-text">any time</span>';

        if(!is_null($quote->duration) && $quote->duration!=0)
            $text .= ' <span class="term-text">'.$quote->duration . ' nights</span>';

        if(!is_null($quote->passengers))
            $text .= ' for <span class="term-text">'.$quote->passengers . '</span> people';

        if(!empty($quote->dictAirports)) {
            $text .= '. Flying from ' . $quote->dictAirports[0]->name;
        }

        return $text;
    }

    static function getTravelQuoteHeader(TravelQuote $quote){
        if(!empty($quote->dictResorts) && count($quote->dictResorts)==1){
            return $quote->dictResorts[0]->name;
        }elseif(!empty($quote->dictCountries) && count($quote->dictCountries)==1){
            return $quote->dictCountries[0]->name;
        }

        return 'Traveling';
    }

    static function getRetailersInfoByEnquiryResult($parsedResult)
    {
        $companies = [];

        $parsedResults = unserialize($parsedResult);
        if(is_array($parsedResults)) {
            foreach ($parsedResults as $parsedResult) {
                if(!empty($parsedResult->companyId)) {
                    $company = [];
                    if(!empty($parsedResult->companyName))
                        $company['name'] = $parsedResult->companyName;
                    if(!empty($parsedResult->companyUrl))
                        $company['image'] = $parsedResult->companyUrl;
                    if(!empty($parsedResult->companyRating))
                        $company['rated'] = $parsedResult->companyRating;

                    $companies[$parsedResult->companyId] = $company;
                }
            }
        }

        return $companies;
    }

    static function rateRetailersForEnquiry($quote, $retailerIDs)
    {
        if(gettype($quote) !== 'object' || is_null($quote->is_rated) || empty($quote->parsed_results) || empty($retailerIDs))
            return false;

        // the quote has already rated
        if($quote->is_rated == self::QUOTE_RATED || !is_array($retailerIDs))
            return false;

        //save rating and update quote parsed result
        $parsedResults = unserialize($quote->parsed_results);
        if(is_array($parsedResults)) {

            $transaction = \Yii::$app->db->beginTransaction();

            try{
                foreach ($parsedResults as $key=>$parsedResult) {
                    if(empty($parsedResult->companyId))
                        continue;

                    if(!array_key_exists($parsedResult->companyId, $retailerIDs))
                        continue;

                    $companyRating = new CompanyRating();
                    $companyRating->quote_company_id = $parsedResult->companyId;
                    $companyRating->travel_quote_id = $quote->id;
                    $companyRating->rating = $retailerIDs[$parsedResult->companyId];

                    if(!$companyRating->save()) {
                        $transaction->rollBack();
                        return false;
                    }

                    $parsedResult->companyRating = $companyRating->rating;
                    $parsedResults[$key] = $parsedResult;
                }

                $quote->is_rated = self::QUOTE_RATED;
                $quote->parsed_results = serialize($parsedResults);
                if(!$quote->save(true, ['parsed_results', 'is_rated'])){
                    $transaction->rollBack();
                    return false;
                }

                $transaction->commit();
                return true;

            }catch (\Exception $e){
                $transaction->rollBack();
                return false;
            }
        }

        return false;
    }


}