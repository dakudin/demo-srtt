<?php
/**
 * Created by Kudin Dmitry
 * Date: 11.12.2018
 * Time: 15:32
 */


namespace frontend\widgets\cookieconsent;


use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{
    public $sourcePath = '@frontend/widgets/cookieconsent/assets';
    public $baseUrl = '@web';
    public $css = ['css/cookieconsent.min.css'];
    public $js = ['js/cookieconsent.min.js'];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}