<?php
namespace frontend\controllers;

use common\models\DictAirport;
use common\models\DictCountry;
use common\models\DictResort;
use common\models\GeoCity;
use common\models\GeoRegion;
use common\models\GeoCountry;
use \yii\web\Controller;
use yii;

class DataController extends Controller
{

    public function beforeAction($action)
    {
        // Set the format response
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return parent::beforeAction($action);
    }

    public function actionResorts() {
        $result = [];
        $cid = Yii::$app->request->post('cid');
//        $rid = Yii::$app->request->post('rid');

        $companyIDs = Yii::$app->request->post('company-ids');
        if(!is_null($companyIDs))
            $companyIDs = explode(',', $companyIDs);

        $showAnyValue = Yii::$app->request->post('show-any-value');
        if(!is_null($showAnyValue) && $showAnyValue=='1')
            $result = [['id' => '0', 'name' => 'Any Resort']];

        if(is_null($cid)) return $result;

        $resorts = DictResort::getResortsByCompany($companyIDs, $cid);

        if(empty($resorts)) return $result;

        foreach($resorts as $resort){
            $result[] = [
                'id' => $resort->id,
                'name' => $resort->name
            ];
        }
        return $result;
    }

    public function actionCountries(){
        $result = [];
        $rid = Yii::$app->request->post('rid');

        $companyIDs = Yii::$app->request->post('company-ids');
        if(!is_null($companyIDs))
            $companyIDs = explode(',', $companyIDs);

        $showAnyValue = Yii::$app->request->post('show-any-value');
        if(!is_null($showAnyValue) && $showAnyValue=='1')
            $result = [['id' => '0', 'name' => 'Any Country']];

        if(is_null($rid) || !is_array($rid)) return $result;
        if(count($rid)==0) return $result;

        $countries = DictCountry::getCountriesByCompany($companyIDs, $rid);

        if(empty($countries)) return $result;

        foreach($countries as $country){
            $result[] = [
                'id' => $country->id,
                'name' => $country->name
            ];
        }
        return $result;
    }

    /**
     * fetch the country list
     */
    public function actionCountryList($q = null) {
        $data = GeoCountry::getCountriesByName($q, 10);
        $out = [];
        foreach ($data as $d) {
            $out[] = ['value' => $d['country_name']];
        }

        return $out;
    }

    /**
     * fetch the country list
     */
    public function actionCityList($q = null, $c = null) {
        $out = [];
        $data = GeoCity::getCitiesByName($q, $c, 5);
        foreach ($data as $d) {
            $out[] = ['value' => $d['accent_city']];
        }

        return $out;
    }

    /**
     * fetch the region list
     */
    public function actionRegionList($q = null, $c = null) {
        $out = [];
        $data = GeoRegion::getRegionsByName($q, $c, 5);
        foreach ($data as $d) {
            $out[] = ['value' => $d['name']];
        }

        return $out;
    }
}