<?php
/**
 * Created by PhpStorm.
 * User: Monk
 * Date: 19.08.2019
 * Time: 18:26
 */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>

<?php $form = ActiveForm::begin([
    'id' => 'login-form',
    'enableAjaxValidation' => true,
    'action' => ['site/ajax-login'],
]);
echo $form->field($model, 'email')->label(false)->textInput(['placeholder' => 'Enter your email']);
echo $form->field($model, 'password')->label(false)->passwordInput(['placeholder' => 'Enter your password']);
?>

<div class="form-group">
    <?php echo Html::submitButton('Continue', ['class' => 'btn btn-primary btn-block', 'name' => 'login-button']); ?>
</div>


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

<?php echo $this->render('_agreement', ['button_title' => 'continue']); ?>