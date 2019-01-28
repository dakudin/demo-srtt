<?php
/* @var $this yii\web\View */
/* @var $category common\models\EnquiryCategory|null */
/* @var $categories array of common\models\EnquiryCategory */
/* @var $showBreadcrumbs boolean */

    use common\models\EnquiryCategory;

    $this->title = 'The Quote Engine';

    if($showBreadcrumbs && ($category instanceof EnquiryCategory)){
        $this->params['breadcrumbs'] = \frontend\helpers\FHelper::getEnquiryCategoryBreadcrumbs($category, false);
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
                            <img src="/images/category/icon.png">
                        </div>
                    </div>
            <?php
                    $index++;
                endif;
            ?>

                <div class="category-thumb col-xs-4 col-md-4">
                    <a href="<?= \yii\helpers\Url::to(['enquiry/index', 'category' => $category->alias]) ?>" class="thumbnail" style="height: 100%; width: 100%; display: block;">
                        <img src="<?= $category->getImageUrl(); ?>">
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

