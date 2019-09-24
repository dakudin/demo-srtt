<?php
use yii\helpers\Html;
$isHomePage = ((Yii::$app->controller->id === Yii::$app->defaultRoute) && (Yii::$app->controller->action->id === Yii::$app->controller->defaultAction)) ? true : false;
?>
<!-- Brand and toggle get grouped for better mobile display -->
<div class="navbar-header">
    <button type="button" class="navbar-left navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
    <?php
    if (!Yii::$app->user->isGuest) {
        echo Html::button('<i class="glyphicon glyphicon-user"></i>', [
            'class' => 'navbar-right navbar-toggle btn',
            'onClick' => '$("#profile-modal").modal("show")'
        ]);
    }
    ?>
</div>
<a class="navbar-brand" href="<?= Yii::$app->homeUrl; ?>" <?= $isHomePage ? 'rel="nofollow"' : '' ?>>
    <img src="/images/sortit.png" alt="SortIt" class="logo">
</a>
<!-- Collect the nav links, forms, and other content for toggling -->
<div class="collapse navbar-collapse" id="navbar-collapse-1">

    <ul class="nav navbar-nav navbar-left">
        <li><a href="<?= \yii\helpers\Url::to(['/site/contact']) ?>">Contact us</a></li>
        <li><a href="<?= \yii\helpers\Url::to(['/site/about']) ?>">About us</a></li>
    </ul>

    <ul class="nav navbar-nav navbar-left">
        <?php if (Yii::$app->user->isGuest){ ?>
            <li><?php echo Html::a('Register', '#', ['onClick' => '$(".nav-tabs a[href=\'#tab_register\']").tab("show"); $("#login-modal").modal("show")']); ?></li>
            <li><?php echo Html::a('Sign in', '#', ['onClick' => '$(".nav-tabs a[href=\'#tab_signin\']").tab("show"); $("#login-modal").modal("show")']); ?></li>
        <?php } else { ?>
                <li><a href="<?= \yii\helpers\Url::to(['/site/history-quotes']) ?>">My quotes</a></li>
                <li><a href="#" data-toggle="modal" data-target="#profile-modal">Profile</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-left">
            <?php
            echo '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>';
        } ?>
    </ul>
</div><!-- /.navbar-collapse -->