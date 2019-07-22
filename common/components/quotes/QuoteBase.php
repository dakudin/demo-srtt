<?php
/**
 * Base class for Automated generate sending form for all types Quote
 * Parse the conveyancing prices of quote
 *
 * @copyright (c) 2017, Kudin Dmitry
 *
 */

namespace common\components\quotes;

use common\components\PageGetter;
use common\components\Logger;

class QuoteBase extends \yii\base\Component {

    public $companyId;

    protected $formSenderSDKPath = '';
    protected $debug = false;
    protected $resultPage = '';
    protected $mainPageUrl = '';

    /**
     * @var bool Set to TRUE for sending quotes to retailers
     */
    protected $sendRealQuote = false;

    protected $pageGetter;
    protected $logger;

    /**
     * The associated array containing full form fields values
     */
    protected $formFields = [];

    public function __construct()
    {
        parent::__construct();

        $this->logger = new Logger($this->debug, $this->formSenderSDKPath . '/debug.log');
        $this->pageGetter = new PageGetter($this->logger);
    }


    public function MakeQuote()
    {
        $this->resultPage = '';

        //fill form params
        if(!$this->fillData()) return false;

        //send request to service
//UNCOMMENT FOR SENDING ENQUIRY
        if($this->sendRealQuote){
            if (!$this->sendForm()) return false;

            //parse data and store into database
//        if(!$this->parseForm()) return false;
        }

        return true;
    }

    protected function fillData()
    {
        return false;
    }

    protected function parseForm()
    {
        return false;
    }

    protected function sendForm()
    {
        return false;
    }

    protected function parseElement($pattern, $content, $fieldName, $saveToLog=true){
        if(preg_match_all($pattern, $content, $matches)){
            return $matches[1][0];
        };

        if($saveToLog)
            $this->log("Didn't find content `$fieldName`");

        return false;
    }

    /**
     * Logging the debugging information to "debug.log"
     *
     * @param  string  $message
     * @return boolean
     */
    protected function log($message)
    {
        return $this->logger->log($message);
    }

    /**
     * Detecting is remote page was gotten correct
     *
     * @param  string  $content
     * @param  string  $pattern
     * @param  string  $message
     * @return boolean
     */
    protected function isPageGood($content, $pattern, $message)
    {
        preg_match($pattern, $content, $token);
        if (empty($token)) {
            $this->log($message . "\r\n" . $content);
            return false;
        }

        return true;
    }

}