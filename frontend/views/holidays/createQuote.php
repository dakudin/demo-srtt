<?php

/* @var $this yii\web\View */
/* @var $model common\models\TravelQuote */
/* @var $category common\models\EnquiryCategory */
/* @var $form yii\bootstrap\ActiveForm */

$this->registerJsFile(
    '@web/js/travel-quote.js?v=0.13',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);

$this->title = $category->name . ' Quote';

$this->params['breadcrumbs'] = \frontend\helpers\FHelper::getEnquiryCategoryBreadcrumbs($category);
?>
<div class="site-index">

    <div class="body-content">

        <?php echo $this->render('_quoteForm', [
            'quoteName' => $category->name . ' Quotes',
//            'companyIDs' => $companyIDs,
            'retailers' => $retailers,
            'model' => $model
        ]);
        ?>

    </div>
</div>
