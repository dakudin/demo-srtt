<?php
/**
 * Created by Kudin Dmitry
 * Date: 21.01.2019
 * Time: 22:00
 */

namespace common\components;

use yii\web\UrlRuleInterface;
use yii\base\Object;
use common\models\EnquiryCategory;



class EnquiryCategoryUrlRule extends Object implements UrlRuleInterface
{
    /**
     * @param \yii\web\UrlManager $manager
     * @param string $route
     * @param array $params
     * @return bool|string
     */
    public function CreateUrl($manager, $route, $params)
    {
        if ($route === 'enquiry/index' && isset($params['category'])) {
            if(($enquiryCategory = EnquiryCategory::findOne(['alias' => $params['category'], 'is_visible' => 1])) == NULL){
                false;
            }

            // disable link for inactive categories
            if(!$enquiryCategory->is_active){
                return '#';
            }

            $route = '';
            $parentCategories = $enquiryCategory->parents()->all();
            foreach($parentCategories as $category){
                $route .= $category->alias . '/';
            }

            return 'enquiry/' . $route . $enquiryCategory->alias;
        }
        return false;
    }

    /**
     * @param \yii\web\UrlManager $manager
     * @param \yii\web\Request $request
     * @return bool
     */
    public function parseRequest($manager, $request)
    {
        $pathInfo = $request->getPathInfo();
        if (preg_match('%^enquiry(/(?P<category>\w+))+%', $pathInfo, $matches)) {
            if(!isset($matches['category'])){
                return false;
            }

            if(($enquiryCategory = EnquiryCategory::findOne(['alias' => $matches['category'], 'is_visible' => 1])) == NULL){
                return false;
            }

            return self::findRouteByUrl($enquiryCategory);
        }

        return false;
    }

    /**
     * @param EnquiryCategory $enquiryCategory
     * @return array|bool
     */
    protected function findRouteByUrl(EnquiryCategory $enquiryCategory)
    {
        //if exists children then show thumbnails of children categories
        if(($children = $enquiryCategory->children(1)->all()) != NULL) {
            return ['site/categories', ['categories' => $children, 'category'=> $enquiryCategory, 'is_top_level' => false]];
        }

        //otherwise create new enquiry by selected category
        if(($rootCategory = $enquiryCategory->parents(1)->one()) == NULL){
            return false;
        }
        return [$rootCategory->alias . '/' . $enquiryCategory->alias, ['category' => $enquiryCategory ]];
    }
}