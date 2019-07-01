<?php

/**
 * Created by Kudin Dmitry.
 * Date: 28.06.2019
 * Time: 18:30
 */

namespace common\components\quotes\travel\bestattravel;

use Yii;
use common\components\quotes\travel\TravelQuoteBase;
use common\models\TravelQuote;

//https://www.bestattravel.co.uk/contact-us?PageId=31958#enquiry
class BestAtTravelQuote extends TravelQuoteBase
{

    /**
     * @param TravelQuote $quote
     * @param integer $companyId
     * @param boolean $sendRealQuote
     */
    public function __construct(TravelQuote $quote, $companyId, $sendRealQuote){
        $this->companyId = $companyId;
        $this->categoryId = $quote->category_id;
        $this->mainPageUrl = 'https://www.eshores.co.uk/';
        $this->formSenderSDKPath = dirname(__FILE__);
        $this->debug=true;
        $this->sendRealQuote = $sendRealQuote;

        parent::__construct($quote);
    }


}