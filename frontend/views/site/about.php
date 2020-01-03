<?php

/* @var $this yii\web\View */
use yii\helpers\Url;

$this->title = 'About Us | Sortit';
$this->registerMetaTag(['name' => 'description', 'content' => 'Find out more about Sortit.com and our company here.'], 'description');
$this->registerMetaTag(['name' => 'keywords', 'content' => 'about Sortit'], 'keywords');
$this->registerLinkTag(['rel' => 'canonical', 'href' => Url::canonical()], 'canonical');

$this->params['breadcrumbs'][] = 'About us';
?>
<div class="site-about">
    <h1 class="title">About us</h1>

    <p>
        Tired of searching for hours to find what you want? Sortit.com can do all the hard work for you. We are
        a Quote Engine rather than a Search Engine. We send your requirements to trusted, reviewed, hand-picked
        providers who we believe will offer great deals and solutions for whatever you need. We pass on your details,
        usually to around between 3 and 5 providers who will contact you directly by phone or email.
    </p>

</div>
