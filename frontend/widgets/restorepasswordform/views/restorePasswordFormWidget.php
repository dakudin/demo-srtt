<?php
/**
 * Created by Kudin Dmitry
 * Date: 05.11.2018
 * Time: 10:32
 */

/* @var $model frontend\models\ResetPasswordForm */

//namespace frontend\widgets\restorepasswordform;

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;
use frontend\widgets\restorepasswordform\AppAsset;

AppAsset::register($this);

Modal::begin([
    'header'=>'<h4>Request password reset</h4>',
    'id'=>'restore-password-modal',
    'closeButton' => false,
    'clientOptions' => [
        'show' => false,
        'backdrop' => 'static',
        'keyboard' => false
    ],
]);
?>

    <div id="system-messages" style="opacity: 1; display: none"></div>

    <p>Please fill out your email. A link to reset password will be sent there.</p>

    <?php $form = ActiveForm::begin([
            'id' => 'request-password-reset-form',
            'enableAjaxValidation' => true,
            'action' => ['site/ajax-request-password-reset'],
            'validateOnSubmit' => true,
            'validationUrl' => ['site/validate-password-reset-form'],
        ]);
    ?>

    <?= $form->field($model, 'email')->textInput(/* ['autofocus' => true] */) ?>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <span class="pull-right">
                <?php
                    echo Html::submitButton('Send', ['class' => 'btn btn-primary', 'name' => 'save_button']);
                ?>
                or
                <?php
                echo Html::button('Sign in', [
                    'class' => 'btn btn-primary',
                    'data-toggle' => 'modal',
                    'data-target' => '#login-modal',
                    'onClick' => '$("#restore-password-modal").modal("hide")'
                ]);
                ?>
            </span>
        </div>
    </div>


<?php ActiveForm::end(); ?>

<?php Modal::end(); ?>