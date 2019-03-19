<?php
/**
 * Created by Kudin Dmitry
 * Date: 18.03.2019
 * Time: 22:00
 */

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $quote common\models\TravelQuote */
/* @var $companies array */

$rateLink = Yii::$app->urlManager->createAbsoluteUrl(['site/rate-retailers',
    'category_alias' => $quote->enquiryCategory->alias, 'quote_id' => $quote->id]);

?>
<div>
    <p>Hi <?= Html::encode($quote->getUserFullName()) ?></p>
    <p></p>

    <p>Recently you left an enquiry on Sortit.com</p>
    <p></p>

    <p>Please click this <?php echo Html::a('link', $rateLink); ?> to leave your experience in communication with those retailer(s):</p>
    <p></p>

    <p>
        <?php
        foreach($companies as $company){
            echo Html::encode($company['name']).'<br>';
        }
        ?>
    </p>

</div>
