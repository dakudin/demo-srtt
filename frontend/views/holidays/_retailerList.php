<?php

use yii\helpers\Html;
//use kartik\switchinput\SwitchInput;
use kartik\popover\PopoverX;
use common\widgets\IosStyleSwitch\IosStyleSwitch;
use common\models\CompanyRating;


/* @var $model common\models\TravelQuote */
/* @var $retailers array of common\models\QuoteCompany */
?>
<div class="col-xs-12 col-sm-12 col-md-12"><p></p></div>
<div class="col-xs-12 col-sm-12 col-md-12">
    <div class="panel panel-default fieldGroupRetailers">
        <div class="panel-heading">
            <h2 class="panel-title panel_title_m">Select retailers you want to deal with</h2>
        </div>

        <div class="panel-body">

            <?php
                foreach($retailers as $retailer):
            ?>
            <div class="row">
                <div class="col-xs-7 col-sm-8 col-md-9 vcenter">
                    <?php
                        echo Html::img('../../images/companies/'.$retailer['image'], [
                            'class' => 'img-responsive img-thumbnail',
                            'alt' => Html::encode($retailer['company_name'])
                        ]);
                    ?>
                    <?php
                        echo PopoverX::widget([
                            'header' => '<span class="panel_title_m">' . Html::encode($retailer['company_name']) . '</span>',
                            'placement' => PopoverX::ALIGN_BOTTOM_LEFT,
                            'content' => '<div><span class="label label-rating pull-right"><h5>'. Html::encode($retailer['rating'])
                                . '</h5><h5 class="small">' . Html::encode(CompanyRating::getReviewCaption($retailer['reviews']))
                                . '</h5></span></div><div class="text-justify">' . Html::encode($retailer['info']) . '</div>',
                            'closeButton' => ['style' => 'display:inline'],
                            'toggleButton' => [
                                'label' => Html::encode($retailer['company_name']) . '<i class="glyphicon glyphicon-info-sign">&nbsp;</i>',
                                'class' => 'quote-form__retailer-title',
                                'tag' => 'a',
                                'style' => '',
                                //                                'style' => 'border-bottom: 1px dashed #999;color: black; text-decoration: none;'
                            ],
                        ]);
                        ?>
                </div><!--
             --><div class="col-xs-2 col-sm-2 col-md-2 vcenter">
                    <h3><?= Html::encode($retailer['rating']); ?></h3>
                    <h5><?= Html::encode(CompanyRating::getReviewCaption($retailer['reviews'])); ?></h5>
                </div><!--
             --><div class="col-xs-2 col-sm-2 col-md-1 vcenter">
                    <?php
                        echo IosStyleSwitch::widget([
                            'type' => IosStyleSwitch::CHECKBOX,
                            'name' => 'TravelQuote[quoteCompanyIDs][' . $retailer['id'] .']',
                            'value' => 1,
                            'onTurnOn' => 'quoteChangeHandler();',
                            'onTurnOff' => 'quoteChangeHandler();',
                        ]);
                    ?>
                 </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <hr class="fancy-line" />
                </div>
            </div>
            <?php
                endforeach;
            ?>
        </div>
    </div>
</div>
