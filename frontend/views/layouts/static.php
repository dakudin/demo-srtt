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
    <?php $this->head() ?>
    <?php echo $this->registerLinkTag(['rel' => 'canonical', 'href' => Url::canonical()]); ?>
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

