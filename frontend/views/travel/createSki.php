<?php

/* @var $this yii\web\View */
/* @var $model common\models\TravelQuote */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $listCountries array */
/* @var $listResorts array */
/* @var $listAirports array */
/* @var $companyIDs string */

use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;

$this->registerJsFile(
    '@web/js/travel-quote.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);

$this->title = 'Skiing Quote';

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-index">

    <div class="body-content">

        <div class="row">
            <?php
            $form = ActiveForm::begin([
                'id' => 'quote-form',
                'options' => ['class' => 'form-horizontal quote-form'],
            ])
            ?>

            <div class="col-xs-12">
                <h2 class="pull-left quote-form__title">Find Your Perfect Skiing Holidays</h2>
                <input type="hidden" name="company-ids" id="company-ids" value="<?= $companyIDs ?>" />
                <input type="hidden" name="show-any-value" id="show-any-value" value="1" />
            </div>

            <?= $form->field($model, 'countryIDs', [
                    'options' => ['class' => 'col-xs-12 col-sm-12 col-md-12	'],
                ])->dropDownList($listCountries, [
                    'data-trigger' => 'dep-drop',
                    'data-target' => '#quote-resort',
                    'data-url' => \yii\helpers\Url::to(['/data/resorts']),
                    'data-name' => 'cid',
                    'id' => 'quote-country',
                ])
            ?>

            <?= $form->field($model, 'resortIDs', [
                    'options' => ['class' => 'col-xs-12 col-sm-12 col-md-12	'],
                ])->dropDownList($listResorts, [
                    'id' => 'quote-resort',
                ])
            ?>

            <?= $form->field($model, 'airportIDs', [
                    'options' => ['class' => 'col-xs-12 col-sm-12 col-md-12	'],
                ])->dropDownList($listAirports, [
                    'id' => 'quote-airport',
                ])->label('Flying From?')
            ?>

            <?= $form->field($model, 'flight_category', [
                    'options' => ['class' => 'col-xs-12 col-sm-12 col-md-12	'],
                ])->dropDownList($model::getFlightCategoryList(), [
                    'id' => 'quote-flight-category',
                ]);
            ?>

            <?=
            //            https://github.com/2amigos/yii2-date-picker-widget
            //            http://www.yiiframework.com/doc-2.0/yii-jui-datepicker.html
            //            http://api.jqueryui.com/datepicker/#option-minDate

            $form->field($model, 'date',[
                'options' => ['class' => 'col-xs-12 col-sm-12 col-md-12	'],
            ])->widget(DatePicker::classname(), [
                'options' => [
                    'id' => 'quote-date',
                    'placeholder' => 'Anytime',
                    'class' => 'form-control'
                ],
                'clientOptions' => [
                    'placeholder' => 'Anytime',
                    'autoclose' => true,
                    'format' => 'd MM yyyy',
//                        'changeMonth' => true,
//                        'changeYear' => true,
                        'startDate' => '+1d',
//                        'yearRange' => '2017:2099',
                ],
            ])->label('Departure Date')
            ?>

            <?= $form->field($model, 'duration', [
                'options' => ['class' => 'col-xs-12 col-sm-12 col-md-12	'],
            ])->dropDownList(\common\models\TravelQuote::getListDuration(), [
                'id' => 'quote-duration',
            ])->label('Nights?')
            ?>

            <?= $form->field($model, 'budget', [
                'options' => ['class' => 'col-xs-12 col-sm-12 col-md-12	'],
            ])->textInput([
                'id' => 'quote-budget',
            ])
            ?>

            <?php /* echo $form->field($model, 'passengers', [
                'options' => ['class' => 'col-xs-12 col-sm-12 col-md-12	'],
            ])->dropDownList(\common\models\TravelQuote::getListAdults(), [
                'id' => 'select-passengers',
            ])->label('Adults'); */
            ?>

            <?php echo $this->render('_roomFields', [ 'model' => $model]); ?>

            <?= $form->field($model, 'details', [
                'options' => ['class' => 'col-xs-12 col-sm-12 col-md-12	'],
            ])->textarea([
                'placeholder' => 'Type the additional info',
                'id' => 'quote-details'
            ])
            ?>

            <?php
                echo $this->render('_userInfo', [
                    'form' => $form,
                    'model' => $model
                ]);
            ?>

            <?php echo $this->render('_requestAgreement'); ?>

            <div class="form-group">
                <div class="col-xs-12 text-center">
                    <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-refresh glyphicon-refresh-animate processing"></span>
                        <span class="default">Request Quotes</span><span class="processing">Loading...</span></button>
                </div>
            </div>
            <?php ActiveForm::end() ?>
        </div>

        <?php echo $this->render('_roomFieldsCopy', [ 'model' => $model]); ?>

    </div>
</div>
