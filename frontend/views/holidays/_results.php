<?php

use yii\helpers\Html;

/* @var $instantQuote common\models\TravelQuote*/
/* @var $instantQuote common\models\TravelQuote*/
/* @var $quoteServices array */
/* @var $quoteService common\components\quotes\travel\TravelParsedResult */

if(count($quoteServices)==0){
    echo '<div class="alert alert-success" role="alert"><h4>Sorry no details were found per your request. Please adjust your parameters and try again.</h4></div>';
}

foreach($quoteServices as $quoteService){
    if(is_a($quoteService, 'common\components\quotes\travel\TravelParsedResult')){
        foreach($quoteService->resorts as $resortIndex => $resort){
            ?>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="media">
                        <div class="media-left col-xs-3 col-sm-3 col-md-3">
                            <a href="<?= $resort['detailUrl']; ?>" class="thumbnail" target="_blank">
                                <?= Html::img($resort['imgUrl'], [
                                    'class' => 'img-responsive', //media-object
                                    'alt' => $resort['hotelName']
                                ]);?>
                            </a>
                        </div>
                        <div class="media-body">
                            <div class="media">
                                <div class="media-body">
                                    <h4 class="media-heading text-primary"><?= $resort['hotelName']; ?></h4>
                                    <h5 class="media-heading"><b><?= $resort['resort']; ?></b></h5>
                                    <h5 class="media-heading" style="border-bottom: 1px solid #ddd;"></h5>
                                    <p class="media-heading">
                                        <?php
                                        for($i=1; $i<=$resort['hotelStar']; $i++) {
                                            echo '<span class="glyphicon glyphicon-star" aria-hidden="true"></span>';
                                        }
                                        ?>
                                    </p>


                                    <p class="media-heading">
                                        <?php
                                        foreach($resort['info'] as $info) {
                                            echo '<span style="padding:0 6px 0 0">'.$info.'</span>';
                                        }
                                        ?>
                                    </p>
                                    <h5 class="media-heading" style="border-bottom: 1px solid #ddd;"></h5>
                                    <p><?= $resort['description']; ?></p>
                                </div>
                                <div class="media-right">
                                    <p>
                                        <?= Html::img($quoteService->companyUrl, [
                                            'class' => 'img-responsive', //media-object
                                            'alt' => $quoteService->companyName
                                        ]);?>
                                    </p>
                                    <?php if($resort['price']!=0){ ?>
                                        <p>Prices From</p>
                                        <h4>
                                            <span class="text-danger">&pound;<?= $resort['price']; ?></span>
                                            <small>per person</small>
                                        </h4>
                                    <?php } else { ?>
                                        <p>Contact Us</p>
                                        <?php
                                    }

                                    if(\common\components\Helper::isShowSendEnquiryButton($quoteService->companyId)) {
                                        echo Html::a(
                                            'Send Enquiry >',
                                            \yii\helpers\url::to(['holidays/skienquiry', 'id' => $instantQuote->id, 'company_id' => $quoteService->companyId, 'resort_id' => $resortIndex]),
                                            [
                                                'class' => 'btn btn-primary',
                                            ]
                                        );
                                    }else {
                                        echo Html::a(
                                            'More Details >',
                                            $resort['detailUrl'],
                                            [
                                                'class' => 'btn btn-primary',
                                                'target' => '_blank'
                                            ]
                                        );
                                    }
                                    ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    }
}
?>
