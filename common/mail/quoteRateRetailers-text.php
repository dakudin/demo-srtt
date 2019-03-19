<?php
/**
 * Created Kudin Dmitry
 * Date: 18.03.2019
 * Time: 22:00
 */

/* @var $this yii\web\View */
/* @var $quote common\models\TravelQuote */
/* @var $companies array */

$rateLink = Yii::$app->urlManager->createAbsoluteUrl(['site/rate-retailers',
    'category_alias' => $quote->enquiryCategory->alias, 'quote_id' => $quote->id]);

?>
Hi <?= $quote->getUserFullName() ?>

Recently you left an enquiry on Sortit.com
Please click this link below to leave your experience in communication with those retailer(s):

<?php
foreach($companies as $company){
    echo $company['name'] . "\r\n";
}
?>

<?= $rateLink ?>