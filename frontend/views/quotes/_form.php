<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\QuoteResponse */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="quote-response-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'instant_quote_id')->textInput() ?>

    <?= $form->field($model, 'quote_company_id')->textInput() ?>

    <?= $form->field($model, 'legal_fee')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vat')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'disbursements')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'stamp_duty')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'total_amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'reference_number')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
