<?php
/**
 * Created by Kudin Dmitry
 * Date: 18.09.17
 * Time: 15:44
 */

namespace common\components;

use common\models\InstantQuote;
use common\models\QuoteCompany;
use yii\helpers\Html;
use yii\helpers\Url;

class Helper {
	const REGEXP_POSTCODE = "/[A-Za-z]{1,2}[0-9][0-9A-Za-z]?\s?([0-9][A-Za-z]{2})?/"; //"/^([A-PR-UWYZ]([0-9]{1,2}|([A-HK-Y][0-9]([0-9ABEHMNPRV-Y])?)|[0-9][A-HJKPS-UW]) ?[0-9][ABD-HJLNP-UW-Z]{2})$/i";
	const REGEXP_PHONE = "/^\+?[0-9()\s-]{6,20}$/";

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

	static function isShowSendEnquiryButton($companyId)
	{
		return $companyId == QuoteCompany::$SkiKingsCompany;
	}

	/**
	 * @param $id
	 * @return string
	 */
	static function getRateImageByRetailerId($id)
	{
		switch ($id) {
			case 2.5 : $img = "/images/rate-poor.png";
						break;
			case 5 : $img = "/images/rate-neutral.png";
				break;
			case 7.5 : $img = "/images/rate-good.png";
				break;
			case 10 : $img = "/images/rate-excellent.png";
				break;
			default : $img = '';
		}

		return $img;
	}
}