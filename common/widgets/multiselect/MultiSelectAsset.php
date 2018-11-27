<?php
/**
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace common\widgets\multiselect;

use yii\web\AssetBundle;

class MultiSelectAsset extends AssetBundle
{
    public $sourcePath = '@common/widgets/multiselect/assets';

    public $js = [
        'js/bootstrap-multiselect.js'
    ];

    public $css = [
        'css/bootstrap-multiselect.css'
    ];

    public $depends = [
        'yii\bootstrap\BootstrapPluginAsset'
    ];
}