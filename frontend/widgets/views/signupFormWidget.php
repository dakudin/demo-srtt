<?php
/**
 * Created by Kudin Dmitry
 * Date: 28.09.2018
 * Time: 12:15
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;
use yii\authclient\widgets\AuthChoice;

    Modal::begin([
        'header'=>'<h4>Signup</h4>',
        'id'=>'signup-modal',
//        'closeButton' => false,
        'clientOptions' => [
//            'backdrop' => 'static',
//            'keyboard' => false
        ],
        'footer' => $this->render('_agreement')
            .'<h5 class="text-center">Already have an account? <a href="#" data-toggle="modal" data-target="#login-modal" onclick="$(\'#signup-modal\').modal(\'hide\')">Sign in</a></h5>',
    ]);

?>


<?php
    $form = ActiveForm::begin([
        'id' => 'form-signup',
        'enableAjaxValidation' => true,
        'action' => ['site/ajaxsignup'],
    ]);

    echo $form->field($model, 'email')->label(false)->textInput(['placeholder' => 'Enter your email']);
    echo $form->field($model, 'password')->label(false)->passwordInput(['placeholder' => 'Enter your password']);
?>

    <div class="form-group">
        <?php
            echo Html::submitButton('Continue', ['class' => 'btn btn-primary btn-block', 'name' => 'signup-button']);
        ?>
    </div>

<?php ActiveForm::end(); ?>

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
<?php Modal::end(); ?>