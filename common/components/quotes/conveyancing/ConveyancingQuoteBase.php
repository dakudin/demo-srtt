<?php
/**
 * Base class for Automated generate sending form for Conveyancing Solicitor Quote
 * Parse the conveyancing prices of quote
 *
 * @copyright (c) 2017, Kudin Dmitry
 *
 */

namespace common\components\quotes\conveyancing;

use common\components\quotes\QuoteBase;
use common\models\InstantQuote;

class ConveyancingQuoteBase extends QuoteBase {

	/**
	 * @var QuoteParsedResult parsed data storing in special format
	 */
	protected $parsedForm;

	protected $patternPriceRow = '#<tr[^>]*?><td[^>]*?>(.*?)</td><td[^>]*?>(.*?)</td></tr>#si';
	protected $patternInstructForm = '';

	protected $typeBuying = 'buying';
	protected $typeBuyingSelling = 'buying_selling';
	protected $typeSelling = 'selling';
	protected $typeRemortgaging = 'remortgaging';

	protected $paramFreehold = 'Freehold';
	protected $paramLeasehold = 'Leasehold';

	/**
	 * @var \common\models\InstantQuote
	 */
	protected $instantQuote;

	/**
	 * @param InstantQuote $quote Model with new conveyancing quote
	 */
	public function __construct(InstantQuote $quote)
	{
		parent::__construct();

		$this->parsedForm = new QuoteParsedResult();

		if(is_a($quote, 'common\models\InstantQuote')){
			$this->instantQuote = $quote;
		}
	}

	public function getParsedForm(){
		return $this->parsedForm;
	}

	protected function parsePricesRows($block){
		$result = [];

		if(preg_match_all($this->patternPriceRow, $block, $matches)){
			if(isset($matches[1]) && isset($matches[2]) && is_array($matches[1]) && is_array($matches[2])){
				for($i=0; $i<count($matches[1]); $i++){
					$title = strip_tags(trim($matches[1][$i], ' *'));

					$price = str_replace(',', '', str_replace('&pound;', '', $matches[2][$i]));
					if($price=='Included') $price = 0;

					$result[$title] = (float)$price;
				}
			}
		};

		return $result;
	}

	protected function parseFormField($pattern, $content, $fieldName){
		preg_match($pattern, $content, $token);
		if (empty($token)) {
			$this->log("Didn't find field `$fieldName`");

			return false;
		}
		$this->formFields[$fieldName] = $token[1];

		return true;
	}

}