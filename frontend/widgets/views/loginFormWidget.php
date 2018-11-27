<?php
/**
 * Created by Kudin Dmitry
 * Date: 10.09.2018
 * Time: 9:33
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;
use yii\authclient\widgets\AuthChoice;

Modal::begin([
    'header'=>'<h4>Sign in</h4>',
    'id'=>'login-modal',
//    'closeButton' => false,
    'clientOptions' => [
//        'show' => true,
//        'backdrop' => 'static',
//        'keyboard' => false
    ],
    'footer' => $this->render('_agreement')
        .'<h5 class="text-center">New here? <a href="#" data-toggle="modal" data-target="#signup-modal" onclick="$(\'#login-modal\').modal(\'hide\')">Create an account</a></h5>'
]);
?>

<?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'enableAjaxValidation' => true,
//        'onsubmit' => 'sendAjax(this, myAction)',
        'action' => ['site/ajax-login'],
    ]);
    echo $form->field($model, 'email')->label(false)->textInput(['placeholder' => 'Enter your email']);
    echo $form->field($model, 'password')->label(false)->passwordInput(['placeholder' => 'Enter your password']);
?>

    <div class="form-group">
        <?php
            echo Html::submitButton('Continue', ['class' => 'btn btn-primary btn-block', 'name' => 'login-button']);
        ?>
    </div>

    <div class="horizontal-divider">
        <span>Or</span>
    </div>

<?php
$authAuthChoice = AuthChoice::begin([
    'baseAuthUrl' => ['site/auth'],
    'popupMode' => false,
    'options' => ['class' => 'form-group']
]);

foreach ($authAuthChoice->getClients() as $client) {
    echo $authAuthChoice->clientLink($client,
        '<span class="fa fa-' . $client->getName() . '"></span> Continue with ' . $client->getTitle(),
        [
            'class' => 'btn btn-primary btn-block btn-social btn-' . $client->getName(),
        ]);
}

AuthChoice::end();
?>

    <div class="row">
            <?php
                echo $form->field($model, 'rememberMe', [
                    'options' => ['class' => 'col-xs-6 col-sm-6 col-md-6 text-left']
                ])->checkbox()->label('Keep me logged in');
            ?>
        <div class="col-xs-6 col-sm-6 col-md-6 text-right checkbox">
            <a href="#" data-toggle="modal" data-target="#restore-password-modal" onclick="$('#login-modal').modal('hide')">Forgot your password?</a>
        </div>
    </div>

<?php ActiveForm::end(); ?>
<?php Modal::end(); ?>