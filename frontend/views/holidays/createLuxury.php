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

$this->title = 'Beach Quote';

$this->params['breadcrumbs'][] =
    [
        'label' => 'Travel',
        'url' => ['index']
    ];
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

            <div class="col-xs-12 col-sm-12 col-md-12 field-select-region">
                <label class="control-label" for="select-region">Region</label>
            <?php
                echo MultiSelect::widget([
                    'model' => $model,
                    'attribute' => 'regionIDs',
                    'id'=>"select-region",
                    "options" => [
                        'multiple'=>"multiple",
                        'data-trigger' => 'region-drop',
                        'data-target' => '#select-country',
                        'data-url' => \yii\helpers\Url::to(['/data/countries']),
                        'data-name' => 'rid',
                        'id' => 'select-region',

                    ],
                    'data' => $listRegions,
                    "clientOptions" =>
                        [
                            "includeSelectAllOption" => true,
                            'selectAllValue' => 0,
                            'selectAllNumber' => false,
                            'selectAllText' => 'Any region',
                            'allSelectedText' => 'Any region',
                            'nonSelectedText' => 'Select a region',
                            'numberDisplayed' => 5,
                            'buttonContainer' => '<div></div>',
                            'buttonClass' => 'form-control text-left',


/*                            'onDropdownShow' => 'function(event) {

                var menu = $(event.currentTarget).find(".dropdown-menu");
                var original = $(event.currentTarget).prev("select").attr("id");

                // Custom functions here based on original select id
                if (original === "select-region") menu.css("width", 500);

            }',
*/
                        ],
                    ]);
            ?>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 field-select-country">
                <label class="control-label" for="select-country">Country</label>
            <?php
                echo MultiSelect::widget([
                    'model' => $model,
                    'attribute' => 'countryIDs',
                    'id'=>"select-country",
                    'options' => [
                        'multiple' => 'multiple',
                        'data-trigger' => 'country-drop',
                        'data-target' => '#select-resort',
                        'data-url' => \yii\helpers\Url::to(['/data/resorts']),
                        'data-name' => 'cid',
                        'data-parent' => '#select-region',
                        'id' => 'select-country',
                    ],
                    'data' => $listCountries,
                    "clientOptions" =>
                        [
                            "includeSelectAllOption" => true,
                            'selectAllValue' => 0,
                            'enableFiltering' => true,
                            'filterPlaceholder' => 'Search for country...',
                            'selectAllNumber' => false,
                            'selectAllText' => 'Any country',
                            'allSelectedText' => 'Any country',
                            'nonSelectedText' => 'Select a country',
                            'maxHeight' => 200,
                            'numberDisplayed' => 5,
                            'buttonContainer' => '<div></div>',
                            'buttonClass' => 'form-control text-left',
                        ],
                ]);
            ?>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 field-select-resort">
                <label class="control-label" for="select-resort">Resort</label>
                <?php
                    echo MultiSelect::widget([
                        'model' => $model,
                        'attribute' => 'resortIDs',
                        'id'=>"select-resort",
                        "options" => [
                            'multiple'=>"multiple",
                            'id' => 'select-resort',
                        ],
                        'data' => $listResorts,
                        "clientOptions" =>
                            [
                                "includeSelectAllOption" => true,
                                'selectAllValue' => 0,
                                'enableFiltering' => true,
                                'filterPlaceholder' => 'Search for resort...',
                                'selectAllNumber' => false,
                                'selectAllText' => 'Any resort',
                                'allSelectedText' => 'Any resort',
                                'nonSelectedText' => 'Select a resort',
                                'maxHeight' => 200,
                                'numberDisplayed' => 5,
                                'buttonContainer' => '<div></div>',
                                'buttonClass' => 'form-control text-left',
                            ],
                    ]);
                ?>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 field-select-airport">
                <label class="control-label" for="select-airport">Airport</label>
                <?php
                    echo MultiSelect::widget([
                        'model' => $model,
                        'attribute' => 'airportIDs',
                        'id'=>"select-airport",
                        "options" => [
                            'multiple'=>"multiple",
                        ],
                        'data' => $listAirports,
                        'value' => $model->airportIDs,
                        'name' => 'TravelQuote[airportIDs]',
                        "clientOptions" =>
                            [
                                "includeSelectAllOption" => true,
                                'selectAllValue' => 0,
                                'selectAllNumber' => false,
                                'selectAllText' => 'Any airport',
                                'allSelectedText' => 'Any airport',
                                'nonSelectedText' => 'Select an airport',
                                'numberDisplayed' => 5,
                                'buttonContainer' => '<div></div>',
                                'buttonClass' => 'form-control text-left',
                            ],
                    ]);
                ?>
            </div>


            <?=
//            https://github.com/2amigos/yii2-date-picker-widget
//            http://www.yiiframework.com/doc-2.0/yii-jui-datepicker.html
//            http://api.jqueryui.com/datepicker/#option-minDate

            $form->field($model, 'date',[
                'options' => ['class' => 'col-xs-12 col-sm-12 col-md-12	'],
            ])->widget(DatePicker::classname(), [
                'options' => [
                    'placeholder' => 'Anytime',
                    'class' => 'form-control'
                ],
                'clientOptions' => [
                    'placeholder' => 'Anytime',
                    'autoclose' => true,
                    'format' => 'd MM yyyy',
//                        'changeMonth' => true,
//                        'changeYear' => true,
//                        'minDate' => "new Date(2017, 6 - 1, 9)",
//                        'yearRange' => '2017:2099',
                ],
            ])->label('Departure Date')
            ?>

            <?= $form->field($model, 'duration', [
                    'options' => ['class' => 'col-xs-12 col-sm-12 col-md-12	'],
                ])->dropDownList(\common\models\TravelQuote::getListDuration(), [
                    'id' => 'select-duration',
                ])->label('Nights?')
            ?>

            <?= $form->field($model, 'passengers', [
                    'options' => ['class' => 'col-xs-12 col-sm-12 col-md-12	'],
                ])->dropDownList(\common\models\TravelQuote::getListPassengers(), [
                    'id' => 'select-passengers',
                ])->label('Passengers?')
            ?>

            <?= $form->field($model, 'details', [
                    'options' => ['class' => 'col-xs-12 col-sm-12 col-md-12	'],
                ])->textarea(['placeholder' => 'Type the additional info'])
            ?>

            <div class="form-group">
                <div class="col-xs-12 text-center">
                    <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-refresh glyphicon-refresh-animate processing"></span>
                        <span class="default">Request Quotes</span><span class="processing">Loading...</span></button>
                </div>
            </div>
            <?php ActiveForm::end() ?>
        </div>

    </div>
</div>

<script>
    function addListeners()
    {
        var form = $('.quote-form'),
            regionDrop = $("[data-trigger=region-drop]"),
            countryDrop = $("[data-trigger=country-drop]");

        form.on('afterValidate', formAfterValidateHandler);

        countryDrop.change(dropdownChangeHandler);
        regionDrop.change(dropdownChangeHandler);
    }

    function compare(a,b) {
        if (a.name < b.name)
            return -1;
        if (a.name > b.name)
            return 1;
        return 0;
    }

    function dropdownChangeHandler(){
        var data = {};
        data[$(this).attr("data-name")] = $(this).val();
        data['company-ids'] = $('#company-ids').val();
        data['show-any-value'] = $('#show-any-value').val();

        if($(this).attr("data-parent")){
            var parent = $($(this).attr("data-parent"));
            data[parent.attr("data-name")] = parent.val();
        }

        var target = $(this).attr("data-target");

        $.post(
            $(this).attr("data-url"),
            data,
            function( response ) {
                var slct = $(target);
                slct.empty();

                var items = "";
                $.each( response, function( key, val ) {
                    items += "<option value='" + val['id'] + "'>" + val['name'] + "</option>";
                });
                $(items).appendTo( slct );
                slct.change();
                slct.multiselect('rebuild');
            }
        );
    }


    function formAfterValidateHandler()
    {
        var submit = $('.quote-form :submit'),
            container = $('.global-container');

        if (!$(this).find('.has-error').length)
        {
            submit.addClass('button_state_processing');
            container.addClass('global-container_state_overlay');
        }
    }

    function contentLoaded()
    {
        addListeners();
    }

    document.addEventListener("DOMContentLoaded", contentLoaded);

</script>