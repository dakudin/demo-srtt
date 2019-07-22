<?php
/**
 * Created by Kudin Dmitry
 * Date: 05.10.2018
 * Time: 14:45
 */

/* @var $model frontend\models\ProfileForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;
use frontend\widgets\profileform\AppAsset;

AppAsset::register($this);

Modal::begin([
    'header'=>'<h4>Profile</h4>',
    'id'=>'profile-modal',
]);

?>

    <div id="system-messages" style="opacity: 1; display: none"></div>


<?php
    $form = ActiveForm::begin([
        'id' => 'form-profile',
        'enableAjaxValidation' => true,
        'action' => ['site/save-profile'],
        'validateOnSubmit' => true,
        'validationUrl' => ['site/validate-profile'],
    ]);
?>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="panel panel-default fieldGroupUserEmail">
            <div class="panel-heading">
                <h2 class="panel-title">Account email</h2>
            </div>

            <div class="panel-body">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <?php echo $form->field($model, 'email')->label(false)->textInput(['placeholder' => 'Enter your new account email']); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="panel panel-default fieldGroupUserInfo">
            <div class="panel-heading">
                <h2 class="panel-title">Contact information</h2>
            </div>
            <div class="panel-body">

    <?php
        echo $form->field($model, 'user_title', [
            'options' => ['class' => 'col-xs-12 col-sm-12 col-md-4	'],
        ])->dropDownList($model::getUserTitleList(), [
            'id' => 'select-title',
        ]);

        echo $form->field($model, 'user_first_name', [
            'options' => ['class' => 'col-xs-12 col-sm-12 col-md-4'],
        ])->textInput();

        echo $form->field($model, 'user_last_name', [
            'options' => ['class' => 'col-xs-12 col-sm-12 col-md-4'],
        ])->textInput();

        echo $form->field($model, 'contact_email', [
            'options' => ['class' => 'col-xs-12 col-sm-12 col-md-12'],
        ])->textInput();

        echo $form->field($model, 'contact_phone', [
            'options' => ['class' => 'col-xs-12 col-sm-12 col-md-12'],
        ])->textInput([
            'pattern' => trim(\common\components\Helper::REGEXP_PHONE, '/'),
        ]);

        echo $form->field($model, 'best_time2contact', [
            'options' => ['class' => 'col-xs-12 col-sm-12 col-md-12'],
        ])->textInput(['placeholder' => 'Enter date and/or time']);
    ?>
            </div>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12"><p></p>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="panel panel-default fieldGroupUserAddress">
            <div class="panel-heading">
                <h2 class="panel-title">Address</h2>
            </div>

            <div class="panel-body">
    <?php
        echo $form->field($model, 'address_street', [
            'options' => ['class' => 'col-xs-12 col-sm-12 col-md-12'],
        ])->textInput();

        echo $form->field($model, 'address_town', [
            'options' => ['class' => 'col-xs-12 col-sm-12 col-md-12'],
        ])->textInput();

        echo $form->field($model, 'address_county', [
            'options' => ['class' => 'col-xs-12 col-sm-12 col-md-12'],
        ])->textInput();

        echo $form->field($model, 'address_postcode', [
            'options' => ['class' => 'col-xs-12 col-sm-12 col-md-6'],
        ])->textInput([
            'pattern' => trim(\common\components\Helper::REGEXP_POSTCODE, '/'),
            'placeholder'	 => 'e.g. YO1',
        ]);
    ?>
            </div>
        </div>
    </div>


<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="col-xs-6 col-sm-3 col-md-2">
            <?php
                echo Html::button('Close', [
                    'class' => 'btn btn-form pull-left',
                    'onClick' => '$("#profile-modal").modal("hide")'
                ]);
            ?>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-8"></div>
        <div class="col-xs-6 col-sm-3 col-md-2">
            <?php
                echo Html::submitButton('Save', ['class' => 'btn btn-form pull-right', 'name' => 'save_button']);
            ?>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>

<?php Modal::end(); ?>