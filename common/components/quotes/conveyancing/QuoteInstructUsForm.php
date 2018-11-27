<?php
/**
 * Created Kudin Dmitry.
 * Date: 26.09.17
 * Time: 15:09
 */

namespace common\components\quotes\conveyancing;


class QuoteInstructUsForm {
	protected $url;
	protected $method;
	protected $params;
	protected $isMultiPartFormData;

	const METHOD_POST = 'POST';
	const METHOD_GET = 'GET';

	public function __construct(){
		$this->url = '';
		$this->method = self::METHOD_GET;
		$this->params = [];
		$this->isMultiPartFormData = false;
	}

	public function setUrl($url){
		$this->url = (string)$url;
	}

	public function setMethod($method){
		if($method==self::METHOD_GET || $method==self::METHOD_POST)
			$this->method = (string)$method;
	}

	public function setParams(array $params){
		foreach($params as $name => $value){
			$this->params[strip_tags((string) $name)] = strip_tags((string) $value);
		}
	}

	public function setIsMultiPartFormData($value){
		if($value === TRUE || $value === FALSE)
			$this->isMultiPartFormData = $value;
	}

	public function getUrl(){
		return $this->url;
	}

	public function getMethod(){
		return $this->method;
	}

	public function getParams(){
		return $this->params;
	}

	public function getIsMultipartFormData(){
		return $this->isMultiPartFormData;
	}
}
