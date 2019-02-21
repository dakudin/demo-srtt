<?php
/**
 * Created Kudin Dmitry
 * Date: 19.02.2019
 * Time: 15:21
 */

namespace common\widgets\IosStyleSwitch;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class IosStyleSwitchAsset extends AssetBundle
{
    public $sourcePath = (__DIR__ . '/assets');

    public $css = ["css/jquery.mswitch.css"];
    public $js = ["js/jquery.mswitch.js"];

    public $jsOptions = [
        'position' => \yii\web\View::POS_END,
    ];

    public $depends = [
        'yii\bootstrap\BootstrapPluginAsset'
    ];

    public $publishOptions = [
        'forceCopy'=>true,
    ];

    public function init()
    {
        parent::init();
    }
}