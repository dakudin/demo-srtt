<?php
/**
 * Created by Kudin Dmitry
 * Date: 16.03.2019
 * Time: 19:11
 */

namespace console\controllers;

use common\components\QuoteHelper;
use Yii;
use yii\console\Controller;
use yii\helpers\Console;
use common\models\QuoteHistorySearch;

class QuoteController extends Controller
{
    public function actionSendRateEmail()
    {
        $searchModel = new QuoteHistorySearch();
        $quotes = $searchModel->getNotRatedQuotes();

        $this->stdout("Start sending email for rating retailers.\n", Console::FG_YELLOW);

        $this->stdout("Emails count: " . count($quotes) . ".\n");

        foreach($quotes as $quote){
            $message = "Rate email for user `{$quote->getUserFullName()}` by email `{$quote->email}` (category: {$quote->enquiryCategory->name}; id: {$quote->id})";

            if($this->sendRateEmailToRetailer($quote)) {

                $quote->updateAttributes(['is_rate_email_sent' => QuoteHelper::QUOTE_RATE_EMAIL_SENT]);

                $this->stdout($message . " was sent.\n");


            }else
                $this->stdout($message ." wasn't sent.\n");
        }

        return self::EXIT_CODE_NORMAL;

    }

    /**
     * Send an auto email to go to the resistant
     * @return bool
     */
    protected function sendRateEmailToRetailer($quote){
        $companies = QuoteHelper::getRetailersInfoByEnquiryResult($quote->parsed_results);

        return Yii::$app->mailer->compose(
            ['html' => 'quoteRateRetailers-html', 'text' => 'quoteRateRetailers-text'],
            ['quote' => $quote, 'companies' => $companies]
        )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($quote->email)
            ->setSubject('Your experience in communication with retailers')
            ->send();
    }


}