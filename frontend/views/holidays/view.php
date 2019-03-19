<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\widgets\sumoselect\SumoSelect;

/* @var $this yii\web\View */
/* @var $instantQuote common\models\TravelQuote*/
/* @var $travelCategory string */
/* @var $quoteInfo string */
/* @var $quoteServices array */
/* @var $quoteService common\components\quotes\travel\TravelParsedResult */
/* @var $listHotelGrade array */
/* @var $listBoardBasis array */

$this->title = \common\components\QuoteHelper::getTravelQuoteHeader($instantQuote);

if($travelCategory=='luxury'){
    $this->params['breadcrumbs'][] =
        [
            'label' => 'Beach quote',
            'url' => ['holidays/beach']
        ];
}elseif($travelCategory=='ski'){
    $this->params['breadcrumbs'][] =
        [
            'label' => 'Ski quote',
            'url' => ['holidays/ski']
        ];
}

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="quote-response-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <h4 class="lead"><?= $quoteInfo ?>&nbsp;&nbsp;<a href="<?= \yii\helpers\Url::to(['holidays/update', 'id'=>$instantQuote->id]); ?>">Change search</a></h4>

    <div class="row">
            <nav class="navbar navbar-default">
            <?php
                $form = ActiveForm::begin([
                    'id' => 'quote-form',
//                    'layout' => 'inline',
                    'options' => ['class' => 'navbar-form quote-form'],
                ]);

            echo $form->field($instantQuote, 'page_number')->hiddenInput(['value' => $instantQuote->page_number])->label(false);
            ?>
                <div class="form-group">
                    <label for="select-board-basis">Board basis</label>
                    <?php
                    echo SumoSelect::widget([
                        'model' => $instantQuote,
                        'attribute' => 'boardBasisIDs',
                        'id'=>"select-board-basis",
                        "options" => [
                            'multiple'=>"multiple",
                        ],
                        'data' => $listBoardBasis,
                        'value' => $instantQuote->boardBasisIDs,
                        'name' => 'TravelQuote[boardBasisIDs]',
                        "clientOptions" =>
                            [
                                'selectAll' => true,
                                'captionFormatAllSelected' => 'Any',
                            ],
                    ]);
                    ?>
                </div>

                <div class="form-group col-md-offset-1">
                    <label for="select-hotel-grade">Hotel grade</label>
                    <?php
                        echo SumoSelect::widget([
                            'model' => $instantQuote,
                            'attribute' => 'hotelGradeIDs',
                            'id'=>"select-hotel-grade",
                            "options" => [
                                'multiple'=>"multiple",
                            ],
                            'data' => $listHotelGrade,
                            'value' => $instantQuote->hotelGradeIDs,
                            'name' => 'TravelQuote[hotelGradeIDs]',
                            "clientOptions" =>
                                [
                                    'selectAll' => true,
                                    'captionFormatAllSelected' => 'Any',
                                ],
                        ]);
                    ?>
                </div>


                <button type="submit" class="btn btn-primary navbar-btn"><span class="glyphicon glyphicon-refresh glyphicon-refresh-animate processing"></span>
                    <span class="default">Filter</span><span class="processing">Loading...</span></button>

            <?php ActiveForm::end() ?>
            </nav>
    </div>

    <div class="row">
        <div id="quote-result" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <?php echo $this->render('_results', [
                'quoteServices' => $quoteServices,
                'instantQuote' => $instantQuote,
            ]); ?>
        </div>
    </div>

    <div class="row">
        <nav aria-label="...">
            <ul class="pager">
                <li id="btn_prev" class="disabled"><a href="#">Previous</a></li>
                <li id="btn_next"><a href="#">Next</a></li>
            </ul>
        </nav>
    </div>

</div>

<script>
    function addListeners() {
        var form = $('.quote-form'),
            btnPrev = $('#btn_prev'),
            btnNext = $('#btn_next');

        form.on('beforeSubmit', formBeforeSubmitHandler);
        form.on('submit', function (e) {
            e.preventDefault();
        });

        btnPrev.on('click', btnPrevClickHandler);
        btnNext.on('click', btnNextClickHandler);
    }

    function btnPrevClickHandler()
    {
        var pager = $('#travelquote-page_number');
        var pageNumber = parseInt(pager.val());

        if(pager.val() > 1){
            pager.val(pageNumber-1);
            $('.quote-form').submit();
        }
    }

    function btnNextClickHandler()
    {
        var pager = $('#travelquote-page_number');
        var pageNumber = parseInt(pager.val());

        if(pager.val() >= 1){
            pager.val(pageNumber+1);
            $('.quote-form').submit();
        }
    }

    function formBeforeSubmitHandler()
    {
        var submit = $('.quote-form :submit'),
            container = $('.global-container'),
            form = $(this),
            formData = form.serialize(),
            btnPrev = $('#btn_prev'),
            btnNext = $('#btn_next');

        if (!$(this).find('.has-error').length)
        {
            submit.addClass('button_state_processing');
            container.addClass('global-container_state_overlay');
            btnPrev.addClass('disabled');
            btnNext.addClass('disabled');

            $.ajax({
                url: form.attr("action"),
                type: form.attr("method"),
                data: formData,
                success: function (data) {
                    $('#quote-result').html(data);
                    submit.removeClass('button_state_processing');
                    container.removeClass('global-container_state_overlay');
                    if($('#travelquote-page_number').val()>1){
                        btnPrev.removeClass('disabled')
                    }
                    btnNext.removeClass('disabled')
                },
                error: function () {
                    alert("Something went wrong");
                    submit.removeClass('button_state_processing');
                    container.removeClass('global-container_state_overlay');
                }
            });

        }
    }

    function contentLoaded()
    {
        addListeners();
    }

    document.addEventListener("DOMContentLoaded", contentLoaded);

</script>
