<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $quote common\models\TravelQuote */
/* @var $companies array */
?>
<div>
    <p>Dear <?= Html::encode($quote->getUserFullName()) ?></p>
    <p></p>

    <p>Thank you for using Sortit.com. We have sent you enquiry to the following suppliers:</p>
    <p></p>

    <p>
        <?php
            foreach($companies as $company){
                echo Html::encode($company['name']).'<br>';
            }
        ?>
    </p>

    <p></p>
    <p>They should be in touch with you over the next few days to discuss your requirements and provide you with a personal quotation.</p>
</div>
