<?php

/* @var $this yii\web\View */
/* @var $model common\models\TravelQuote */
/* @var $category common\models\EnquiryCategory */
/* @var $form yii\bootstrap\ActiveForm */

use yii\helpers\Url;

$this->registerJsFile(
    '@web/js/travel-quote.js?v=0.14',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);

$this->title = $category->seo_title;
$this->registerMetaTag(['name' => 'description', 'content' => $category->seo_description], 'description');
$this->registerMetaTag(['name' => 'keywords', 'content' => $category->seo_keyword], 'keywords');
$this->registerLinkTag(['rel' => 'canonical', 'href' => Yii::$app->request->hostInfo . '/' . Yii::$app->request->pathInfo], 'canonical');


$this->params['breadcrumbs'] = \frontend\helpers\FHelper::getEnquiryCategoryBreadcrumbs($category);
?>
<div class="site-index">

    <div class="body-content">

        <?php echo $this->render('_quoteForm', [
            'category' => $category,
//            'companyIDs' => $companyIDs,
            'retailers' => $retailers,
            'model' => $model
        ]);
        ?>

    </div>
</div>
