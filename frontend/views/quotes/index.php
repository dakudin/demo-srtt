<?php

/* @var $this yii\web\View */

use yii\widgets\ActiveForm;

$this->title = 'Quote';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-index">

	<div class="body-content">

		<div class="row">
			<?php
			$form = ActiveForm::begin([
				'id' => 'quote-form',
				'options' => ['class' => 'form-horizontal quote-form quote-form_state_buy'],
			])
			?>

			<div class="col-xs-12">
				<h2 class="pull-left quote-form__title">Instant quote in 3 steps</h2>
			</div>

			<div class="col-xs-12 quote-form__group-label">
				1. I am looking to
			</div>

			<div class="col-xs-12 quote-form__looking-types button-wrapper" data-toggle="buttons">
				<label class="btn btn-primary active radio-inline col-xs-5 col-sm-5 col-md-3">
					<input type="radio" name="InstantQuote[type]" value="buy" id="type-buy" <?= $model->type == \common\models\InstantQuote::TYPE_BUY ? 'checked="checked"' : ''?>>Buy
				</label>
				<label class="btn btn-primary radio-inline col-xs-5 col-sm-5 col-md-3">
					<input type="radio" name="InstantQuote[type]" value="buy_n_sell" id="type-buy_n_sell" <?= $model->type == \common\models\InstantQuote::TYPE_BUY_N_SELL ? 'checked="checked"' : ''?>>Buy & Sell
				</label>
				<label class="btn btn-primary radio-inline col-xs-5 col-sm-5 col-md-3">
					<input type="radio" name="InstantQuote[type]" value="sell" id="type-sell" <?= $model->type == \common\models\InstantQuote::TYPE_SELL ? 'checked="checked"' : ''?>>Sell
				</label>
				<label class="btn btn-primary radio-inline col-xs-5 col-sm-5 col-md-3">
					<input type="radio" name="InstantQuote[type]" value="remortgage" id="type-remortgage" <?= $model->type == \common\models\InstantQuote::TYPE_REMORTGAGE ? 'checked="checked"' : ''?>>Remortgage
				</label>
			</div>

			<div class="col-xs-12 quote-form__group-label">
				2. My property detail
			</div>
			<div class="col-xs-12">
				<?php echo $form->field($model, 'buying_price', [
					'template'=>"{label}\n<div class=\"input-group\"><span class=\"input-group-addon\">&pound;</span>\n{input}</div>\n{hint}\n{error}",
					'options' => [
						'class' => 'col-xs-12 col-sm-12 col-md-4 field_type_buying field_type_price',
						'pattern' => '[0-9]*',
					],
				])->textInput([
					'pattern' => '[0-9]*',
//							'placeholder' => 'from &pound;1,000 to &pound;2,000,000',
				]);
				?>

				<?php echo $form->field($model, 'buying_postcode', [
					'options' => [
						'class' => 'col-xs-12 col-sm-12 col-md-4 field_type_buying',
					],
				])->textInput(
					[
						'pattern' => trim(\common\components\Helper::REGEXP_POSTCODE, '/'),
						'placeholder'	 => 'e.g. YO1',
					]);
				?>

				<div class="col-xs-12 col-sm-12 col-md-4 field_type_buying">
					<label class="control-label">The property is</label>
					<div class="btn-group button-wrapper button-wrapper_type_fixed" data-toggle="buttons">
						<label class="btn btn-primary active radio-inline active">
							<input type="radio" name="InstantQuote[property_type]" value="freehold"
								<?= $model->property_type == \common\models\InstantQuote::FREEHOLD ? 'checked="checked"' : ''?>>Freehold
						</label>
						<label class="btn btn-primary radio-inline">
							<input type="radio" name="InstantQuote[property_type]" value="leasehold"
								<?= $model->property_type == \common\models\InstantQuote::LEASEHOLD ? 'checked="checked"' : ''?>>Leasehold
						</label>
					</div>
				</div>
			</div>
			<div class="col-xs-12">
				<?php
				echo $form->field($model, 'has_buying_mortgage', [
					'options' => ['class' => 'col-xs-12 col-sm-12 col-md-12 field_type_buying'],
				])->checkbox();

				echo $form->field($model, 'is_new_build', [
					'options' => ['class' => 'col-xs-12 col-sm-12 col-md-12 field_type_buying'],
				])->checkbox();

				echo $form->field($model, 'is_second_purchase', [
					'options' => ['class' => 'col-xs-12 col-sm-12 col-md-12 field_type_buying'],
				])->checkbox();


				echo $form->field($model, 'selling_price', [
					'template'=>"{label}\n<div class=\"input-group\"><span class=\"input-group-addon\">&pound;</span>\n{input}</div>\n{hint}\n{error}",
					'options' => ['class' => 'col-xs-12 col-sm-12 col-md-4 field_type_selling field_type_price'],
				])->textInput();

				echo $form->field($model, 'selling_postcode', [
					'options' => [
						'class' => 'col-xs-12 col-sm-12 col-md-4 field_type_selling',
					],
				])->textInput([
					'pattern' => trim(\common\components\Helper::REGEXP_POSTCODE, '/'),
					'placeholder' => 'e.g. YO1',
				]);
				?>

				<div class="col-xs-12 col-sm-12 col-md-4 field_type_selling">
					<label class="control-label">The property is</label>
					<div class="btn-group button-wrapper button-wrapper_type_fixed" data-toggle="buttons">
						<label class="btn btn-primary active radio-inline active">
							<input type="radio" name="InstantQuote[selling_property_type]" value="freehold"
								<?= $model->selling_property_type == \common\models\InstantQuote::FREEHOLD ? 'checked="checked"' : ''?>>Freehold
						</label>
						<label class="btn btn-primary radio-inline">
							<input type="radio" name="InstantQuote[selling_property_type]" value="leasehold"
								<?= $model->selling_property_type == \common\models\InstantQuote::LEASEHOLD ? 'checked="checked"' : ''?>>Leasehold
						</label>
					</div>
				</div>
			</div>

			<div class="col-xs-12">

				<?php
				echo $form->field($model, 'has_selling_mortgage', [
					'options' => ['class' => 'col-xs-12 col-sm-12 col-md-12 field_type_selling'],
				])->checkbox();

				echo $form->field($model, 'remortgage_price', [
					'template'=>"{label}\n<div class=\"input-group\"><span class=\"input-group-addon\">&pound;</span>\n{input}</div>\n{hint}\n{error}",
					'options' => ['class' => 'col-xs-12 col-sm-12 col-md-4 field_type_remortgage field_type_price'],
				])->textInput();

				echo $form->field($model, 'remortgage_postcode', [
					'options' => [
						'class' => 'col-xs-12 col-sm-12 col-md-4 field_type_remortgage',
					],
				])->textInput([
					'pattern' => trim(\common\components\Helper::REGEXP_POSTCODE, '/'),
					'placeholder' => 'e.g. YO1',
				]);
				?>
				<div class="col-xs-12 col-sm-12 col-md-4 field_type_remortgage">
					<label class="control-label">The property is</label>
					<div class="btn-group button-wrapper button-wrapper_type_fixed" data-toggle="buttons">
						<label class="btn btn-primary active radio-inline active">
							<input type="radio" name="InstantQuote[remortgage_property_type]" value="freehold"
								<?= $model->remortgage_property_type == \common\models\InstantQuote::FREEHOLD ? 'checked="checked"' : ''?>>Freehold
						</label>
						<label class="btn btn-primary radio-inline">
							<input type="radio" name="InstantQuote[remortgage_property_type]" value="leasehold"
								<?= $model->remortgage_property_type == \common\models\InstantQuote::LEASEHOLD ? 'checked="checked"' : ''?>>Leasehold
						</label>
					</div>
				</div>
			</div>

			<?php
			echo $form->field($model, 'transfer_of_enquity', [
				'options' => ['class' => 'col-xs-12 col-sm-12 col-md-12 field_type_remortgage'],
			])->checkbox();
			?>

			<div class="col-xs-12 quote-form__group-label">
				3. About me
			</div>

			<?php

			echo $form->field($model, 'first_name', [
				'options' => ['class' => 'col-xs-12 col-sm-12 col-md-6'],
			])->textInput();

			echo $form->field($model, 'last_name', [
				'options' => ['class' => 'col-xs-12 col-sm-12 col-md-6'],
			])->textInput();

			echo $form->field($model, 'email', [
				'options' => ['class' => 'col-xs-12 col-sm-12 col-md-12'],
			])->textInput();

			echo $form->field($model, 'phone', [
				'options' => ['class' => 'col-xs-12 col-sm-12 col-md-12'],
			])->textInput([
				'pattern' => trim(\common\components\Helper::REGEXP_PHONE, '/'),
			]);
			?>

			<div class="col-xs-12 col-sm-12 col-md-12 quote-form__my-details">
				<label>
					<input type="checkbox" id="acceptConfirm" name="InstantQuote[accept-confirm]" />
					<span style="padding-left: 5px"><?php echo \common\components\Helper::QUOTE_CONFIRMATION_TEXT ?></span>
				</label>
			</div>
			<div class="form-group">
				<div class="col-xs-12 text-center">
					<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-refresh glyphicon-refresh-animate processing"></span>
						<span class="default">Request Quotes</span><span class="processing">Loading...</span></button>
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
			lastActive = findClassNameByString(form, '_state_'),
			myDetails = form.find('.quote-form__my-details input');

		form.find('.quote-form__looking-types input').change(
			function () {

				var newClass = 'quote-form_state_' + this.value;

				form.removeClass(lastActive).addClass(newClass);

				lastActive = newClass;
			}
		);

		form.on('afterValidate', formAfterValidateHandler);

		myDetails.change(myDetailChangeHandler);
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

	function findClassNameByString(element, string)
	{
		var names = element.attr('class').split(' '),
			length = names.length,
			i = 0;

		for(; i < length; ++i)
			if (names[i].indexOf(string) >= 0)
				return names[i];

		return '';
	}

	function contentLoaded()
	{
		addListeners();
		myDetailChangeHandler()
	}

	document.addEventListener("DOMContentLoaded", contentLoaded);
</script>
