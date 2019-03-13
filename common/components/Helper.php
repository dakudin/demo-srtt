<?php
/**
 * Created by PhpStorm.
 * User: Monk
 * Date: 18.09.17
 * Time: 15:44
 */

namespace common\components;

use common\models\InstantQuote;
use common\models\QuoteCompany;
use common\models\TravelQuote;
use yii\helpers\Html;
use yii\helpers\Url;

class Helper {
	const REGEXP_POSTCODE = "/[A-Za-z]{1,2}[0-9][0-9A-Za-z]?\s?([0-9][A-Za-z]{2})?/"; //"/^([A-PR-UWYZ]([0-9]{1,2}|([A-HK-Y][0-9]([0-9ABEHMNPRV-Y])?)|[0-9][A-HJKPS-UW]) ?[0-9][ABD-HJLNP-UW-Z]{2})$/i";
	const REGEXP_PHONE = "/^\+?[0-9()\s-]{6,20}$/";

	const QUOTE_CONFIRMATION_TEXT = 'I confirm acceptance of the Terms and Conditions, Privacy and Cookies policies and for my details to be passed on to selected suppliers who will contact me directly by phone or email to provide personalised quotes.';

	static function getQuotePriceForView($amount){
		return $amount==0 ? 'Included' : '&pound;' . number_format($amount,2);
	}

	static function getQuoteMarketingConsent(){
		return 'I consent to sortit.com using my details to send marketing information by email. For more information on how your personal details will be used, please refer to our Privacy Policy'
//			. Html::a('Privacy Policy', Url::to(['privacy-policy'], ['target' => 'privacyAndCookies']))
			. ' and Cookie Policy.';
	}

	static function getInstantConveyancingInfoById($id){
		$text = 'I am looking to';

		$quoteResult = InstantQuote::find()->where(['id' => $id])->one();

		if($quoteResult){
			if($quoteResult->type == InstantQuote::TYPE_BUY || $quoteResult->type == InstantQuote::TYPE_BUY_N_SELL){
				$text .= ' <span class="term-text">Buy</span>';

				if($quoteResult->property_type == InstantQuote::FREEHOLD) $text .= '<span class="term-text"> Freehold';
				else $text .= '<span class="term-text"> Leasehold';
				if($quoteResult->is_new_build == 1) $text .= ' New build';
				$text .= ' property</span>';

				if($quoteResult->has_buying_mortgage == 1) $text .= '<span class="term-text"> with';
				else $text .= '<span class="term-text"> without';
				$text .= ' mortgage</span> in <span class="term-text">' . $quoteResult->buying_postcode . '</span> postcode';
			}

			if($quoteResult->type == InstantQuote::TYPE_BUY_N_SELL){
				$text .= ' and ';
			}

			if($quoteResult->type == InstantQuote::TYPE_SELL || $quoteResult->type == InstantQuote::TYPE_BUY_N_SELL){
				$text .= ' <span class="term-text">Sell</span>';

				if($quoteResult->selling_property_type == InstantQuote::FREEHOLD) $text .= '<span class="term-text"> Freehold';
				else $text .= '<span class="term-text"> Leasehold';
				$text .= ' property</span>';

				if($quoteResult->has_selling_mortgage == 1) $text .= '<span class="term-text"> with';
				else $text .= '<span class="term-text"> without';
				$text .= ' mortgage</span> in <span class="term-text">' . $quoteResult->selling_postcode . '</span> postcode';
			}

			if($quoteResult->type == InstantQuote::TYPE_REMORTGAGE){
				$text .= ' <span class="term-text">Remortgage</span>';

				if($quoteResult->remortgage_property_type == InstantQuote::FREEHOLD) $text .= '<span class="term-text"> Freehold';
				else $text .= '<span class="term-text"> Leasehold';
				$text .= ' property</span>  in <span class="term-text">' . $quoteResult->remortgage_postcode . '</span> postcode';

				if($quoteResult->transfer_of_enquity == 1) $text .= ' with <span class="term-text">transfer of enquity</span>';
			}
		}

		return $text;

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

	static function isShowSendEnquiryButton($companyId)
	{
		return $companyId == QuoteCompany::$SkiKingsCompany;
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
						$company['rated'] = $parsedResult->companyRatingSet;

					$companies[$parsedResult->companyId] = $company;
				}
			}
		}

		return $companies;
	}

}