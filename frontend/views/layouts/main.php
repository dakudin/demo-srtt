<?php

/* @var $this \yii\web\View */
/* @var $content string */
/* @var $termsofuse_url string */
/* @var $privacy_police_url string */

//use yii\bootstrap\Nav;
//use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\widgets\LoginFormWidget;
use frontend\widgets\SignupFormWidget;
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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <script>
        <?php if (Yii::$app->user->isGuest): ?>window.isGuest = true;<?php endif; ?>
    </script>
</head>
<body>
<?php $this->beginBody() ?>

<div class="global-container">


    <?php
        if(Yii::$app->user->isGuest){
            echo SignupFormWidget::widget([]);
            echo LoginFormWidget::widget([]);
            echo RestorePasswordFormWidget::widget([]);
        }else {
            echo ProfileFormWidget::widget([]);
        }

        echo CookieConsentWidget::widget([
                'message' => 'We use cookies to improve your experience on this website. By continuing to browse our website, you are agreeing to use our site cookies. See our cookie policy for more information on cookies and how to manage them.',
                'dismiss' => 'Got It',
                'link' => 'More info',
                'href' => Url::to('cookie-policy'),
                'position' => 'top',
                'theme' => 'classic',
                'expiryDays' => 365,
                'target' => '_blank',
                'static' => true,
                'domain' => Yii::$app->params['domain']
            ]);
    ?>

    <div class="wrap">
        <?php

/*
        NavBar::begin([
//            'brandLabel' => 'SortIt', //
            'brandLabel' => '<img src="/images/sortit.png" alt="SortIt" class="logo">', //
            'brandUrl' => Yii::$app->homeUrl,
            'brandOptions' => [
//                'style' => 'padding: 0 0 0 50px'
            ],

            'options' => [
                'class' => 'navbar navbar-fixed-top container-fluid', //navbar navbar-static-top
    //			'style' => 'background-color: #337ab7'
            ],
        ]);

        $menuItems = [
            ['label' => 'Conveyancing', 'url' => ['/quotes/index']],
            ['label' => 'Travel', 'url' => ['/travel/index']],
        ];

        if (Yii::$app->user->isGuest) {
            $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
            $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
        } else {
            $menuItems[] = '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>';
        }

        echo Nav::widget([
//            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => $menuItems,
        ]);

        NavBar::end();
*/
        ?>
        <nav class="navbar navbar-default" role="navigation" id="navbar-header">
            <?php echo $this->render('_header') ?>
        </nav>

        <div class="container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
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
