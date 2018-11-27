<?php

/* @var $this yii\web\View */
/* @var $model common\models\TravelQuote */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $listRegions array */
/* @var $listCountries array */
/* @var $listResorts array */
/* @var $listAirports array */
/* @var $companyIDs string */

use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use common\widgets\multiselect\MultiSelect;
use kartik\widgets\Typeahead;
use yii\helpers\Url;

$this->registerJsFile(
    '@web/js/travel-quote.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);

$this->title = 'Beach Quote';

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
                <h2 class="pull-left quote-form__title">Find Your Perfect Beach Quotes</h2>
                <input type="hidden" name="company-ids" id="company-ids" value="<?= $companyIDs ?>" />
                <input type="hidden" name="show-any-value" id="show-any-value" value="0" />
            </div>


            <?php
                // Usage with ActiveForm and model (with search term highlighting)
                echo $form->field($model, 'country', [
                        'options' => ['class' => 'col-xs-12 col-sm-12 col-md-12	']
                ])->widget(Typeahead::classname(), [
                    'id' => 'quote-country',
                    'options' => ['placeholder' => 'Filter as you type...'],
                    'pluginOptions' => ['highlight'=>true],
                    'dataset' => [
                        [
                            'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                            'display' => 'value',
    //                        'prefetch' => $baseUrl . '/samples/countries.json',
                            'remote' => [
                                'url' => Url::to(['data/country-list']) . '?q=%QUERY',
                                'wildcard' => '%QUERY'
                            ]
                        ]
                    ]
                ]);

                echo $form->field($model, 'city', [
                    'options' => ['class' => 'col-xs-12 col-sm-12 col-md-12	']
                ])->widget(Typeahead::classname(), [
                    'id' => 'quote-city',
                    'options' => ['placeholder' => 'Filter as you type...'],
                    'pluginOptions' => ['highlight'=>true],
                    'dataset' => [
                        [
                            'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                            'display' => 'value',
                            'remote' => [
                                'url' => Url::to(['data/city-region-list']) . '?q=%QUERY',
//                                'replace' => "replace(url, uriEncodedQuery) { val = $('#First_Name').val(); if (!val) return url;  return url + '&first_name=' + encodeURIComponent(val) }",
//                                'prepare' => "function(query, settings) { settings.url += '?q=' + query; return settings; }",
//                                'prepare' => " settings.url += '?q=' + query; return settings; ",
/*
                                    "function(url, uriEncodedQuery) {
                                                cntry = $('#quote-country').val();
                                                return url + '?q=' + uriEncodedQuery + '&c=' + cntry
                                            }",
*/
                                'wildcard' => "cntry = $('#quote-country').val(); return url + '?q=' + uriEncodedQuery + '&c=' + cntry"
                            ]
                        ]
                    ]
                ]);

            ?>


            <?php
                // Usage with ActiveForm and model (with search term highlighting)
                echo $form->field($model, 'airport', [
                    'options' => ['class' => 'col-xs-12 col-sm-12 col-md-12	']
                ])->widget(Typeahead::classname(), [
                    'id' => 'quote-airport',
                    'options' => ['placeholder' => 'Filter as you type...'],
                    'pluginOptions' => ['highlight'=>true],
                    'dataset' => [
                        [
                            'local' => \common\models\DictAirport::getAirportList(),
                        ]
                    ]
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
                    'startDate' => '+1d',
//                        'changeMonth' => true,
//                        'changeYear' => true,
//                        'yearRange' => '2017:2099',
                ],
            ])->label('Departure Date')
            ?>

            <?= $form->field($model, 'flight_category', [
                    'options' => ['class' => 'col-xs-12 col-sm-12 col-md-12	'],
                ])->dropDownList($model::getFlightCategoryList(), [
                    'id' => 'quote-flight-category',
                ]);
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


            <?php /* echo  $form->field($model, 'passengers', [
                    'options' => ['class' => 'col-xs-12 col-sm-12 col-md-12	'],
                ])->dropDownList(\common\models\TravelQuote::getListAdults(), [
                    'id' => 'select-passengers',
                ])->label('Passengers?'); */
            ?>

            <?php echo $this->render('_roomFields', [ 'model' => $model]); ?>

            <?= $form->field($model, 'details', [
                    'options' => ['class' => 'col-xs-12 col-sm-12 col-md-12	'],
                ])->textarea([
                    'placeholder' => 'Type the additional info',
                    'id' => 'quote-details',
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
