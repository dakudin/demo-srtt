<?php
/**
 * Created Kudin Dmitry
 * Date: 09.10.2017
 * Time: 14:33
 */

namespace common\components;

use Yii;
use yii\base\Exception;

class PageGetter
{

    static protected $userAgents = [
        'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_3) AppleWebKit/602.4.8 (KHTML, like Gecko) Version/10.0.3 Safari/602.4.8',
        'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36',
        'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36',
    ];

    /**
     * @var string user agent for browser emulation
     */
    protected $userAgent;

    /**
     * @var \common\components\Logger object for log debug and/or error info
     */
    protected $logger;

    /**
     * @var array of parameters for header request
     */
    protected $header;

    /**
     * @param \common\components\Logger $logger
     */
    public function __construct($logger)
    {
        $this->userAgent = $this->getUserAgent();
        $this->logger = $logger;
    }

    /**
     * Return random user agent for request
     *
     * @return string
     */
    static protected function getUserAgent()
    {
        return self::$userAgents[rand(0, count(self::$userAgents)-1)];
    }

    /**
     * @return array HTTP header
     */
    protected function getHttpHeader()
    {
        $this->header = [
            'Accept:text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8',
            'Accept-Encoding:gzip, deflate',
            "Accept-Language: en-us,en;q=0.5",
            "Accept-Charset: utf-8;q=0.7,*;q=0.7",
            "User-Agent: " . $this->userAgent,
            //            "Origin: " . $origin,
            "Connection: keep-alive",
        ];
    }

    /**
     * @return array HTTP header for JSON request
     */
    protected function getJsonHttpHeader()
    {
        $this->header = [
            'Accept: application/json',
            'Accept-Encoding:gzip, deflate',
            "Accept-Language: en-us,en;q=0.5",
            'Content-type: application/json',
            "User-Agent: " . $this->userAgent,
            "Connection: keep-alive",
        ];
    }

    /**
     * @return array HTTP header
     */
    protected function getAjaxHeader()
    {
        $this->header = [
            'Accept: application/json, text/javascript, */*; q=0.01',
            'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
            'X-Requested-With: XMLHttpRequest',
            'Accept-Encoding:gzip, deflate',
            "Accept-Language: en-us,en;q=0.5",
            "User-Agent: " . $this->userAgent,
            "Connection: keep-alive",
        ];
    }

    /**
     * Send a request to site and return the response as an array.
     *
     * @param string $url  The url for request.
     * @param string $method  The request method.
     * @param array|string $params  The data to post.
     * @param string $referrerUrl  The referrer url
     * @param boolean $isMultipartForm  Need to send or not form as multipart/form-data
     * @param boolean $asJSON If need to send data in JSON format
     * @param boolean $asAJAX If need to send AJAX request
     *
     * @return array The response from the site.
     */
    public function sendRequest($url, $method='GET', $params=array(), $referrerUrl='', $isMultipartForm=false, $asJSON=false, $asAJAX=false)
    {
        set_time_limit(60);
        $output = [];

        if($asJSON)
            $this->getJsonHttpHeader();
        else
            $this->getHttpHeader();

        if($asAJAX)
            $this->getAjaxHeader();

        if(!$isMultipartForm){
            if(!$asJSON){
                //if $param is string value than use it as is, without encoding
                if(is_array($params)) {
                    $params = http_build_query($params, '', '&');
                }
            }else{
                $params = json_encode($params);
            }
            $this->header[] = 'Content-Length: ' . strlen($params);
        }
        else {
            $postFieldsDelimiter = uniqid('------WebKitFormBoundary');
            $params = BodyPost::Get($params, $postFieldsDelimiter);
            $this->header[] = 'Content-Type: multipart/form-data; boundary=' . $postFieldsDelimiter;
            $this->header[] = 'Content-Length: ' . strlen($params);
        }

//        Yii::error($this->header);
//        Yii::error("Params - " . PHP_EOL . $params);
//        $rawResponse = '<p> Thank you for your enquiry, please note:</p>';

        $curlSession = curl_init($url . ($method == 'GET' && $params ? '?' . $params : ''));

        curl_setopt($curlSession, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curlSession, CURLOPT_MAXREDIRS, 10);
//		curl_setopt($curlSession, CURLOPT_HEADER, true);
        curl_setopt($curlSession, CURLOPT_VERBOSE, true);
        //        curl_setopt($curlSession, CURLINFO_HEADER_OUT, true);
        curl_setopt($curlSession, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlSession, CURLOPT_REFERER, $referrerUrl);
        curl_setopt($curlSession, CURLOPT_HTTPHEADER, $this->header);
        curl_setopt($curlSession, CURLOPT_TIMEOUT, 30);
        //		curl_setopt($curlSession, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($curlSession, CURLOPT_COOKIEFILE, ''); //FORMSENDER_SDK_PATH."/cookies1.txt");
        //		curl_setopt($curlSession, CURLOPT_COOKIEJAR, FORMSENDER_SDK_PATH."/cookies1.txt");
        curl_setopt($curlSession, CURLOPT_ENCODING, "gzip");

        if ($method == 'POST') {
            curl_setopt($curlSession, CURLOPT_POST, true);
            curl_setopt($curlSession, CURLOPT_POSTFIELDS, $params);
        } elseif ($method == 'HEAD') {
            curl_setopt($curlSession, CURLOPT_HEADER, true);
            curl_setopt($curlSession, CURLOPT_NOBODY, true);
        } else {
            curl_setopt($curlSession, CURLOPT_HTTPGET, true);
        }

        $rawResponse = curl_exec($curlSession);

        $httpCode = curl_getinfo($curlSession, CURLINFO_HTTP_CODE);

        //if follow location doesn't work correctly
        if($httpCode == 301 || $httpCode == 302 || $httpCode == 303 || $httpCode == 307){
            $newUrl = trim(curl_getinfo($curlSession)['url']);
            $this->logger->log("Redirect to URL - " . PHP_EOL . $newUrl);
            curl_close($curlSession);
            return $this->sendRequest($newUrl);
        }

        if ($httpCode !== 200){
            $output['Status'] = "FAIL";
            $output['StatusDetails'] = "Server Response: " . $httpCode;
            $output['Response'] = $rawResponse;

            Yii::error("Requested url:" . PHP_EOL . $url);
            Yii::error("Requested params:" . PHP_EOL . $params);
            Yii::error("Info:" . PHP_EOL . var_dump(curl_getinfo($curlSession)));
            Yii::error("Response:" . PHP_EOL . $rawResponse);

            return $output;
        }

        if (curl_error($curlSession))
        {
            $output['Status'] = "FAIL";
            $output['StatusDetails'] = curl_error($curlSession);
            $output['Response'] = $rawResponse;

            Yii::error("Requested url:" . PHP_EOL . $url);
            Yii::error("Requested params:" . PHP_EOL . $params);
            Yii::error("Info:" . PHP_EOL . var_dump(curl_getinfo($curlSession)));
            Yii::error("Response:" . PHP_EOL . $rawResponse);
            return $output;
        }

        curl_close($curlSession);

        Yii::error("Server response is - " . PHP_EOL . $rawResponse);

        $output['Status'] = 'OK';
        $output['Response'] = $rawResponse;

        return $output;
    }

}