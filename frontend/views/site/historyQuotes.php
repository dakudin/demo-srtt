<?php
/**
 * Created by PhpStorm.
 * User: Monk
 * Date: 07.03.2019
 * Time: 10:35
 */

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\grid\GridView;
use yii\helpers\Html;
use common\components\QuoteHelper;
use yii\helpers\Url;

$this->title = 'My Quotes | Sortit';
$this->registerLinkTag(['rel' => 'canonical', 'href' => Url::canonical()], 'canonical');

$this->params['breadcrumbs'][] = 'My quotes';
?>
    <div class="site-index">

        <div class="body-content">

            <h1 class="pull-left title quote-form__title">My quotes</h1>

            <?php
    echo GridView::widget([
//        'filterModel' => $searchModel,
        'dataProvider' => $dataProvider,
        'showFooter' => false,
        'tableOptions' => ['class' => 'table'],
        'layout' => '{items}{pager}',
        'columns' => [
            [
                'attribute' => 'category_id',
                'value' => 'enquiryCategory.name',
                'label' => 'Quote category',
            ],
            [
                'attribute' => 'created_at',
                'value' => function($model){
                    return Yii::$app->formatter->asDatetime($model->created_at);
                }
            ],
            [
                'attribute' => 'quote_company.company_name',
                'label' => 'Sent to',
                'format' => 'html',
                'value' => function($model){
                    $companies = QuoteHelper::getRetailersInfoByEnquiryResult($model->parsed_results);
                    $value = '';
                    foreach($companies as $id => $company) {
                        $value .= '<div class="quote-form__retailer-title">';
                        if ($company['image']) {
                            $value .= Html::img($company['image'], [
                                'class' => 'img-responsive img-thumbnail',
                                'alt' => Html::encode($company['name'])
                            ]);
                        }elseif($company['name']){
                            $value .= Html::encode($company['name']);
                        }
                        if (!empty($company['rated'])) {
                            $value .= Html::encode(' ' . $company['rated'] . ' scores');
                        }
                        $value .= '</div>';
                    }
                    return $value;
                },
            ],

        ]
    ]);

?>

        </div>
    </div>

