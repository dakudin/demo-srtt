<?php

/* @var $this \yii\web\View */
/* @var $content string */
/* @var $termsofuse_url string */
/* @var $privacy_police_url string */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use frontend\assets\AppAsset;
use yii\helpers\Url;

AppAsset::register($this);

$this->params['footer_links'] = [
    'termsofuse_url' => Yii::$app->urlManager->createAbsoluteUrl('terms-of-use'),
    'privacy_police_url' => Yii::$app->urlManager->createAbsoluteUrl('privacy-policy'),
];

$this->registerLinkTag(['rel' => 'canonical', 'href' => Url::canonical()], 'canonical');
Yii::$app->params['og_url']['content'] = Url::canonical();

$this->beginPage(); ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= Html::encode($this->title) ?></title>
    <?php echo $this->render('_gtm_head'); ?>
    <?= Html::csrfMetaTags() ?>
    <?php
        $this->registerMetaTag(Yii::$app->params['og_title'], 'og_title');
        $this->registerMetaTag(Yii::$app->params['og_description'], 'og_description');
        $this->registerMetaTag(Yii::$app->params['og_url'], 'og_url');
        $this->registerMetaTag(Yii::$app->params['og_image'], 'og_image');
        $this->registerMetaTag(Yii::$app->params['og_type'], 'og_type');
        $this->registerMetaTag(Yii::$app->params['og_locale'], 'og_locale');
        $this->registerMetaTag(Yii::$app->params['fb_app_id'], 'fb_app_id');
    ?>
    <?php $this->head() ?>
</head>
<body>
<?php echo $this->render('_gtm_body'); ?>
<?php $this->beginBody() ?>

<div class="global-container">

    <div class="wrap">

        <nav class="navbar navbar-default" role="navigation">
            <a class="navbar-brand" href="<?= Yii::$app->homeUrl; ?>">
                <img src="/images/sortit.png" alt="SortIt" class="logo">
            </a>
        </nav>

        <div class="container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                'activeItemTemplate' => "<!--noindex--><li class=\"active\">{link}</li><!--/noindex-->\n",
            ]) ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </div>

<?php echo $this->render('_footer') ?>

</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

