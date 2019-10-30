<?php
use yii\helpers\Html;
use common\models\CompanyRating;

/* @var $this yii\web\View */
/* @var $quoteRetailers array */
/* @var $quoteInfo string */
/* @var $categoryName string */

$this->title = 'New enquiry';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h3>Your enquiry was sent successfully to <?= count($quoteRetailers); ?> selected retailers:</h3>

    <div class="row">
        <?php
            foreach($quoteRetailers as $retailer):
        ?>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <?= Html::encode($retailer['name']); ?>

                    <span class="small"><?= Html::encode($retailer['rating']); ?> (<?= Html::encode(CompanyRating::getReviewCaption($retailer['reviews'])); ?>)</span>
            </div>
        <?php
            endforeach;
        ?>
        <div class="col-xs-12 col-sm-12 col-md-12"><p></p>
        </div>
    </div>
    <div class="row">
        <div id="new-enquiry-details" class="alert alert-info" data-category="<?= Html::encode($categoryName); ?>">
            <?php echo $quoteInfo; ?>
        </div>
    </div>
</div>
