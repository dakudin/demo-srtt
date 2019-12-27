<?php
/**
 * Created by Kudin Dmitry
 * Date: 14.03.2019
 * Time: 19:56
 */

/* @var $this yii\web\View */
/* @var $ratedStatus integer */

use common\components\QuoteHelper;
use common\components\Helper;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

if (Yii::$app->user->isGuest){
    $this->registerJS('$("#login-modal").modal("show");', $this::POS_READY);
}

$this->title = 'Retailers Rating Selection | Sortit';

$this->params['breadcrumbs'][] = $this->title;
?>

<?php if($ratedStatus != QuoteHelper::QUOTE_RATED): ?>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <h3 class="pull-left title quote-form__title"><?= $this->title ?></h3>
    </div>
<?php endif; ?>

<?php if(!Yii::$app->user->isGuest): ?>

<div class="col-xs-12 col-sm-12 col-md-5">
    <div class="panel panel-default fieldGroupRetailers">
        <div class="panel-heading">
            <h2 class="panel-title panel_title_m"><?php echo Html::encode($categoryName); ?> quote detail</h2>
        </div>

        <div class="panel-body">
            <?php

                $info = $model->getFullQuoteInfo();
                foreach($info as $item):
            ?>
                    <p><?= $item; ?></p>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<div class="col-xs-12 col-sm-12 col-md-7">
    <div class="panel panel-default fieldGroupRetailers">
        <div class="panel-heading">
            <h2 class="panel-title panel_title_m">
                <?php if($ratedStatus != QuoteHelper::QUOTE_RATED)
                        echo 'Please rate your experience in communications with those retailers';
                    else
                        echo 'You rated retailers as';
                ?>
            </h2>
        </div>

        <div class="panel-body">
            <?php
                $form = ActiveForm::begin([
                    'options' => ['class' => 'form-horizontal'],
                ]);

                $retailers = QuoteHelper::getRetailersInfoByEnquiryResult($model->parsed_results);
                foreach($retailers as $retailerId=>$retailer):
            ?>
                    <?php if($ratedStatus != QuoteHelper::QUOTE_RATED): ?>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <h4><?php echo Html::encode($retailer['name']) ?></h4>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center nopadding">
                                <label><input type="radio" name="rate_retailer[<?= $retailerId ?>]" value="2.5"><img src="/images/rate-poor.png"></label>
                                <label><input type="radio" name="rate_retailer[<?= $retailerId ?>]" value="5"><img src="/images/rate-neutral.png"></label>
                                <label><input type="radio" name="rate_retailer[<?= $retailerId ?>]" value="7.5" checked><img src="/images/rate-good.png"></label>
                                <label><input type="radio" name="rate_retailer[<?= $retailerId ?>]" value="10"><img src="/images/rate-excellent.png"></label>
                        </div>
                    </div>
                    <?php elseif($ratedStatus == QuoteHelper::QUOTE_RATED): ?>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <h4 class="pull-left"><?php echo Html::encode($retailer['name']) ?>
                            <?php if ( !empty($retailer['rated'])): ?>
                                <img src="<?php echo Helper::getRateImageByRetailerId($retailer['rated']); ?>">
                            <?php endif; ?>
                            </h4>
                        </div>
                    <?php endif; ?>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <hr class="fancy-line" />
                        </div>
                    </div>
            <?php
                endforeach;
            ?>

            <div class="col-xs-12 text-center">
                <?php if($ratedStatus != QuoteHelper::QUOTE_RATED)
                        echo Html::submitButton('Rate', ['class' => 'btn btn-form']);
                    else
                        echo Html::a('Home', Yii::$app->homeUrl, ['class' => 'btn btn-form']);
                ?>
            </div>
            <?php ActiveForm::end() ?>
        </div>
    </div>
</div>
<?php endif; ?>
