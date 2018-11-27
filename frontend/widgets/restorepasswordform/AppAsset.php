<?php
/**
 * Created by Kudin Dmitry
 * Date: 05.11.2018
 * Time: 19:05
 */

namespace frontend\widgets\restorepasswordform;


use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{
    public $sourcePath = '@frontend/widgets/restorepasswordform/assets';
    public $baseUrl = '@web';
    public $js = ['js/restorepassword.js'];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}