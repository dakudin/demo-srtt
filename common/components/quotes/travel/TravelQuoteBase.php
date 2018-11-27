<?php

/**
 * Created by Kudin Dmitry.
 * Date: 09.10.2017
 * Time: 17:18
 */

namespace common\components\quotes\travel;

use common\components\quotes\QuoteBase;
use common\models\QuoteCompany;
use common\models\TravelQuote;

class TravelQuoteBase extends QuoteBase
{
    /**
     * @var integer
     */
    protected $categoryId;

    /**
     * @var \common\models\TravelQuote
     */
    protected $quote;

    /**
     * @var TravelParsedResult
     */
    protected $parsedData;

    /**
     * @param TravelQuote $quote Model with new travel quote
     */
    public function __construct(TravelQuote $quote)
    {
        parent::__construct();

        $quoteCompany = QuoteCompany::findOne($this->companyId);

        $this->parsedData = new TravelParsedResult(
            $quoteCompany->id,
            $quoteCompany->company_name,
            $quoteCompany->getFullImage()
        );

        if(is_a($quote, 'common\models\TravelQuote')){
            $this->quote = $quote;
        }
    }

    /**
     * @return TravelParsedResult
     */
    public function getParsedData()
    {
        return $this->parsedData;
    }

    /**
     * @param $pattern string
     * @param $block string
     * @return array
     */
    protected function parseRows($pattern, $block){
        $result = [];

        if(preg_match_all($pattern, $block, $matches)){
            if(isset($matches[1])){
                for($i=1; $i<count($matches); $i++){
                    $result[] = $matches[$i];
                }
            }
        };

        return $result;
    }


}