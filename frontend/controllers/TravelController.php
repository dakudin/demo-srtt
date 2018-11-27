<?php
/**
 * Created by Kudin Dmitry.
 * Date: 05.10.2017
 * Time: 15:53
 */

namespace frontend\controllers;

use common\components\quotes\travel\ski\skikings\SkiKingsQuote;
use common\components\quotes\travel\TravelQuoteCreator;
use common\components\Helper;
use common\models\DictAirport;
use common\models\DictBoardBasis;
use common\models\DictCountry;
use common\models\DictHotelGrade;
use common\models\DictRegion;
use common\models\DictResort;
use Yii;
use yii\web\Controller;
use common\models\TravelQuote;
use common\models\Category;
use frontend\models\SkiEnquiryForm;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use frontend\helpers\FHelper;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;


class TravelController extends Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {

        return [
/*
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['beach', 'skiing'],
                'rules' => [
                    [
                        'actions' => ['skiing', 'beach'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
*/
/*
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
*/
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionSkiingenquiry($id, $company_id, $resort_id)
    {
        $instantQuote = TravelQuote::findOne(['id' => $id]);
        if(!is_null($instantQuote->parsed_results)){
            $parsedResults = unserialize($instantQuote->parsed_results);

            if(is_array($parsedResults)){
                foreach($parsedResults as $parsedResult){
                    if($parsedResult->companyId != (int)$company_id) continue;

                    $company = $parsedResult;
                    $resort = $company->resorts[(int)$resort_id];
                }
            }
        }

        if(!isset($resort)){
            throw new BadRequestHttpException('The page does not exists');
        }

        $skiEnquiryForm = new SkiEnquiryForm();
        $skiEnquiryForm->enquire_message = strip_tags(Helper::getTravelQuoteInfoById($instantQuote));
        $skiEnquiryForm->current_url = $resort['detailUrl'];

        if($skiEnquiryForm->load(Yii::$app->request->post()) && $skiEnquiryForm->validate()){

            $quote = new SkiKingsQuote($instantQuote);

            Yii::$app->session->removeAllFlashes();
            if($quote->sendEnquiry($skiEnquiryForm->attributes + SkiEnquiryForm::getAdditionalParam())){
                Yii::$app->session->setFlash('success', 'Thank you for your enquiry. We will respond to you as soon as possible.');
            }else{
                Yii::$app->session->setFlash('error', 'There was an error sending your enquiry.');
            }
        }


        return $this->render('sendSki', [
            'model' => $skiEnquiryForm,
            'instantQuote' => $instantQuote,
            'company' => $company,
            'resort' => $resort

        ]);
    }

    /**
     * @param $id integer
     * @return mixed
     */
    public function actionViewski($id)
    {
        return $this->viewQuote($id, 'ski');
    }

    /**
     * @param $id integer
     * @return mixed
     */
    public function actionViewbeach($id)
    {
        return $this->viewQuote($id, 'luxury');
    }

    /**
     * @param integer
     * @param $travelCategory string
     * @return string
     * @throws BadRequestHttpException
     */
    protected function viewQuote($id, $travelCategory)
    {
        $instantQuote = TravelQuote::findOne(['id' => $id]);
        if(!isset($instantQuote)){
            throw new BadRequestHttpException('The page does not exists');
        }

        if($instantQuote->category_id == Category::SKI){
            $companyCountries = [4];
        }else{
            $companyCountries = [5];
        }
        $instantQuote->fillDictionaryIDs($companyCountries);

        // check AJAX request: if filter was changed - change quote
        $result = $this->updateQuoteByFilter($instantQuote);
        if($result !== FALSE){
            return $result;
        }

        $quoteServices=[];
        if(!is_null($instantQuote->parsed_results)){
            $parsedResults = unserialize($instantQuote->parsed_results);

            if(is_array($parsedResults)){
                $quoteServices = $parsedResults;
            }
        }

       return $this->render('view', [
            'instantQuote' => $instantQuote,
            'quoteServices' => $quoteServices,
            'travelCategory' => $travelCategory,
            'quoteInfo' => Helper::getTravelQuoteInfoById($instantQuote),
            'listBoardBasis' => $this->getListBoardBasis($companyCountries),
            'listHotelGrade' => $this->getListHotelGrade($companyCountries),
        ]);
    }

    /**
     * @param $instantQuote TravelQuote
     * @return string|boolean
     */
    protected function updateQuoteByFilter($instantQuote)
    {
        $quoteServices = [];

        if($instantQuote->load(Yii::$app->request->post()) && $instantQuote->validate()){
            if($instantQuote->save()){

                $quote = new TravelQuoteCreator();
                $instantQuote->refresh();

                if($quote->createQuote($instantQuote)){
                    if(!is_null($instantQuote->parsed_results)){
                        $parsedResults = unserialize($instantQuote->parsed_results);

                        if(is_array($parsedResults)){
                            $quoteServices = $parsedResults;
                        }
                    }

                    return $this->renderAjax('_results', [
                        'instantQuote' => $instantQuote,
                        'quoteServices' => $quoteServices,
                    ]);
                }
            }
        }

        return false;
    }

    /**
     * Displays travel categories.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Displays `quote form`.
     *
     * @return mixed
     */
    public function actionSkiing()
    {
        $instantQuote = new TravelQuote();
        $instantQuote->category_id = Category::SKI;
        $instantQuote = $this->setDefaultValues($instantQuote);

        return $this->showQuote($instantQuote);
    }

    /**
     * Displays `Beach quote form`.
     *
     * @return mixed
     */
    public function actionBeach()
    {
        $instantQuote = new TravelQuote();
        $instantQuote->category_id = Category::LUXURY;
        $instantQuote = $this->setDefaultValues($instantQuote);

        return $this->showQuote($instantQuote);
    }

    /**
     * @param TravelQuote $instantQuote
     * @return TravelQuote
     */
    protected function setDefaultValues(TravelQuote $instantQuote){
        $instantQuote->duration = 0;
        $instantQuote->passengers = 2;

        return $instantQuote;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $instantQuote = TravelQuote::findOne(['id' => $id]);
        if (is_null($instantQuote)) {
            $this->redirect('site/index');
        }

        $instantQuote->setDefaultFilter();

        return $this->showQuote($instantQuote);
    }

    /**
     * @param $instantQuote TravelQuote
     * @return mixed
     */
    protected function showQuote(TravelQuote $instantQuote)
    {
        if($instantQuote->category_id == Category::SKI){
            $viewNameCreate = 'createSki';
            $viewNameView = 'skiing/view';
            $companyCountries = [4];
        }else{
            $viewNameCreate = 'createBeach';
            $viewNameView = 'beach/view';
            $companyCountries = [5];
        }
        $instantQuote->page_number = 1;
        $instantQuote->fillDictionaryIDs($companyCountries);

        if($instantQuote->load(Yii::$app->request->post()) && $instantQuote->validate()){

            return $this->render('sendResults',[
                'quoteInfo' => '<p>All is good</p>'
            ]);

/*            if($instantQuote->save()){

                FHelper::setRequestQuoteAgreementCookies();

                $quote = new TravelQuoteCreator();
                $instantQuote->refresh();

                if($quote->createQuote($instantQuote)){
                    return $this->render('sendResults',[
                        'quoteInfo' => $quote->getQuoteTextInfo()
                        ]);
                }
            }*/
        }

        if(!empty($instantQuote->date)) {
            $date = \DateTime::createFromFormat('Y-m-d', $instantQuote->date);
            if($date !== false)
                $instantQuote->date = $date->format('d M Y');
        }

        return $this->render($viewNameCreate, [
            'model' => $instantQuote,
            'companyIDs' => implode(',', $companyCountries),
            'listRegions' => $this->getListRegions($instantQuote, $companyCountries),
            'listCountries' => $this->getListCountries($instantQuote, $companyCountries),
            'listResorts' => $this->getListResorts($instantQuote, $companyCountries),
            'listAirports' => $this->getListAirports($instantQuote, $companyCountries),
        ]);
    }

    /**
     * @param TravelQuote $instantQuote
     * @param $companyCountries array
     * @return array
     */
    protected function getListRegions(TravelQuote $instantQuote, $companyCountries)
    {
        $listRegions = [];
        if($instantQuote->category_id == Category::LUXURY) {
            $regions = DictRegion::getRegionsByCompany($companyCountries);
            $listRegions = ArrayHelper::map($regions, 'id', 'name');
        }

        return $listRegions;
    }

    /**
     * @param TravelQuote $instantQuote
     * @param $companyCountries array
     * @return array
     */
    protected function getListCountries(TravelQuote $instantQuote, $companyCountries)
    {
        $listCountries = [];
        if($instantQuote->category_id == Category::SKI) {
            $listCountries = [0 => 'Any Country'];
        }

        $countries = DictCountry::getCountriesByCompany($companyCountries, $instantQuote->regionIDs);
        $listCountries += ArrayHelper::map($countries, 'id','name');

        return $listCountries;
    }

    /**
     * @param TravelQuote $instantQuote
     * @param $companyCountries array
     * @return array
     */
    protected function getListResorts(TravelQuote $instantQuote, $companyCountries)
    {
        $listResorts = [];
        if($instantQuote->category_id == Category::SKI) {
            $listResorts = [0 => 'Any Resort'];
        }

        $resorts = DictResort::getResortsByCompany($companyCountries, $instantQuote->countryIDs);
        $listResorts += ArrayHelper::map($resorts, 'id','name');

        return $listResorts;
    }

    /**
     * @param TravelQuote $instantQuote
     * @param $companyCountries array
     * @return array
     */
    protected function getListAirports(TravelQuote $instantQuote, $companyCountries)
    {
        $listAirports = [];
        if($instantQuote->category_id == Category::SKI) {
            $listAirports = [0 => 'Any Airport'];
        }

        $airports = DictAirport::getAirportsByCompany($companyCountries);
        $listAirports += ArrayHelper::map($airports, 'id','name');

        return $listAirports;
    }

    /**
     * @param $companyCountries array
     * @return array
     */
    protected function getListBoardBasis($companyCountries)
    {
        return ArrayHelper::map(DictBoardBasis::getBoardBasisByCompany($companyCountries), 'id','name');
    }

    /**
     * @param $companyCountries array
     * @return array
     */
    protected function getListHotelGrade($companyCountries)
    {
        return ArrayHelper::map(DictHotelGrade::getHotelGradeByCompany($companyCountries), 'id','name');
    }
}