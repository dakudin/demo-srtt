<?php
/**
 * Created by Kudin Dmitry
 * Date: 02.11.2018
 * Time: 12:59
 */

use yii\helpers\Html;

?>

<h6 class="text-center">By clicking 'continue', you confirm that you accept our membership
    <a href="<?= \yii\helpers\Url::to(['/site/terms-of-use']) ?>" target="_blank">Terms and Conditions</a>,
    have read our <?php echo Html::a('Privacy policy', ['site/privacy-policy'], ['target' => '_blank']); ?>
    and agree to the use of cookies by us
</h6><hr />
