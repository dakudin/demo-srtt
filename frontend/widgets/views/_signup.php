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

<?php
$form = ActiveForm::begin([
    'id' => 'form-signup',
    'enableAjaxValidation' => true,
    'action' => ['site/ajaxsignup'],
]);

echo $form->field($model, 'email')->label(false)->textInput(['placeholder' => 'Enter your email']);
echo $form->field($model, 'password')->label(false)->passwordInput(['placeholder' => 'Enter your password']);
echo $form->field($model, 'confirm_password')->label(false)->passwordInput(['placeholder' => 'Confirm your password']);
?>

<div class="form-group">
    <?php echo Html::submitButton('Register', ['class' => 'btn btn-primary btn-block', 'name' => 'signup-button']); ?>
</div>

<?php ActiveForm::end(); ?>

<?php echo $this->render('_agreement', ['button_title' => 'register']); ?>