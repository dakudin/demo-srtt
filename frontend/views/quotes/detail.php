<?php

use yii\helpers\Html;
use common\models\QuoteResponseDetail;
use common\components\Helper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $quoteResult common\models\QuoteResponse */

$this->title = 'Conveyancing';
$this->params['breadcrumbs'][] =
    [
        'label' => $this->title,
        'url' => ['quotes/show', 'id' => $quoteResult->instant_quote_id]
    ];

$this->params['breadcrumbs'][] = $quoteResult->quoteCompany->company_name;

?>
<div class="quote-response-index">

    <h3>Hi - Here is your fixed price quote</h3>

    <div class="col-xs-12" style="padding: 1em 0">
        <?php echo Html::img('../../images/companies/'.$quoteResult->quoteCompany->image, [
            'class' => 'img-responsive center-block img-thumbnail',
            'alt' => Html::encode($quoteResult->quoteCompany->company_name)
        ]);
        ?>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12 bg-primary">
        <h4>What you pay us for our services</h4>
    </div>
    <?php

    if(count($dataProvider['self']['items']['buying'])>0):
        ?>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <strong>For Buying</strong>
        </div>
        <?php
        foreach ($dataProvider['self']['items']['buying'] as $description=>$amount):
            ?>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="col-xs-6 col-sm-6 col-md-8"><?= $description ?></div>
                <div class="col-xs-6 col-sm-6 col-md-4"><?= Helper::getQuotePriceForView($amount); ?></div>
            </div>
            <?php
        endforeach;
    endif;
    ?>


    <?php
    if(count($dataProvider['self']['items']['selling'])>0):
        ?>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <strong>For Selling</strong>
        </div>
        <?php
        foreach ($dataProvider['self']['items']['selling'] as $description=>$amount):
            ?>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="col-xs-6 col-sm-6 col-md-8"><?= $description ?></div>
                <div class="col-xs-6 col-sm-6 col-md-4"><?= Helper::getQuotePriceForView($amount); ?></div>
            </div>
            <?php
        endforeach;
    endif;
    ?>

    <?php
    if(count($dataProvider['self']['items']['undefined'])>0):
        foreach ($dataProvider['self']['items']['undefined'] as $description=>$amount):
            ?>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="col-xs-6 col-sm-6 col-md-8"><?= $description ?></div>
                <div class="col-xs-6 col-sm-6 col-md-4"><?= Helper::getQuotePriceForView($amount); ?></div>
            </div>
            <?php
        endforeach;
    endif;
    ?>

    <div class="col-xs-12 col-sm-12 col-md-12" style="background-color: #e0e0e0">
        <div class="col-xs-6 col-sm-6 col-md-8" style="padding:0!important"><strong>Sub-total</strong></div>
        <div class="col-xs-6 col-sm-6 col-md-4"><?= Helper::getQuotePriceForView($dataProvider['self']['sub-total']); ?></div>
    </div>



    <div class="col-xs-12 col-sm-12 col-md-12">
        &nbsp;
    </div>



    <div class="col-xs-12 col-sm-12 col-md-12 bg-primary">
        <h4>Additional costs paid to third parties</h4>
    </div>
    <?php

    if(count($dataProvider['other']['items']['buying'])>0):
        ?>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <strong>For Buying</strong>
        </div>
        <?php
        foreach ($dataProvider['other']['items']['buying'] as $description=>$amount):
            ?>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="col-xs-6 col-sm-6 col-md-8"><?= $description ?></div>
                <div class="col-xs-6 col-sm-6 col-md-4"><?= Helper::getQuotePriceForView($amount); ?></div>
            </div>
            <?php
        endforeach;
    endif;
    ?>


    <?php
    if(count($dataProvider['other']['items']['selling'])>0):
        ?>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <strong>For Selling</strong>
        </div>
        <?php
        foreach ($dataProvider['other']['items']['selling'] as $description=>$amount):
            ?>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="col-xs-6 col-sm-6 col-md-8"><?= $description ?></div>
                <div class="col-xs-6 col-sm-6 col-md-4"><?= Helper::getQuotePriceForView($amount); ?></div>
            </div>
            <?php
        endforeach;
    endif;
    ?>

    <?php
    if(count($dataProvider['other']['items']['undefined'])>0):
        foreach ($dataProvider['other']['items']['undefined'] as $description=>$amount):
            ?>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="col-xs-6 col-sm-6 col-md-8"><?= $description ?></div>
                <div class="col-xs-6 col-sm-6 col-md-4"><?= Helper::getQuotePriceForView($amount); ?></div>
            </div>
            <?php
        endforeach;
    endif;
    ?>

    <div class="col-xs-12 col-sm-12 col-md-12" style="background-color: #e0e0e0">
        <div class="col-xs-6 col-sm-6 col-md-8" style="padding:0!important"><strong>Sub-total</strong></div>
        <div class="col-xs-6 col-sm-6 col-md-4"><?= Helper::getQuotePriceForView($dataProvider['other']['sub-total']); ?></div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        &nbsp;
    </div>



    <div class="col-xs-12 col-sm-12 col-md-12 bg-primary">
        <div class="col-xs-6 col-sm-6 col-md-8"><h4>Grand Total</h4></div>
        <div class="col-xs-6 col-sm-6 col-md-4"><h4><?= '&pound;' . number_format($dataProvider['total'],2); ?></h4></div>
    </div>

    <?php
    if(!empty($quoteResult->instruct_us_url)):
        ?>
        <div class="col-xs-12" style="padding: 1em 0">
            <div class="col-xs-6 col-sm-6 col-md-6 text-right">
                <?php
                if($quoteResult->instruct_us_method == \common\components\quotes\conveyancing\QuoteInstructUsForm::METHOD_POST){
                    $inputs = unserialize($quoteResult->instruct_us_params);

                    echo '<form action="' . $quoteResult->instruct_us_url . '" method="POST"'
                        . ($quoteResult->instruct_us_is_multipart_form==1 ? ' enctype="multipart/form-data"' : ''). ' target="_blank">';

                    foreach($inputs as $name=>$value){
                        echo '<input type="hidden" name="' . $name . '" value="' . $value . '">';
                    }

                    echo Html::submitButton('Instruct Us', ['class' => 'btn btn-primary']);

                    echo '</form>';

                }else{
                    echo Html::a('Instruct Us', $quoteResult->instruct_us_url, ['class' => 'btn btn-primary', 'target' => '_blank']);
                }
                ?>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 text-left">
                <?php echo Html::a('Back', ['quotes/show', 'id' => $quoteResult->instant_quote_id], ['class' => 'btn btn-primary']); ?>
            </div>

        </div>
    <?php endif; ?>
    <?php
    if(empty($quoteResult->instruct_us_url)):
        ?>
        <div class="col-xs-12 text-center" style="padding: 1em 0">
            <?php echo Html::a('Back', ['quotes/show', 'id' => $quoteResult->instant_quote_id], ['class' => 'btn btn-primary']); ?>
        </div>
    <?php endif; ?>
</div>
