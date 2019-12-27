<?php
/**
 * Created by Kudin Dmitry
 * Date: 02.08.2018
 * Time: 13:49
 */

namespace frontend\helpers;

use Yii;
use common\models\EnquiryCategory;
use yii\helpers\Url;

class FHelper
{
    /**
     * Set quote agreement in cookies
     */
    public static function setRequestQuoteAgreementCookies()
    {
        if (!isset(Yii::$app->request->cookies['quote_agreement'])) {
            Yii::$app->response->cookies->add(new \yii\web\Cookie([
                'name' => 'quote_agreement',
                'value' => null,
                'expire' => time() + 60 * 60 * 24 * 30 * 12 * 5,
                'path' => '/'
            ]));
        }
    }

    /**
     * Prepare the breadcrumbs for categories
     * @param EnquiryCategory $category
     * @param bool|true $showSuffix
     * @return array
     */
    public static function getEnquiryCategoryBreadcrumbs(EnquiryCategory $category, $showSuffix = true)
    {
        $result = [];

        $parentCategories = $category->parents()->all();
        foreach($parentCategories as $item){
            $result[] =
                [
                    'label' => $item->name,
                    'url' => ['enquiry/index', 'category' => $item->alias]
                ];
        }

        if($showSuffix) {
            $result[] = $category->name . ' Quote';
        }else{
            $result[] = $category->name;
        }

        return $result;
    }

    public static function getMostPopularCategoryLinks($limit = 5)
    {
        $result = [];

        $categories = EnquiryCategory::findMostPopular($limit);
        foreach($categories as $item){
            $result[] =
                [
                    'label' => $item->name,
                    'url' => Url::to(['enquiry/index', 'category' => $item->alias])
                ];
        }

        return $result;
    }
}