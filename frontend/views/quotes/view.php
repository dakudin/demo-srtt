<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $quoteInfo string */
/* @var $gridLayout string */


$this->title = 'Conveyancing result';

$this->params['breadcrumbs'][] =
	[
		'label' => 'Conveyancing',
		'url' => ['quotes/index']
	];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="quote-response-index">

	<h1><?= Html::encode($this->title) ?></h1>

	<h4 class="lead"><?= $quoteInfo ?></h4>

	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'showFooter' => false,
		'tableOptions' => ['class' => 'table'],
		'layout' => $gridLayout,
		'columns' => [

			[
				'attribute' => 'quote_company.company_name',
				'label' => 'Solicitor firm',
				'format' => 'html',
				'value' => function($model){
					return Html::img('../../images/companies/'.$model->quoteCompany->image, [
						'class' => 'img-responsive',
						'alt' => Html::encode($model->quoteCompany->company_name)
					]);
				},
				'headerOptions' => ['style' => 'width:20%'],
			],
			[
				'attribute' => 'legal_fee',
				'format' => 'html',
				'value' => function($model){ return '&pound;' . number_format($model->legal_fee,2); }
			],
			[
				'attribute' => 'vat',
				'format' => 'html',
				'value' => function($model){ return '&pound;' . number_format($model->vat,2); }
			],
			[
				'attribute' => 'disbursements',
				'format' => 'html',
				'value' => function($model){ return '&pound;' . number_format($model->disbursements,2); }
			],
			[
				'attribute' => 'total_amount',
				'format' => 'html',
				'value' => function($model){
					$value = '<p>&pound;' . number_format($model->total_amount,2) . '</p>';
					if($model->stamp_duty!=0) $value .= '<p style="line-height:0.5"><small>plus Stamp duty</small></p><p style="line-height:0.5"><small>&pound;'
						. number_format($model->stamp_duty,2) . '</small></p>';
					return $value;
				}
			],
			// 'reference_number',

			[
				'class' => 'yii\grid\ActionColumn',
				'buttons'=>[
					'view'=> function ($url, $model, $key) {
						return Html::a('More Details >', ['quotes/view', 'id'=>$model->id], ['class'=>'btn btn-primary grid-button center-block']);
					},
				],
				'template' => '{view}'
			],
		],
	]); ?>
</div>
