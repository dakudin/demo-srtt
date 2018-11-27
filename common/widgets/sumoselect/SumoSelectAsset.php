<?php
/**
 * Created by Kudin Dmitry.
 * Date: 17.11.2017
 * Time: 11:58
 */

namespace common\widgets\sumoselect;

use yii\web\AssetBundle;

class SumoSelectAsset extends AssetBundle
{
    public $sourcePath = '@common/widgets/sumoselect/assets';

    public $js = [
        'js/jquery.sumoselect.min.js'
    ];

    public $css = [
        'css/sumoselect.css'
    ];

    public $depends = [
        'yii\bootstrap\BootstrapPluginAsset'
    ];
}