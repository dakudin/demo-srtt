<?php
/**
 * Created by Kudin Dmitry.
 * Date: 19.09.17
 * Time: 14:43
 */

namespace common\components\quotes\conveyancing;

class QuoteParsedResult {

	const FIELD_SELLING = 'selling';
	const FIELD_BUYING = 'buying';
	const FIELD_UNDEFINED = 'undefined';

	protected $service;

	protected $thirdParties;

	protected $instructUsForm;

	public $referenceNumber;

	public function __construct(){
		$this->service = [
			'buying' => [],
			'selling' => [],
			'undefined' => []
		];

		$this->thirdParties = [
			'buying' => [],
			'selling' => [],
			'undefined' => []
		];

		$this->instructUsForm = new QuoteInstructUsForm();
	}

	public function getInstructUsForm(){
		return $this->instructUsForm;
	}

	public function setInstructUsForm($url, $method = QuoteInstructUsForm::METHOD_GET, $params = [], $isMultiPartFormData = false){
		$this->instructUsForm->setUrl($url);
		$this->instructUsForm->setMethod($method);
		$this->instructUsForm->setParams($params);
		$this->instructUsForm->setIsMultipartFormData($isMultiPartFormData);
	}

	public function getService(){
		return $this->service;
	}

	public function getThirdParties(){
		return $this->thirdParties;
	}

	public function addToService($field, $title, $price){
		if($field==self::FIELD_BUYING || $field==self::FIELD_SELLING || $field==self::FIELD_UNDEFINED){
			$this->service[$field][$title] = (float)$price;
		}
	}

	public function addToThirdParties($field, $title, $price){
		if($field==self::FIELD_BUYING || $field==self::FIELD_SELLING || $field==self::FIELD_UNDEFINED){
			$this->thirdParties[$field][$title] = (float)$price;
		}
	}

} 