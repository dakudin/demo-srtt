<?php
/**
 * Created by Kudin Dmitry
 * Date: 09.10.2018
 * Time: 19:05
 */

namespace frontend\widgets\profileform;


use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{
    public $sourcePath = '@frontend/widgets/profileform/assets';
    public $baseUrl = '@web';
//    public $css = ['css/style.css'];
    public $js = ['js/profile.js'];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}