<?php

/* @var $this yii\web\View */
/* @var $model common\models\TravelQuote */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $companyIDs string */


$this->registerJsFile(
    '@web/js/travel-quote.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);

$this->title = 'Beach Quote';

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-index">

    <div class="body-content">

        <?php echo $this->render('_quoteForm', [
            'quoteName' => 'Beach Quotes',
            'companyIDs' => $companyIDs,
            'model' => $model
            ]);
        ?>

    </div>
</div>
