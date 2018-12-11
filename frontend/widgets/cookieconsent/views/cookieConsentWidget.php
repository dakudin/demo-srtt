<?php
/**
 * Created by Kudin Dmitry
 * Date: 11.12.2018
 * Time: 15:29
 *
 * @var string $container
 * @var string $dismiss
 * @var string $domain
 * @var string $expiryDays
 * @var string $learnMore
 * @var string $link
 * @var string $href
 * @var string $static
 * @var string $position
 * @var string $message
 * @var string $theme
 *
 * https://cookieconsent.insites.com/
 * https://cookieconsent.insites.com/documentation/javascript-api/
 */

use yii\helpers\Json;
use frontend\widgets\cookieconsent\AppAsset;

AppAsset::register($this);

$options = [
    "palette" => [
        "popup" => [
            "background" => "#edeff5",
            "text" => "#838391"
        ],
        "button" => [
            "background" => "#337ab7"
        ]
    ],
    "theme" => $theme,
    "position" => $position,
    "static" => $static,
    "cookie.domain" => $domain,
    "cookie.expiryDays" => $expiryDays,
    "content" => [
        "message" => $message,
        "href" => $href,
        "dismiss" => $dismiss,
        "link" => $link,
        'target' => $target,
    ]
];

$optionsJson = Json::encode($options);

if ($optionsJson) {
    $js = 'window.addEventListener("load", function(){ window.cookieconsent.initialise(' . $optionsJson . ')});';
    $this->registerJs($js, yii\web\View::POS_HEAD);
}