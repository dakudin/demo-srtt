<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'New enquiry';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h2>Your enquiry was sent successfully!</h2>

    <div class="row">
        <div class="alert alert-info">
            <?php echo $quoteInfo;?>
        </div>
    </div>
</div>
