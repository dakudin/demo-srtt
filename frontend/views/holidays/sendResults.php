<?php

/* @var $this yii\web\View */

$this->title = 'New enquiry';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h3>Your enquiry was sent successfully to <?= $quotesCreated; ?> selected retailers!</h3>

    <div class="row">
        <div class="alert alert-info">
            <?php echo $quoteInfo;?>
        </div>
    </div>
</div>
