<?php

/* @var $this yii\web\View */
/* @var $model common\models\TravelQuote */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $companyIDs string */

$this->registerJsFile(
    '@web/js/travel-quote.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);

$this->title = 'Skiing Quote';

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-index">

    <div class="body-content">

        <?php echo $this->render('_quoteForm', [
            'quoteName' => 'Skiing Holidays',
            'companyIDs' => $companyIDs,
            'model' => $model
        ]);
        ?>

    </div>
</div>
