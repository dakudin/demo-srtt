<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user string */
/* @var $email string */
/* @var $subject string */
/* @var $body string */
?>
<div>
    <p>Message from 'Contact Us' form.</p>
    <p></p>
    <p>User: <?= Html::encode($user) ?></p>
    <p>Email:  <a href="mailto:<?= Html::encode($email) ?>"><?= Html::encode($email) ?></a></p>
    <p>Message subject: <?= Html::encode($subject) ?></p>
    <p></p>

    <p>Message body:</p>
    <p></p>

    <p><?= Html::encode($body) ?></p>

</div>
