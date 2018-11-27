<?php
/**
 * Created by Kudin Dmitry.
 * Date: 28.09.17
 * Time: 18:07
 */

namespace common\components\quotes\conveyancing\birdandco;

use common\components\quotes\conveyancing\ConveyancingQuoteBase;
use common\components\quotes\conveyancing\QuoteParsedResult;
use common\models\InstantQuote;


class BirdandcoQuote extends ConveyancingQuoteBase{

	protected $quoteCalculatorId;
	protected static $quotePurchaseCalculatorId = 60;
	protected static $quoteSaleCalculatorId = 61;
	protected static $quoteRemortgageCalculatorId = 62;

	protected $apiUrl = 'https://go.intouchapp.co.uk/api/v2/widgets/';

	protected $quoteCalculatorGroupId = '55d46c55-48d9-4557-8195-1c700ef01b6e';


	/**
	 * The associated array containing full form fields values
	 */
	protected $formFields = [
		'property.tenure' => 'Freehold', // Freehold/Leasehold
		'helptobuy' => 'No', // Yes/No
		'sdlt.additional' => 'No', // Yes/No
		'property.price' => '', // Property Price 105000
		'Referrer' => 'Direct', // Direct/
		'channel' => 'Direct', // Direct/
		'matter.primaryClient.forename' => '', //First name
		'matter.primaryClient.surname' => '', // Last name
		'matter.primaryClient.email' => '', //Email SebastianSutton@teleworm.us
		'matter.primaryClient.phone' => '', // Telephone 07037315082
	];

	public function __construct($quote){
		$this->companyId = 3;
		$this->mainPageUrl = 'https://www.birdandco.co.uk/site/conveyancing-solicitors/';
		$this->formSenderSDKPath = dirname(__FILE__);
		$this->debug=true;

		parent::__construct($quote);
	}

	protected function fillData()
	{
		if(!empty($this->instantQuote->first_name)) $this->formFields['matter.primaryClient.forename'] = $this->instantQuote->first_name;
		if(!empty($this->instantQuote->last_name)) $this->formFields['matter.primaryClient.surname'] = $this->instantQuote->last_name;
		if(!empty($this->instantQuote->email)) $this->formFields['matter.primaryClient.email'] = $this->instantQuote->email;
		if(!empty($this->instantQuote->phone)) $this->formFields['matter.primaryClient.phone'] = $this->instantQuote->phone;

		switch($this->instantQuote->type){
			case InstantQuote::TYPE_BUY :
				$this->quoteCalculatorId = self::$quotePurchaseCalculatorId;

				if(!empty($this->instantQuote->property_type) && $this->instantQuote->property_type==InstantQuote::LEASEHOLD)
					$this->formFields['property.tenure'] = $this->paramLeasehold;
				else $this->formFields['property.tenure'] = $this->paramFreehold;

				if(!empty($this->instantQuote->help_to_buy) && $this->instantQuote->help_to_buy==1) $this->formFields['helptobuy'] = "Yes";
				else $this->formFields['helptobuy'] = 'No';
				if(!empty($this->instantQuote->sdlt_additional) && $this->instantQuote->sdlt_additional==1) $this->formFields['sdlt.additional'] = "Yes";
				else $this->formFields['sdlt.additional'] = 'No';

				if(!empty($this->instantQuote->buying_price)) $this->formFields['property.price'] = $this->instantQuote->buying_price;
				break;

			case InstantQuote::TYPE_SELL :
				$this->quoteCalculatorId = self::$quoteSaleCalculatorId;
				unset($this->formFields['helptobuy']);
				unset($this->formFields['sdlt.additional']);

				if(!empty($this->instantQuote->selling_price)) $this->formFields['property.price'] = $this->instantQuote->selling_price;

				if(!empty($this->instantQuote->selling_property_type) && $this->instantQuote->selling_property_type==InstantQuote::LEASEHOLD)
					$this->formFields['property.tenure'] = $this->paramLeasehold;
				else $this->formFields['property.tenure'] = $this->paramFreehold;
				break;

			case InstantQuote::TYPE_REMORTGAGE :
				$this->quoteCalculatorId = self::$quoteRemortgageCalculatorId;
				unset($this->formFields['helptobuy']);
				unset($this->formFields['sdlt.additional']);
				unset($this->formFields['Referrer']);
				unset($this->formFields['channel']);

				if(!empty($this->instantQuote->remortgage_price)) $this->formFields['property.price'] = $this->instantQuote->remortgage_price;

				if(!empty($this->instantQuote->remortgage_property_type) && $this->instantQuote->remortgage_property_type==InstantQuote::LEASEHOLD)
					$this->formFields['property.tenure'] = $this->paramLeasehold;
				else $this->formFields['property.tenure'] = $this->paramFreehold;
				break;
		}

		return true;
	}

	protected function getAPIPageUrl(){
		//https://go.intouchapp.co.uk/api/v2/widgets/55d46c55-48d9-4557-8195-1c700ef01b6e/60/quote?cachebust=1506606272522
		return $this->apiUrl . $this->quoteCalculatorGroupId . '/' . $this->quoteCalculatorId . '/quote?cachebust=' . time() . rand(100,999);
	}

	protected function getReferrerPageUrl(){
		return $this->mainPageUrl;
	}

	// Go to page https://www.birdandco.co.uk/site/conveyancing-solicitors/
	// find key in bottom of the page like this <script id="55d46c55-48d9-4557-8195-1c700ef01b6e">
	protected function sendForm()
	{
		$params = ['data' => $this->formFields];

		//send form to site
		$result = $this->pageGetter->sendRequest($this->getAPIPageUrl(), 'POST', $params, $this->getReferrerPageUrl(), false, true);

		if($result['Status'] == "FAIL"){
			$this->log($result['StatusDetails'] . "\r\n" . $result['Response']);
			return false;
		}
/*
		$result = [
			'Response' => file_get_contents($this->formSenderSDKPath . '/response1.txt')
		];
*/
		if(!$this->isJsonGood($result['Response']))
			return false;

		$this->resultPage = $result['Response'];

		return true;
	}

	protected function parseForm()
	{
		$object = json_decode($this->resultPage);

		$prices = $object->data->lineItems;

		if(!is_array($prices)) return false;

		$vat = 0;
		foreach($prices as $priceItem){
			if($priceItem->name == "Our Legal Fee"){
				$this->parsedForm->addToService(QuoteParsedResult::FIELD_UNDEFINED, $priceItem->name, $priceItem->charge);
			}else{
				$this->parsedForm->addToThirdParties(QuoteParsedResult::FIELD_UNDEFINED, $priceItem->name, $priceItem->charge);
			}

			$vat += $priceItem->tax;
		}

		if($vat>0){
			$this->parsedForm->addToService(QuoteParsedResult::FIELD_UNDEFINED, 'VAT', $vat);
		}

		return $this->parsedForm;
	}

	/**
	 * Detecting is remote page was got correct
	 *
	 * @param  string  $json
	 * @return boolean
	 */
	protected function isJsonGood($json)
	{
		$object = json_decode($json);
		if($json == null){
			$this->log("Result for solicitor with ID " . $this->companyId . " is not JSON format\r\n" . $json);
			return false;
		}

		if(!isset($object->data->lineItems)){
			$this->log("Result for solicitor with ID " . $this->companyId . " with wrong JSON\r\n" . $json);
			return false;
		}

		return true;
	}

}