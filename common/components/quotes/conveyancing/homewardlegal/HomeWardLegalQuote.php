<?php
/**
 * Automated generate sending form for Home Ward Legal Conveyancing Solicitor Quote
 * Parse the conveyancing prices of quote
 * https://www.homewardlegal.co.uk/
 * for testing use http://www.fakenamegenerator.com/gen-random-en-uk.php
 *
 * @copyright (c) 2017, Kudin Dmitry
 *
 */


namespace common\components\quotes\conveyancing\homewardlegal;

use common\components\quotes\conveyancing\ConveyancingQuoteBase;
use common\components\quotes\conveyancing\QuoteParsedResult;
use common\models\InstantQuote;


class HomeWardLegalQuote extends ConveyancingQuoteBase{

	protected $patternPriceRow = '#<tr[^>]*?>\s*<td[^>]*?>(.*?)<\/td>\s*<td[^>]*?>(.*?)<\/td>\s*<\/tr>#si';

	/**
	 * The associated array containing full form fields values
	 */
	protected $formFields = [
		'selection' => '', // `Quote type` - purchase / sale / sale_purchase / remortgage

		//BUYING BLOCK
		'p_mortgage' => '', // `I'm buying with a mortgage` - Yes / No
		'p_tenure' => '', // `The buying property is` - Freehold / Leasehold / Share of Freehold
		'p_property_value' => '', //`Buying Price` - 104000
		'p_property_postcode' => '', // `Buying Postcode` - e1

		//SELLING BLOCK
		's_mortgage' => '', // Is there a mortgage on the property? - Yes / No
		's_tenure' => '', // `What is the type of property you are selling?` - Freehold / Leasehold / Share of Freehold
		's_property_value' => '', //`Selling Price` - 104000
		's_property_postcode' => '', // `Selling Postcode` - e1

		//BUY & SALE BLOCK
		'sp_p_mortgage' => '', // `I'm buying with a mortgage` - Yes / No
		'sp_p_tenure' => '', // `The buying property is` - Freehold / Leasehold / Share of Freehold
		'sp_p_property_value' => '', //`Buying Price` - 104000
		'sp_p_property_postcode' => '', // `Buying Postcode` - e1
		'sp_s_mortgage' => '', // Is there a mortgage on the property? - Yes / No
		'sp_s_tenure' => '', // `What is the type of property you are selling?` - Freehold / Leasehold / Share of Freehold
		'sp_s_property_value' => '', //`Selling Price` - 104000
		'sp_s_property_postcode' => '', // `Selling Postcode` - e1

		//REMORTGAGE BLOCK
		'r_property_value' => '', //`Remortgage Price` - 104000
		'r_property_postcode' => '', // `Remortgage Postcode` - e1

		//TRANSFER OF ENQUITY
		't_mortgage' => '', // `Property has a a mortgage` - Yes / No
		't_property_value' => '', //`Property Price` - 104000
		't_property_postcode' => '', // `Property Postcode` - e1

		// PERSONAL BLOCK
		'personal_fname' => '', //Full Name - Matthew Payne
		'personal_phone' => '', // Telephone 07037315082
		'personal_email' => '', // Email SebastianSutton@teleworm.us

		'submit' => 'Next',
	];

	public function __construct($quote){
		$this->companyId = 2;
		$this->mainPageUrl = 'https://www.homewardlegal.co.uk/';
		$this->formSenderSDKPath = dirname(__FILE__);

		$this->typeBuying = 'purchase';
		$this->typeBuyingSelling = 'sale_purchase';
		$this->typeSelling = 'sale';
		$this->typeRemortgaging = 'remortgage';

//		$this->debug=true;
		parent::__construct($quote);
	}

	protected function fillData()
	{
		if(!empty($this->instantQuote->first_name) || !empty($this->instantQuote->last_name))
			$this->formFields['personal_fname'] = trim($this->instantQuote->first_name . ' ' . $this->instantQuote->last_name);
		if(!empty($this->instantQuote->email)) $this->formFields['personal_email'] = $this->instantQuote->email;
		if(!empty($this->instantQuote->phone)) $this->formFields['personal_phone'] = $this->instantQuote->phone;

		unset($this->formFields['t_mortgage']);

		switch($this->instantQuote->type){
			case InstantQuote::TYPE_BUY :
				$this->formFields['selection'] = $this->typeBuying;
				unset($this->formFields['sp_s_tenure']);
				unset($this->formFields['sp_s_mortgage']);
				unset($this->formFields['sp_p_tenure']);
				unset($this->formFields['sp_p_mortgage']);
				unset($this->formFields['s_tenure']);
				unset($this->formFields['s_mortgage']);

				if(!empty($this->instantQuote->has_buying_mortgage) && $this->instantQuote->has_buying_mortgage==1) $this->formFields['p_mortgage'] = "Yes";
				else $this->formFields['p_mortgage'] = 'No';

				if(!empty($this->instantQuote->property_type) && $this->instantQuote->property_type==InstantQuote::LEASEHOLD)
					$this->formFields['p_tenure'] = $this->paramLeasehold;
				else $this->formFields['p_tenure'] = $this->paramFreehold;

				if(!empty($this->instantQuote->buying_price)) $this->formFields['p_property_value'] = $this->instantQuote->buying_price;
				if(!empty($this->instantQuote->buying_postcode)) $this->formFields['p_property_postcode'] = $this->instantQuote->buying_postcode;
				break;

			case InstantQuote::TYPE_BUY_N_SELL :
				$this->formFields['selection'] = $this->typeBuyingSelling;
				unset($this->formFields['s_tenure']);
				unset($this->formFields['s_mortgage']);
				unset($this->formFields['p_tenure']);
				unset($this->formFields['p_mortgage']);

				if(!empty($this->instantQuote->has_buying_mortgage) && $this->instantQuote->has_buying_mortgage==1) $this->formFields['sp_p_mortgage'] = "Yes";
				else $this->formFields['sp_p_mortgage'] = 'No';
				if(!empty($this->instantQuote->property_type) && $this->instantQuote->property_type==InstantQuote::LEASEHOLD)
					$this->formFields['sp_p_tenure'] = $this->paramLeasehold;
				else $this->formFields['sp_p_tenure'] = $this->paramFreehold;
				if(!empty($this->instantQuote->buying_price)) $this->formFields['sp_p_property_value'] = $this->instantQuote->buying_price;
				if(!empty($this->instantQuote->buying_postcode)) $this->formFields['sp_p_property_postcode'] = $this->instantQuote->buying_postcode;

				if(!empty($this->instantQuote->has_selling_mortgage) && $this->instantQuote->has_selling_mortgage==1) $this->formFields['sp_s_mortgage'] = "Yes";
				else $this->formFields['sp_s_mortgage'] = 'No';
				if(!empty($this->instantQuote->selling_property_type) && $this->instantQuote->selling_property_type==InstantQuote::LEASEHOLD)
					$this->formFields['sp_s_tenure'] = $this->paramLeasehold;
				else $this->formFields['sp_s_tenure'] = $this->paramFreehold;
				if(!empty($this->instantQuote->selling_price)) $this->formFields['sp_s_property_value'] = $this->instantQuote->selling_price;
				if(!empty($this->instantQuote->selling_postcode)) $this->formFields['sp_s_property_postcode'] = $this->instantQuote->selling_postcode;
				break;

			case InstantQuote::TYPE_SELL :
				$this->formFields['selection'] = $this->typeSelling;
				unset($this->formFields['sp_s_tenure']);
				unset($this->formFields['sp_s_mortgage']);
				unset($this->formFields['sp_p_tenure']);
				unset($this->formFields['sp_p_mortgage']);
				unset($this->formFields['p_tenure']);
				unset($this->formFields['p_mortgage']);

				if(!empty($this->instantQuote->has_selling_mortgage) && $this->instantQuote->has_selling_mortgage==1) $this->formFields['s_mortgage'] = "Yes";
				else $this->formFields['s_mortgage'] = 'No';
				if(!empty($this->instantQuote->selling_property_type) && $this->instantQuote->selling_property_type==InstantQuote::LEASEHOLD)
					$this->formFields['s_tenure'] = $this->paramLeasehold;
				else $this->formFields['s_tenure'] = $this->paramFreehold;
				if(!empty($this->instantQuote->selling_price)) $this->formFields['s_property_value'] = $this->instantQuote->selling_price;
				if(!empty($this->instantQuote->selling_postcode)) $this->formFields['s_property_postcode'] = $this->instantQuote->selling_postcode;
				break;

			case InstantQuote::TYPE_REMORTGAGE :
				$this->formFields['selection'] = $this->typeRemortgaging;
				unset($this->formFields['sp_s_tenure']);
				unset($this->formFields['sp_s_mortgage']);
				unset($this->formFields['sp_p_tenure']);
				unset($this->formFields['sp_p_mortgage']);
				unset($this->formFields['s_tenure']);
				unset($this->formFields['s_mortgage']);
				unset($this->formFields['p_tenure']);
				unset($this->formFields['p_mortgage']);

				if(!empty($this->instantQuote->remortgage_price)) $this->formFields['r_property_value'] = $this->instantQuote->remortgage_price;
				if(!empty($this->instantQuote->remortgage_postcode)) $this->formFields['r_property_postcode'] = $this->instantQuote->remortgage_postcode;
				break;
		}

		return true;
	}

	protected function getFormPageUrl(){
		return $this->mainPageUrl . 'quotebuilder?product=' . $this->formFields['selection'];
	}

	protected function getRequestPageUrl(){
		return $this->mainPageUrl . 'rquip_async/get_quote';
	}

	protected function sendForm()
	{
		//send form to site
		$result = $this->pageGetter->sendRequest($this->getRequestPageUrl(), 'POST', $this->formFields, $this->getFormPageUrl(), false);

		if($result['Status'] == "FAIL"){
			self::log($result['StatusDetails'] . "\r\n" . $result['Response']);
			return false;
		}
/*
				$result = [
					'Response' => file_get_contents($this->formSenderSDKPath . '/response1.html')
				];
*/
		if(!$this->isPageGood($result['Response'], '#>Reference number</td>#', 'Error Page: Didn`t find required phrase `Reference number`'))
			return false;

		$this->resultPage = $result['Response'];

		return true;
	}

	protected function parseForm()
	{
		$sum = 0;
		$patternInstructUsUrl = '#"(http[^"]*?instruct-us\?[^"]*?)"#si';
		$patternHtml = '#"rquip-quote-date"(.*?)"rquip-quote-ref"#s';
		$patternReferenceNumber = '#Reference number<\/td><td[^>]*>(.*?)<\/td>#s';
		$patternSellingFees = '#<h2[^>]*?>Your Sale Conveyancing fees(.*?)<\/table>#si';
		$patternSellingDisbursements = '#<h2[^>]*?>Your Sale Conveyancing disbursements(.*?)<\/table>#si';
		$patternBuyingFees = '#<h2[^>]*?>Your Purchase Conveyancing fees(.*?)<\/table>#si';
		$patternBuyingDisbursements = '#<h2[^>]*?>Your Purchase Conveyancing disbursements(.*?)<\/table>#si';
		$patternRemortgageFees = '#<h2[^>]*?>Your Remortgage fees(.*?)<\/table>#si';
		$patternRemortgageDisbursements = '#<h2[^>]*?>Your Remortgage disbursements(.*?)<\/table>#si';

		$referenceNumber = $this->parseElement($patternReferenceNumber, $this->resultPage, 'Reference Number');
		if($referenceNumber !== false)
			$this->parsedForm->referenceNumber = $referenceNumber;

		$instructUsUrl = $this->parseElement($patternInstructUsUrl, $this->resultPage, 'Instruct Us Url');
		if($instructUsUrl !== false)
			$this->parsedForm->setInstructUsForm($instructUsUrl);

		$html = $this->parseElement($patternHtml, $this->resultPage, 'HTML');

		$sum += $this->parseBlockWithPrices($patternSellingFees, $html, QuoteParsedResult::FIELD_SELLING, true, 'Selling fees block');
		$sum += $this->parseBlockWithPrices($patternSellingDisbursements, $html, QuoteParsedResult::FIELD_SELLING, false, 'Selling disbursements block');

		$sum += $this->parseBlockWithPrices($patternBuyingFees, $html, QuoteParsedResult::FIELD_BUYING, true, 'Buying fees block');
		$sum += $this->parseBlockWithPrices($patternBuyingDisbursements, $html, QuoteParsedResult::FIELD_BUYING, false, 'Buying disbursements block');

		$sum += $this->parseBlockWithPrices($patternRemortgageFees, $html, QuoteParsedResult::FIELD_UNDEFINED, true, 'Remortgage fees block');
		$sum += $this->parseBlockWithPrices($patternRemortgageDisbursements, $html, QuoteParsedResult::FIELD_UNDEFINED, false, 'Remortgage disbursements block');

		if($sum==0){
			self::log("Sum all prices ($sum)");
			return false;
		}

		return $this->parsedForm;
	}

	protected function parseBlockWithPrices($pattern, $content, $blockType, $isFee, $blockName){
		$sum = 0;

		$block = $this->parseElement($pattern, $content, $blockName);
		if($block !== false){
			$prices = $this->parsePricesRows($block);
			foreach($prices as $key=>$value){

				if($isFee) $this->parsedForm->addToService($blockType, $key, $value);
				else $this->parsedForm->addToThirdParties($blockType, $key, $value);

				$sum += $value;
			}
		}

		return $sum;
	}

	protected function parsePricesRows($block){
		$result = [];

		if(preg_match_all($this->patternPriceRow, $block, $matches)){
			if(isset($matches[1]) && isset($matches[2]) && is_array($matches[1]) && is_array($matches[2])){
				for($i=0; $i<count($matches[1]); $i++){
					$title = strip_tags(trim($matches[1][$i], ' *'));

					//do not store Total row
					if(strpos($title, 'Total') === 0) continue;

					$price = str_replace(',', '', str_replace('&pound;', '', $matches[2][$i]));
					if($price=='Included') $price = 0;

					$result[$title] = (float)$price;
				}
			}
		};

		return $result;
	}
}