<?php
/**
 * Created by Kudin Dmitry.
 * Date: 11.09.17
 * Time: 18:41
 */

namespace common\components\quotes\conveyancing;

use common\components\quotes\conveyancing\homewardlegal\HomeWardLegalQuote;
use common\components\quotes\conveyancing\myhomemove\MyHomeMoveQuote;
use common\components\quotes\conveyancing\birdandco\BirdandcoQuote;
use common\models\QuoteResponse;
use common\models\QuoteResponseDetail;
use common\models\InstantQuote;



class QuoteCreator extends \yii\base\Component
{

	protected $legalFee;
	protected $VAT;
	protected $stampDuty;
	protected $disbursements;

	protected $instantQuote;

	public function createQuote(InstantQuote $quote){

		if(is_a($quote, 'common\models\InstantQuote')){
			$this->instantQuote = $quote;
		}

		// create quote on `Homeward Legal`
		$this->createQuoteHWLQ();

		// create quote on `My Home Move`
		$this->createQuoteMHMQ();

		// create quote on `Bird&Co`
		$this->createQuoteBirdandco();

		return true;
	}

	protected function initializeValues(){
		$this->legalFee = 0;
		$this->VAT = 0;
		$this->stampDuty = 0;
		$this->disbursements = 0;
	}

	/*
	 * Create remote quote on Bird&Co site
	 */
	protected function createQuoteBirdandco(){

		if($this->instantQuote->type == InstantQuote::TYPE_BUY_N_SELL) return;

		$request = new BirdandcoQuote($this->instantQuote);

		if($request->MakeQuote()){
			$this->saveQuote($this->instantQuote->id, $request->companyId, $request->parsedForm);
		}
	}

	/*
	 * Create remote quote on Homeward Legal Quote site
	 */
	protected function createQuoteHWLQ(){

		$request = new HomeWardLegalQuote($this->instantQuote);

		if($request->MakeQuote()){
			$this->saveQuote($this->instantQuote->id, $request->companyId, $request->parsedForm);
		}
	}

	/*
	 * Create remote quote on My Home Move site
	 */
	protected function createQuoteMHMQ(){

		$request = new MyHomeMoveQuote($this->instantQuote);

		if($request->MakeQuote()){

			$this->saveQuote($this->instantQuote->id, $request->companyId, $request->parsedForm);
		}
	}

	protected function saveQuote($quoteId, $companyId, QuoteParsedResult $parsedForm){
		$this->initializeValues();

		$transaction = \Yii::$app->db->beginTransaction();

		try{
			$quoteResponse = new QuoteResponse();
			$quoteResponse->instant_quote_id = $quoteId;
			$quoteResponse->disbursements = 0;
			$quoteResponse->legal_fee = 0;
			$quoteResponse->vat = 0;
			$quoteResponse->stamp_duty = 0;
			$quoteResponse->quote_company_id = $companyId;
			$quoteResponse->reference_number = $parsedForm->referenceNumber;
			$quoteResponse->total_amount = 0;

			$instructUsUrl = $parsedForm->getInstructUsForm()->getUrl();
			if(!empty($instructUsUrl)){
				$quoteResponse->instruct_us_url = $instructUsUrl;
				$quoteResponse->instruct_us_method = $parsedForm->getInstructUsForm()->getMethod();
				$quoteResponse->instruct_us_is_multipart_form = $parsedForm->getInstructUsForm()->getIsMultipartFormData();

				if($quoteResponse->instruct_us_method == QuoteInstructUsForm::METHOD_POST){
					$quoteResponse->instruct_us_params = serialize($parsedForm->getInstructUsForm()->getParams());
				}
			}

			if($quoteResponse->save()){
				$this->processQuoteItems($quoteResponse->id, $parsedForm->getService(), false);
				$this->processQuoteItems($quoteResponse->id, $parsedForm->getThirdParties(), true);

				$quoteResponse->disbursements = $this->disbursements;
				$quoteResponse->legal_fee = $this->legalFee;
				$quoteResponse->vat = $this->VAT;
				$quoteResponse->stamp_duty = $this->stampDuty;
				$quoteResponse->total_amount = $this->disbursements + $this->legalFee + $this->VAT;

				$quoteResponse->update(true, ['disbursements', 'legal_fee', 'vat', 'stamp_duty', 'total_amount']);
			}else{
				throw new \Exception (var_export($quoteResponse->errors, true));
			}


			$transaction->commit();
		}catch (\Exception $e){
			$transaction->rollBack();
			throw $e;
		}
	}

	protected function processQuoteItems($quoteResponseId, $parseForm, $isDisbursements){

		foreach($parseForm as $type => $items){
			foreach($items as $description => $amount){
				$this->createQuoteDetail($quoteResponseId, $description, $amount, $type, $isDisbursements);
			}
		}
	}

	protected function createQuoteDetail($quoteResponseId, $description, $amount, $type, $isDisbursements){
		$quoteDetail = new QuoteResponseDetail();
		$quoteDetail->description = $description;
		$quoteDetail->amount = $amount;
		$quoteDetail->quote_response_id = $quoteResponseId;
		$quoteDetail->type = $type;
		$quoteDetail->is_disbursements = $isDisbursements;
		if($quoteDetail->save()){

			//VAT detecting
			if(substr($description, 0, 3)=='VAT'){
				$this->VAT += $amount;
			}
			//`Stamp Duty detecting
			elseif(substr($description, 0, 10)=='Stamp Duty' && $isDisbursements){
				$this->stampDuty = $amount;
			}
			//disbursements counting
			elseif($isDisbursements){
				$this->disbursements += $amount;
			//legal fees counting
			}elseif(!$isDisbursements){
				$this->legalFee += $amount;
			}
		}else{
			throw new \Exception (var_export($quoteDetail->errors, true));
		}
	}
}