<?php
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use kartik\widgets\Typeahead;
use yii\helpers\Url;
/*
<input type="hidden" name="company-ids" id="company-ids" value="<?= $companyIDs ?>" />
*/
?>
<div class="row">
    <?php
    $form = ActiveForm::begin([
        'id' => 'quote-form',
        'options' => ['class' => 'form-horizontal quote-form'],
    ])
    ?>

    <div class="col-xs-12">
        <h3 class="pull-left title quote-form__title">Find Your Perfect <?= $quoteName ?></h3>
        <input type="hidden" name="show-any-value" id="show-any-value" value="0" />
    </div>

    <div id="quote-info-block">

        <?php
        // Usage with ActiveForm and model (with search term highlighting)
        echo $form->field($model, 'country', [
            'options' => ['class' => 'col-xs-12 col-sm-12 col-md-12	']
        ])->widget(Typeahead::classname(), [
            'options' => [
                'id' => 'quote-country',
                'placeholder' => 'Any country'
            ],
            'pluginOptions' => ['highlight'=>true],
            'dataset' => [
                [
                    'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                    'display' => 'value',
                    'remote' => [
                        'url' => Url::to(['data/country-list']) . '?q=%QUERY',
    //                    'prepare' => "function(query, settings) { settings.url += '?q=' + query; return settings; }",
                         'wildcard' => '%QUERY'
                    ],
                    'limit' => 10
                ]
            ]
        ]);

        echo $form->field($model, 'city', [
            'options' => ['class' => 'col-xs-12 col-sm-12 col-md-12	']
        ])->widget(Typeahead::classname(), [
            'options' => [
                'id' => 'quote-city',
                'placeholder' => 'Any region / city'
            ],
            'pluginOptions' => ['highlight'=>true],
            'dataset' => [
                [
                    'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                    'display' => 'value',
                    'remote' => [
                        'url' => Url::to(['data/region-list']) . '?q=%QUERY',
                        'prepare' => new yii\web\JsExpression("function(query, settings) { var selectedCountry = $('#quote-country').val(); if(typeof selectedCountry == 'undefined') selectedCountry = ''; settings.url = settings.url.replace('%QUERY', query) + '&c=' + selectedCountry; return settings; }"),
                    ],
                    'templates' => [
                        'header' => '<h4 class="typehead-header">Region</h4>'
                    ]
                ],
                [
                    'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                    'display' => 'value',
                    'remote' => [
                        'url' => Url::to(['data/city-list']) . '?q=%QUERY',
                        'prepare' => new yii\web\JsExpression("function(query, settings) { var selectedCountry = $('#quote-country').val(); if(typeof selectedCountry == 'undefined') selectedCountry = ''; settings.url = settings.url.replace('%QUERY', query) + '&c=' + selectedCountry; return settings; }"),
                    ],
                    'templates' => [
                        'header' => '<h4 class="typehead-header">City</h4>'
                    ]
                ],
            ],

        ]);

        ?>

        <?php
        $airports = \common\models\DictAirport::getAirportList();
        // Usage with ActiveForm and model (with search term highlighting)
        echo $form->field($model, 'airport', [
            'options' => ['class' => 'col-xs-12 col-sm-12 col-md-12	']
        ])->widget(Typeahead::classname(), [
            'options' => [
                'id' => 'quote-airport',
                'placeholder' => 'Any airport'
            ],
            'pluginOptions' => ['highlight'=>true],
            'dataset' => [
                [
                    'local' => $airports,
                    'limit' => 10
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


        <?php echo $this->render('_roomFields', [ 'model' => $model]); ?>

        <?= $form->field($model, 'details', [
            'options' => ['class' => 'col-xs-12 col-sm-12 col-md-12	'],
        ])->textarea([
            'placeholder' => 'Any specific requirements e.g. sea/mountain view, 5* hotel, quiet location etc.',
            'id' => 'quote-details',
        ])
        ?>

        <?php
            echo $this->render('_userInfo', [
                'form' => $form,
                'model' => $model
            ]);
        ?>

        <div class="form-group">
            <div class="col-xs-12 text-center">
                <a id="btn-show-retailers" class="btn btn-form">Next</a>
            </div>
        </div>
    </div>

    <div id="retailer-block" class="hidden">
        <?php
            echo $this->render('_retailerList', [
                'retailers' => $retailers
            ]);
        ?>

        <?php echo $this->render('_requestAgreement'); ?>

        <div class="form-group">
            <div class="col-xs-12 text-center">
                <a id="btn-back" class="btn btn-form btn-back">Back</a>
                <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-refresh glyphicon-refresh-animate processing"></span>
                    <span class="default">Request Quotes</span><span class="processing">Loading...</span></button>
            </div>
        </div>
    </div>

    <?php ActiveForm::end() ?>
</div>

<?php echo $this->render('_roomFieldsCopy', [ 'model' => $model]); ?>
