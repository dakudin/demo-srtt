<?php

/* @var $this yii\web\View */
/* @var $quote common\models\TravelQuote */
/* @var $companies array */

?>
Dear <?= $quote->getUserFullName() ?>

Thank you for using Sortit.com. We have sent you enquiry to the following suppliers:

<?php
    foreach($companies as $company){
        echo $company['name'] . "\r\n";
    }
?>

They should be in touch with you over the next few days to discuss your requirements and provide you with a personal quotation.
