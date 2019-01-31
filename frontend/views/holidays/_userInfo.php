<?php
/* @var $model common\models\TravelQuote */
?>

<div class="col-xs-12 col-sm-12 col-md-12"><p></p>
</div>
<div class="col-xs-12 col-sm-12 col-md-12">
    <div class="panel panel-default fieldGroupUserInfo">
        <div class="panel-heading">
            <h2 class="panel-title">Your details</h2>
        </div>

        <div class="panel-body">

<?php


    echo $form->field($model, 'user_title', [
        'options' => ['class' => 'col-xs-12 col-sm-12 col-md-2	'],
    ])->dropDownList($model::getUserTitleList(), [
        'id' => 'user-title',
    ]);

    echo $form->field($model, 'user_first_name', [
        'options' => ['class' => 'col-xs-12 col-sm-12 col-md-5'],
    ])->textInput([
        'id' => 'user-first-name',
    ]);

    echo $form->field($model, 'user_last_name', [
        'options' => ['class' => 'col-xs-12 col-sm-12 col-md-5'],
    ])->textInput([
        'id' => 'user-last-name',
    ]);

    echo $form->field($model, 'email', [
        'options' => ['class' => 'col-xs-12 col-sm-12 col-md-12'],
    ])->textInput([
        'id' => 'user-email',
    ]);

    echo $form->field($model, 'phone', [
        'options' => ['class' => 'col-xs-12 col-sm-12 col-md-12'],
    ])->textInput([
        'pattern' => trim(\common\components\Helper::REGEXP_PHONE, '/'),
        'id' => 'user-phone',
    ]);
?>
        </div>
    </div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12"><p></p>
</div>
<div class="col-xs-12 col-sm-12 col-md-12">
    <div class="panel panel-default fieldGroupUserAddress">
        <div class="panel-heading">
            <h2 class="panel-title">Your address</h2>
        </div>

        <div class="panel-body">
<?php
    echo $form->field($model, 'address_street', [
        'options' => ['class' => 'col-xs-12 col-sm-12 col-md-12'],
    ])->textInput([
        'id' => 'user-address-street',
    ]);

    echo $form->field($model, 'address_town', [
        'options' => ['class' => 'col-xs-12 col-sm-12 col-md-12'],
    ])->textInput([
        'id' => 'user-address-town',
    ]);

    echo $form->field($model, 'address_county', [
        'options' => ['class' => 'col-xs-12 col-sm-12 col-md-12'],
    ])->textInput([
        'id' => 'user-address-county',
    ]);

    echo $form->field($model, 'address_postcode', [
        'options' => ['class' => 'col-xs-12 col-sm-12 col-md-6'],
    ])->textInput([
        'pattern' => trim(\common\components\Helper::REGEXP_POSTCODE, '/'),
        'placeholder'	 => 'e.g. YO1',
        'id' => 'user-address-postcode',
    ]);
?>
        </div>
    </div>
</div>
