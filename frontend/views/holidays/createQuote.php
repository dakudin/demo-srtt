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

$canonical_url = Yii::$app->request->hostInfo . '/' . Yii::$app->request->pathInfo;
$this->title = $category->seo_title;
$this->registerMetaTag(['name' => 'description', 'content' => $category->seo_description], 'description');
$this->registerMetaTag(['name' => 'keywords', 'content' => $category->seo_keyword], 'keywords');
$this->registerLinkTag(['rel' => 'canonical', 'href' => $canonical_url], 'canonical');

Yii::$app->params['og_url']['content'] = $canonical_url;
Yii::$app->params['og_title']['content'] = $category->og_title;
Yii::$app->params['og_description']['content'] = $category->og_description;
Yii::$app->params['og_image']['content'] = Yii::$app->request->hostInfo . $category->og_image;
$this->registerMetaTag(Yii::$app->params['og_url'], 'og_url');

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
