<?php

namespace frontend\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\components\Helper;
use common\models\InstantQuote;
use common\models\QuoteResponseDetail;
use common\models\QuoteResponse;
use common\components\quotes\conveyancing\QuoteCreator;

/**
 * QuotesController implements the CRUD actions for QuoteResponse model.
 */
class QuotesController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

	/**
	 * Displays `quote form`.
	 *
	 * @return mixed
	 */
	public function actionIndex()
	{
		$instantQuote = new InstantQuote();

		$this->createQuoteByForm($instantQuote);

		return $this->render('index', ['model' => $instantQuote]);
	}

	/**
	 * Displays `quote form` with pre filled fields.
	 *
	 * @return mixed
	 */
	public function actionQuoteprefilled()
	{
		$instantQuote = new InstantQuote();

		if(!Yii::$app->request->post())
			$instantQuote->setDefaultFields();

		$this->createQuoteByForm($instantQuote);

		return $this->render('index', ['model' => $instantQuote]);
	}

	protected function createQuoteByForm(InstantQuote $instantQuote)
	{
		if ($instantQuote->load(Yii::$app->request->post()) && $instantQuote->validate()) {
			$instantQuote->clearDirtyFields();

			if($instantQuote->save()){
				$quote = new QuoteCreator();

				if($quote->createQuote($instantQuote)){

					//redirect to quote page
					$this->redirect(['quotes/show', 'id' => $instantQuote->id]);
				}
			}
		} else {
			$instantQuote->type = InstantQuote::TYPE_BUY;
			$instantQuote->property_type = InstantQuote::FREEHOLD;
			$instantQuote->selling_property_type = InstantQuote::FREEHOLD;
			$instantQuote->remortgage_property_type = InstantQuote::FREEHOLD;
		}

	}

	/**
	 * Lists QuoteResponse models by quote
	 * @param integer $id
	 * @return mixed
	 */
	public function actionShow($id)
	{
		$quoteInfo = Helper::getInstantConveyancingInfoById($id);
		$gridLayout = "{items}";

		$dataProvider = new ActiveDataProvider([
			'query' => QuoteResponse::find()->with('quoteCompany')->where(['instant_quote_id' => $id]),
		]);

		return $this->render('view', [
				'dataProvider' => $dataProvider,
				'quoteInfo' => $quoteInfo,
				'gridLayout' => $gridLayout,
			]);
	}


	/**
     * Displays a single QuoteResponse model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
		$quoteResult = QuoteResponse::find()->with('quoteCompany')->where(['id' => $id])->one();

		$dataProvider = new ActiveDataProvider([
			'query' => QuoteResponseDetail::find()->where(['quote_response_id' => $id]),
		]);


		$quoteDetail = [
			'self' => [
				'items' => [
					'selling' => [],
					'buying' => [],
					'undefined' => []
				],
				'sub-total' => 0
			],
			'other' => [
				'items' => [
					'selling' => [],
					'buying' => [],
					'undefined' => []
				],
				'sub-total' => 0
			],
			'total' => 0
		];

		foreach($dataProvider->models as $model){
			if($model->type == QuoteResponseDetail::TYPE_BUYING && $model->is_disbursements == QuoteResponseDetail::IS_NOT_DISBURSTEMENTS){
				$quoteDetail['self']['items']['buying'][$model->description] = $model->amount;
			}
			if($model->type == QuoteResponseDetail::TYPE_SELLING && $model->is_disbursements == QuoteResponseDetail::IS_NOT_DISBURSTEMENTS){
				$quoteDetail['self']['items']['selling'][$model->description] = $model->amount;
			}
			if($model->type == QuoteResponseDetail::TYPE_UNDEFINED && $model->is_disbursements == QuoteResponseDetail::IS_NOT_DISBURSTEMENTS){
				$quoteDetail['self']['items']['undefined'][$model->description] = $model->amount;
			}

			if($model->type == QuoteResponseDetail::TYPE_BUYING && $model->is_disbursements == QuoteResponseDetail::IS_DISBURSTEMENTS){
				$quoteDetail['other']['items']['buying'][$model->description] = $model->amount;
			}
			if($model->type == QuoteResponseDetail::TYPE_SELLING && $model->is_disbursements == QuoteResponseDetail::IS_DISBURSTEMENTS){
				$quoteDetail['other']['items']['selling'][$model->description] = $model->amount;
			}
			if($model->type == QuoteResponseDetail::TYPE_UNDEFINED && $model->is_disbursements == QuoteResponseDetail::IS_DISBURSTEMENTS){
				$quoteDetail['other']['items']['undefined'][$model->description] = $model->amount;
			}

			if($model->is_disbursements == QuoteResponseDetail::IS_NOT_DISBURSTEMENTS){
				$quoteDetail['self']['sub-total'] += $model->amount;
			}
			if($model->is_disbursements == QuoteResponseDetail::IS_DISBURSTEMENTS){
				$quoteDetail['other']['sub-total'] += $model->amount;
			}

			$quoteDetail['total'] += $model->amount;
		}

        return $this->render('detail', [
            'dataProvider' => $quoteDetail,
			'quoteResult' => $quoteResult
        ]);
    }

    /**
     * Creates a new QuoteResponse model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
/*
    public function createNewQuote(\common\models\InstantQuote $instantQuote)
    {
        $model = new QuoteResponse();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
*/
    /**
     * Updates an existing QuoteResponse model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
/*
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
*/
    /**
     * Finds the QuoteResponse model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return QuoteResponse the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = QuoteResponse::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
