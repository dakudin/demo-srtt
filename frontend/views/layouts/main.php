<?php

/* @var $this \yii\web\View */
/* @var $content string */
/* @var $termsofuse_url string */
/* @var $privacy_police_url string */

use yii\helpers\Html;
use yii\helpers\Url;
use frontend\widgets\SignInUpFormWidget;
use frontend\widgets\restorepasswordform\RestorePasswordFormWidget;
use frontend\widgets\profileform\ProfileFormWidget;
use frontend\widgets\cookieconsent\CookieConsentWidget;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use frontend\assets\AppAsset;

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title><?= Html::encode($this->title) ?></title>
    <?php echo $this->render('_gtm_head'); ?>
    <?= Html::csrfMetaTags() ?>
    <?php $this->head() ?>
    <script>
        <?php if (Yii::$app->user->isGuest): ?>window.isGuest = true;<?php endif; ?>
    </script>
</head>
<body>
<?php echo $this->render('_gtm_body'); ?>
<?php $this->beginBody() ?>

<div class="global-container">


    <?php
        if(Yii::$app->user->isGuest){
            echo SignInUpFormWidget::widget([]);
            echo RestorePasswordFormWidget::widget([]);
        }else {
            echo ProfileFormWidget::widget([]);
        }

        echo CookieConsentWidget::widget([
                //'cookieConsentStatus' => 'allow',
                'message' => '<b>Cookies:</b> We use cookies to improve your experience on this website. By continuing to browse our website, you are agreeing to use our site cookies. See our '
                    . Html::a('cookie policy', ['site/cookie-policy'], ['target' => '_blank']) . ' for more information on cookies and how to manage them.',
                'dismiss' => 'Accept and continue', //'Got It',
                'allow' => 'Accept and continue',
                'link' => 'More info',
                'href' => Url::to(['site/cookie-policy']),
                'position' => 'top',
                'theme' => 'classic',
                'expiryDays' => 365,
                'target' => '_blank',
                'static' => true,
                'domain' => Yii::$app->params['domain']
            ]);
    ?>

    <div class="wrap">
        <nav class="navbar navbar-default" role="navigation" id="navbar-header">
            <?php echo $this->render('_header') ?>
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

    <?php echo $this->render('_footer'); ?>

</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
