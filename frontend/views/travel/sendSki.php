<?php
/**
 * Created by Kudin Dmitry
 * Date: 09.11.2017
 * Time: 17:10
 */

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SkiEnquiryForm */

use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = $resort['hotelName'];

$this->params['breadcrumbs'][] =
    [
        'label' => 'Travel',
        'url' => ['travel/index']
    ];
$this->params['breadcrumbs'][] =
    [
        'label' => 'Skiing quote',
        'url' => ['travel/skiing']
    ];
$this->params['breadcrumbs'][] =
    [
        'label' => \common\components\Helper::getTravelQuoteHeader($instantQuote),
        'url' => ['travel/skiing/view/'.$instantQuote->id]
    ];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-index">

    <div class="body-content">

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <h2 class="text-center text-primary"><?= $resort['hotelName']; ?></h2>
                <h3 class="text-center"><?= $resort['resort']; ?></h3>
                <p class="text-center">
                    <?php
                    for($i=2; $i<=$resort['hotelStar']; $i++) {
                        echo '<span class="glyphicon glyphicon-star" aria-hidden="true"></span>';
                    }
                    ?>
                </p>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="col-xs-12 col-sm-6 col-md-5">
                    <?= Html::img($resort['imgUrl'], [
                        'class' => 'img-thumbnail img-responsive',
                        'alt' => $resort['hotelName']
                    ]);?>
                </div>

                <div class="col-xs-12 col-sm-6 col-md-7">
                    <div class="col-xs-8 col-sm-6 col-md-6">
                        <?php
                            foreach($resort['info'] as $info) {
                                echo '<p class="media-heading">'.$info.'</p>';
                            }
                        ?>

                        <?php if($resort['price']!=0){ ?>
                            <h5 class="media-heading">
                                <strong>Prices From <span class="text-danger">&pound;<?= $resort['price']; ?></span>
                                    &nbsp;<span><small>per person</small></span></strong>
                            </h5>
                        <?php } ?>
                    </div>
                    <div class="col-xs-4 col-sm-6 col-md-6">
                        <?= Html::img($company->companyUrl, [
                            'class' => 'img-responsive',
                            'alt' => $company->companyName
                        ]);?>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <?= $resort['description']; ?>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <?php
            $form = ActiveForm::begin([
                'id' => 'quote-form',
                'options' => ['class' => 'form-horizontal quote-form'],
            ])
            ?>

            <div class="col-xs-12">
                <h2 class="text-center"><?= $resort['hotelName'] ?> Enquiry Form</h2>
                <h4 class="text-center">Fill out our enquiry form below and one of our ski experts will be in contact with you shortly.</h4>
                <input type="hidden" name="current_url" value="<?= $resort['detailUrl'] ?>" />

            </div>

            <?php echo $form->field($model, 'enquire_title', [
                    'options' => ['class' => 'col-xs-12 col-sm-2 col-md-2	'],
                ])->dropDownList(\frontend\models\SkiEnquiryForm::getListTitle(), [
                    'autofocus' => true,
                    'prompt' => 'Select your title',
                ])->label('Title')
            ?>

            <?php echo $form->field($model, 'enquire_firstname', [
                'options' => ['class' => 'col-xs-12 col-sm-5 col-md-5'],
            ])->textInput() ?>

            <?php echo $form->field($model, 'enquire_surname', [
                'options' => ['class' => 'col-xs-12 col-sm-5 col-md-5'],
            ]) ?>

            <?php echo $form->field($model, 'enquire_email', [
                'options' => ['class' => 'col-xs-12 col-sm-12 col-md-12'],
            ]) ?>

            <?php
                echo $form->field($model, 'enquire_phone', [
                        'options' => ['class' => 'col-xs-12 col-sm-12 col-md-6'],
                    ])->textInput([
                        'pattern' => trim(\common\components\Helper::REGEXP_PHONE, '/'),
                    ]);
            ?>

            <?php echo $form->field($model, 'enquire_postcode', [
                    'options' => ['class' => 'col-xs-12 col-sm-12 col-md-6'],
                ])->textInput(
                    [
                        'pattern' => trim(\common\components\Helper::REGEXP_POSTCODE, '/'),
                        'placeholder' => 'e.g. YO1',
                    ]);
            ?>

            <?php echo $form->field($model, 'enquire_ad', [
                'options' => ['class' => 'col-xs-12 col-sm-6 col-md-6'],
            ]) ?>

            <?php echo $form->field($model, 'enquire_ch', [
                'options' => ['class' => 'col-xs-12 col-sm-6 col-md-6'],
            ]) ?>

            <?php echo $form->field($model, 'enquire_message', [
                    'options' => ['class' => 'col-xs-12 col-sm-12 col-md-12	'],
                ])->textarea([
                    'rows' => 4,
                ])->label('Details <span style="color:#333; font-weight:normal"><small>(please provide any other relevant details, for example your preferred departure date, departure airport, destination, and holiday duration)</small></span>')
            ?>

            <div class="col-xs-12 col-sm-12 col-md-12 quote-form__my-details">
                <label>
                    <input type="checkbox" name="SkiEnquiryForm[my_details]" />
                    <span style="padding-left: 5px"><?php echo \common\components\Helper::QUOTE_CONFIRMATION_TEXT ?></span>
                </label>
            </div>
            <div class="form-group">
                <div class="col-xs-12 text-center">
                    <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-refresh glyphicon-refresh-animate processing"></span>
                        <span class="default">Send enquiry</span><span class="processing">Loading...</span></button>
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
            myDetails = form.find('.quote-form__my-details input');

        form.on('afterValidate', formAfterValidateHandler);

        myDetails.change(myDetailChangeHandler);
    }

    function myDetailChangeHandler()
    {
        var checkbox = $('.quote-form__my-details input'),
            value = checkbox.prop('checked'),
            submit = $('.quote-form :submit');

        if (value)
            submit.removeAttr('disabled');
        else
            submit.attr('disabled', 'disabled');
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
        myDetailChangeHandler()
    }

    document.addEventListener("DOMContentLoaded", contentLoaded);
</script>
