<?php
/**
 * Automated generate sending form for My Home Move Conveyancing
 * Parse the conveyancing prices of quote
 * http://myhomemoveconveyancing.co.uk
 * for testing use http://www.fakenamegenerator.com/gen-random-en-uk.php
 *
 * @copyright (c) 2017, Kudin Dmitry
 *
 */


namespace common\components\quotes\conveyancing\myhomemove;

use common\components\quotes\conveyancing\ConveyancingQuoteBase;
use common\components\quotes\conveyancing\QuoteParsedResult;
use common\components\quotes\conveyancing\QuoteInstructUsForm;
use common\models\InstantQuote;


define('FORMSENDER_SDK_PATH', dirname(__FILE__)); // Path to Form sender SDK

//https://myhomemoveconveyancing.co.uk/step-2/?quotation=MHMC-9994%2F050917%2F021&key=59ae9359d72c3
class MyHomeMoveQuote extends ConveyancingQuoteBase
{
	protected $patternPriceRow = '#<tr[^>]*?><td[^>]*?>.*?</td><td[^>]*?>(.*?)</td><td[^>]*?>(.*?)</td></tr>#si';

	protected $patternInstructForm = '#<div[^>]*?gform_wrapper_21[^>]*?>(.*?)<\/form>#si';

	/**
	 * The associated array containing full form fields values
	 */
	protected $formFields = [
		"input_20" => '',
		"input_21" => '', // `Quote type` - buying / buying_selling / selling / remortgaging
		"input_30" => '',

		//BUYING BLOCK
		"input_2" => '', //`Buying Price` - 104,000
		"input_22" => 'Freehold', // `The buying property is` - Freehold / Leasehold
		"input_4.1" => '', // `I'm buying with a mortgage` - '' / 1
		"input_5.1" => '', // `New build property` - '' / 1
		"input_33.1" => '', // `This is a second or investment property purchase` - '' / 1

		//SELLING BLOCK
		"input_6" => '', // `Selling Price` - 150,000
		"input_23" => 'Freehold', // `The selling property is` - Freehold / Leasehold
		"input_8.1" => '', // `I already have a mortgage on this property` - '' / 1

		//REMORTGAGE BLOCK
		"input_9" => '', // `Remortgage Price` - 150,000
		"input_24" => 'Freehold', // `The Remortgage property is` - Freehold / Leasehold

		// About me
		"input_11" => '', // `First name` - Matthew
		"input_12" => '', // `Last name` - Payne
		"input_13" => '', // `Email Address` - MatthewPayne@jourrapide.com
		"input_28" => '', // `Email Address` - MatthewPayne@jourrapide.com
		"input_14" => '', // `Telephone` - 07037315082
		"input_29" => '', // `Telephone` - 07037315082
//		"input_15.1" => '', // `I would like to receive emails about products and special offers` - '' / 1

		"input_16" => '',
		"input_17" => '',
		"input_18" => '',
		"input_19" => '',
		"input_32" => '',
		"input_35" => '',

		"is_submit_1" => 1, // NEED To PARSE - 1
		"gform_submit" => 1, // NEED To PARSE - 1
		"gform_unique_id" => '', // NEED To PARSE
		"state_1" => '', // NEED To PARSE - WyJbXSIsImRmM2U5NzU0MDE5YmU0NzVjM2ViZDY0NzE0MDQyYmQ4Il0=
		"gform_target_page_number_1" => 0, // NEED To PARSE - 0
		"gform_source_page_number_1" => 1, // NEED To PARSE - 1
		"gform_field_values" => 'quote_type_preselect=' // NEED To PARSE -  quote_type_preselect=
	];

	public function __construct($quote)
	{
		$this->companyId = 1;
		$this->mainPageUrl = 'https://myhomemoveconveyancing.co.uk';
		$this->formSenderSDKPath = dirname(__FILE__);

		$this->typeBuying = 'buying';
		$this->typeBuyingSelling = 'buying_selling';
		$this->typeSelling = 'selling';
		$this->typeRemortgaging = 'remortgaging';
		$this->debug=true;

		parent::__construct($quote);
	}

	protected function fillData()
	{
		if(!empty($this->instantQuote->first_name)) $this->formFields['input_11'] = $this->instantQuote->first_name;
		if(!empty($this->instantQuote->last_name)) $this->formFields['input_12'] = $this->instantQuote->last_name;

		if(!empty($this->instantQuote->email)) {
			$this->formFields['input_13'] = $this->instantQuote->email;
			$this->formFields['input_28'] = $this->instantQuote->email;
		}

		if(!empty($this->instantQuote->phone)) {
			$this->formFields['input_14'] = $this->instantQuote->phone;
			$this->formFields['input_29'] = $this->instantQuote->phone;
		}

		switch($this->instantQuote->type){
			case InstantQuote::TYPE_BUY :
				$this->formFields['input_21'] = $this->typeBuying;
				break;
			case InstantQuote::TYPE_BUY_N_SELL :
				$this->formFields['input_21'] = $this->typeBuyingSelling;
				break;
			case InstantQuote::TYPE_SELL :
				$this->formFields['input_21'] = $this->typeSelling;
				break;
			case InstantQuote::TYPE_REMORTGAGE :
				$this->formFields['input_21'] = $this->typeRemortgaging;
				break;
		}

		if($this->formFields['input_21']==$this->typeBuying || $this->formFields['input_21']==$this->typeBuyingSelling){
			if(!empty($this->instantQuote->buying_price)) $this->formFields['input_2'] = number_format($this->instantQuote->buying_price);
			if(!empty($this->instantQuote->property_type) && $this->instantQuote->property_type==InstantQuote::LEASEHOLD)
				$this->formFields['input_22'] = $this->paramLeasehold;
			if(!empty($this->instantQuote->has_buying_mortgage)) $this->formFields['input_4.1'] = $this->instantQuote->has_buying_mortgage;
			else unset($this->formFields['input_4.1']);
			if(!empty($this->instantQuote->is_new_build)) $this->formFields['input_5.1'] = $this->instantQuote->is_new_build;
			else unset($this->formFields['input_5.1']);
			if(!empty($this->instantQuote->is_second_purchase)) $this->formFields['input_33.1'] = $this->instantQuote->is_second_purchase;
			else unset($this->formFields['input_33.1']);
		}

		if($this->formFields['input_21']==$this->typeSelling || $this->formFields['input_21']==$this->typeBuyingSelling){
			if(!empty($this->instantQuote->selling_price)) $this->formFields['input_6'] = number_format($this->instantQuote->selling_price);
			if(!empty($this->instantQuote->selling_property_type) && $this->instantQuote->selling_property_type==InstantQuote::LEASEHOLD)
				$this->formFields['input_23'] = $this->paramLeasehold;
			if(!empty($this->instantQuote->has_selling_mortgage)) $this->formFields['input_8.1'] = $this->instantQuote->has_selling_mortgage;
			else unset($this->formFields['input_8.1']);
		}

		if($this->formFields['input_21']==$this->typeRemortgaging){
			if(!empty($this->instantQuote->remortgage_price)) $this->formFields['input_9'] = number_format($this->instantQuote->remortgage_price);
			if(!empty($this->instantQuote->remortgage_property_type) && $this->instantQuote->remortgage_property_type==InstantQuote::LEASEHOLD)
				$this->formFields['input_24'] = $this->paramLeasehold;
		}

		return true;
	}

	protected function sendForm()
	{
		//get main page for getting additional parameters
		$result = $this->pageGetter->sendRequest($this->mainPageUrl);

		if($result['Status'] == "FAIL"){
			$this->log($result['StatusDetails'] . "\r\n" . $result['Response']);
			return false;
		}

//		$this->log($result['Status'] . " - ALLGOOD\r\n" . $result['Response']);
//		$result = file_get_contents($this->formSenderSDKPath . '/response1.txt');

		if(!$this->parseSpecialParameters($result['Response'])){
			return false;
		}

		//send form to site
		$result = $this->pageGetter->sendRequest($this->mainPageUrl, 'POST', $this->formFields, $this->mainPageUrl, true);

		if($result['Status'] == "FAIL"){
			$this->log($result['StatusDetails'] . "\r\n" . $result['Response']);
			return false;
		}

/*
		$result = [
			'Response' => file_get_contents($this->formSenderSDKPath . '/response23.txt')
		];
*/
		if(!$this->isPageGood($result['Response'], '#Here\sis\syour\sfixed\sprice\squote#', 'Error Page: Didn`t find required phrase `Here is your fixed price quote`'))
			return false;

		$this->resultPage = $result['Response'];

		return true;
	}


	protected function parseInstructUsForm($content){
		$patternForm = '#<div[^>]*?gform_wrapper_21[^>]*?>(.*?)<\/form>#s';
		$patternFormActionAbsolute = '#<form[^>]*?action=*?[\'"](http.*?)[\'"][^>]*?>#i';
		$patternFormAction = '#<form[^>]*?action=*?[\'"](.*?)[\'"][^>]*?>#i';
		$patternFormMethod = '#<form[^>]*?method=*?[\'"](.*?)[\'"][^>]*?>#i';
		$patternFormIsMultiPartForm = '#<form[^>]*?(multipart\/form-data)[^>]*?>#i';
		$patternInputs = '#<input[^>]*?name=*?[\'"](.*?)[\'"][^>]*?value=*?[\'"](.*?)[\'"][^>]*?>#i';

		$formContent = $this->parseElement($patternForm, $content, 'Instruct Us form');
		$formAction = $this->parseElement($patternFormActionAbsolute, $formContent, 'Instruct Us form action');
		if($formAction === false){
			$formAction = $this->parseElement($patternFormAction, $formContent, 'Instruct Us form action');
			if($formAction === false) return false;

			$formAction = $this->mainPageUrl . $formAction;
		}

		$isMultiPartForm = $this->parseElement($patternFormIsMultiPartForm, $formContent, 'Instruct Us form type');
		if($isMultiPartForm !== false){
			$isMultiPartForm = true;
		}

		$formMethod = QuoteInstructUsForm::METHOD_GET;
		$method = $this->parseElement($patternFormMethod, $formContent, 'Instruct Us form method');
		if($method !== false && ($method=='POST' || $method=='post')){
			$formMethod = QuoteInstructUsForm::METHOD_POST;
		}

		$inputs = [];
		if(preg_match_all($patternInputs, $formContent, $matches)){
			if(isset($matches[1]) && isset($matches[2]) && is_array($matches[1]) && is_array($matches[2])){
				for($i=0; $i<count($matches[1]); $i++){
					$inputs[strip_tags($matches[1][$i])] = strip_tags($matches[2][$i]);
				}
			}
		};

		if($formMethod==QuoteInstructUsForm::METHOD_POST && count($inputs)==0) return false;

		$this->parsedForm->setInstructUsForm($formAction, $formMethod, $inputs, $isMultiPartForm);

		return true;
	}

	protected function parseForm()
	{
		$sum = 0;
		$patternHtml = '#<div\s+class="results__left">(.*?)<div\s+class="results__right">#s';
		$patternReferenceNumber = '#<p>Quote reference number:</p><p[^>]*>(.*?)</p>#s';
		$patternPar1 = '#<h3\sclass="h3--lg"(.*?)Additional\scosts\spaid\sto\sthird\sparties#si';
		$patternPar2 = '#Additional\scosts\spaid\sto\sthird\sparties(.*?)Grand\sTotal#si';
		$patternSelling = '#<h3[^>]*">\s?For\sSelling</h3>(.*?)</table>#si';
		$patternBuying = '#<h3[^>]*">\s?For\sBuying</h3>(.*?)</table>#si';
		$patternUndefined = '#<table[^>]*class="results__table[^"]*?"[^>]*?>(.*?)</table>#si';
		$patternGrandTotal = '#<span id="grand-total">(.*?)</span>#s';

		$html = $this->parseElement($patternHtml, $this->resultPage, 'HTML');

		$referenceNumber = $this->parseElement($patternReferenceNumber, $html, 'Reference Number');
		if($referenceNumber !== false)
			$this->parsedForm->referenceNumber = $referenceNumber;

		$part1 = $this->parseElement($patternPar1, $html, 'Part1');

		$blockSelling = $this->parseElement($patternSelling, $part1, 'Selling block');
		if($blockSelling !== false){
			$prices = $this->parsePricesRows($blockSelling);
			foreach($prices as $key=>$value){
				$this->parsedForm->addToService(QuoteParsedResult::FIELD_SELLING, $key, $value);
				$sum += $value;
			}
		}

		$blockBuying = $this->parseElement($patternBuying, $part1, 'Buying block');
		if($blockBuying !== false){
			$prices = $this->parsePricesRows($blockBuying);
			foreach($prices as $key=>$value){
				$this->parsedForm->addToService(QuoteParsedResult::FIELD_BUYING, $key, $value);
				$sum += $value;
			}
		}

		if(!$blockSelling && !$blockBuying){
			$blockUndefined = $this->parseElement($patternUndefined, $part1, 'Table with prices');
			if($blockUndefined !== false){
				$prices = $this->parsePricesRows($blockUndefined);
				foreach($prices as $key=>$value){
					$this->parsedForm->addToService(QuoteParsedResult::FIELD_UNDEFINED, $key, $value);
					$sum += $value;
				}
			}
		}

		$part2 = $this->parseElement($patternPar2, $html, 'Part2');

		$blockSelling = $this->parseElement($patternSelling, $part2, 'Selling block');
		if($blockSelling !== false){
			$prices = $this->parsePricesRows($blockSelling);
			foreach($prices as $key=>$value){
				$this->parsedForm->addToThirdParties(QuoteParsedResult::FIELD_SELLING, $key, $value);
				$sum += $value;
			}
		}

		$blockBuying = $this->parseElement($patternBuying, $part2, 'Buying block');
		if($blockBuying !== false){
			$prices = $this->parsePricesRows($blockBuying);
			foreach($prices as $key=>$value){
				$this->parsedForm->addToThirdParties(QuoteParsedResult::FIELD_BUYING, $key, $value);
				$sum += $value;
			}
		}

		if(!$blockSelling && !$blockBuying){
			$blockUndefined = $this->parseElement($patternUndefined, $part2, 'Table with prices');
			if($blockUndefined !== false){
				$prices = $this->parsePricesRows($blockUndefined);
				foreach($prices as $key=>$value){
					$this->parsedForm->addToThirdParties(QuoteParsedResult::FIELD_UNDEFINED, $key, $value);
					$sum += $value;
				}
			}
		}

		$grandTotal = $this->parseElement($patternGrandTotal, $html, 'Grand total');
		$grandTotal = (float)str_replace(',', '', $grandTotal);

		if($grandTotal!=$sum || $sum==0){
			self::log("Sum all prices ($sum) not equal to grand total ($grandTotal)");
			return false;
		}

		$this->parseInstructUsForm($this->resultPage);

		return $this->parsedForm;
	}

	protected function parsePricesRows($block){
		$result = [];
		if(preg_match_all($this->patternPriceRow, $block, $matches)){
			if(isset($matches[1]) && isset($matches[2]) && is_array($matches[1]) && is_array($matches[2])){
				for($i=0; $i<count($matches[1]); $i++){
					$result[trim($matches[1][$i], ' *')] = (float)str_replace(',', '', str_replace('&pound;', '', $matches[2][$i]));
				}
			}
		};

		return $result;
	}

	protected function parseSpecialParameters($content){
		if(!$this->parseFormField("#name='is_submit_1' value='(.*?)'#", $content,'is_submit_1' )) return false;
		if(!$this->parseFormField("#name='gform_submit' value='(.*?)'#", $content,'gform_submit' )) return false;
		if(!$this->parseFormField("#name='gform_unique_id' value='(.*?)'#", $content,'gform_unique_id' )) return false;
		if(!$this->parseFormField("#name='state_1' value='(.*?)'#", $content,'state_1' )) return false;
		if(!$this->parseFormField("#name='gform_target_page_number_1'[^>]*?value='(.*?)'[^>]*?>#", $content,'gform_target_page_number_1' )) return false;
		if(!$this->parseFormField("#name='gform_source_page_number_1'[^>]*?value='(.*?)'[^>]*?>#", $content,'gform_source_page_number_1' )) return false;
		if(!$this->parseFormField("#name='gform_field_values' value='(.*?)'#", $content,'gform_field_values' )) return false;

		return true;
	}

}
