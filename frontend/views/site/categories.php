<?php
/* @var $this yii\web\View */
/* @var $isHomePage boolean */
/* @var $category common\models\EnquiryCategory|null */
/* @var $categories array of common\models\EnquiryCategory */
/* @var $showBreadcrumbs boolean */

use common\models\EnquiryCategory;
use yii\helpers\Url;
use yii\helpers\Html;

    if($isHomePage){
        $this->title = 'Ski holidays | Beach holidays | Sortit';
        $this->registerMetaTag(['name' => 'description', 'content' => 'Tired of searching ski or beach holidays? Select several trusted providers and we send your requirements to them. Just try'], 'description');
        $this->registerMetaTag(['name' => 'keywords', 'content' => 'quote engine, search engine'], 'keywords');
        $this->registerLinkTag(['rel' => 'canonical', 'href' => Url::canonical()], 'canonical');
    }elseif($category instanceof EnquiryCategory){
        $this->title = $category->seo_title;
        $this->registerMetaTag(['name' => 'description', 'content' => $category->seo_description], 'description');
        $this->registerMetaTag(['name' => 'keywords', 'content' => $category->seo_keyword], 'keywords');
    }

    if($showBreadcrumbs && ($category instanceof EnquiryCategory)){
        $canonical_url = Yii::$app->request->hostInfo . '/' . Yii::$app->request->pathInfo;
        $this->params['breadcrumbs'] = \frontend\helpers\FHelper::getEnquiryCategoryBreadcrumbs($category, false);
        $this->registerLinkTag(['rel' => 'canonical', 'href' => $canonical_url], 'canonical');

        Yii::$app->params['og_url']['content'] = $canonical_url;
        Yii::$app->params['og_title']['content'] = $category->og_title;
        Yii::$app->params['og_description']['content'] = $category->og_description;
        Yii::$app->params['og_image']['content'] = Yii::$app->request->hostInfo . $category->og_image;
//        $this->registerMetaTag(Yii::$app->params['og_url'], 'og_url');
    }

?>
<div class="site-index">
    <div class="body-content">

        <?php
            $index=1;
            foreach($categories as $category):
        ?>

            <?php
                if($index == 1 || (($index-1) % 3) == 0){
                    echo '<div class="row menu-buttons">';
                }
            ?>

            <?php
                // show central icon
                if($index == 5):
            ?>
                    <div class="category-thumb-center col-xs-4 col-md-4">
                        <div class="thumbnail" style="height: 100%; width: 100%; display: block;">
                            <img src="/images/category/the-quote-engine.png">
                        </div>
                    </div>
            <?php
                    $index++;
                endif;
            ?>

                <div class="category-thumb col-xs-4 col-md-4">
                    <a href="<?= \yii\helpers\Url::to(['enquiry/index', 'category' => $category->alias]) ?>" class="thumbnail" style="height: 100%; width: 100%; display: block;">
                        <img src="<?= $category->getImageUrl(); ?>" alt="<?= Html::encode($category->name); ?>">
                    </a>
                </div>

            <?php
                if(($index % 3) == 0){
                    echo '</div>';
                }
            ?>

        <?php
                $index++;
            endforeach;
        ?>

    </div>
</div>

