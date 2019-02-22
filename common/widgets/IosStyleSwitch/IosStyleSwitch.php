<?php
/**
 * Created by PhpStorm.
 * User: Monk
 * Date: 19.02.2019
 * Time: 15:21
 */

namespace common\widgets\IosStyleSwitch;

use Yii;
use yii\base\InvalidConfigException;
use yii\base\InvalidParamException;
use yii\helpers\Html;
use yii\widgets\InputWidget;

/**
 * Widget for iOS type switcher
 */

class IosStyleSwitch extends InputWidget
{
    const CHECKBOX = "checkbox";
//    const RADIO = "radio";

    /*
     * Type of control - Checkbox or Radio button
     */
    public $type;


    /*
     * Class for input
     */
    public $class = 'm_switch_check';

    /*
     * Control is on
     */
    public $turnOnValue = 1;


    /*
     * Control is off
     */
    public $turnOffValue = 0;

    /*
     * Variants of switcher types
     */
    public $typesList = [
        self::CHECKBOX,
//        self::RADIO
    ];

    /*
     * Function with handle on changing to On
     */
    public $onTurnOn = '';

    /*
     * Function with handle on changing to Off
     */
    public $onTurnOff = '';

    public function init()
    {
        parent::init();

        if ($this->type == null) {
            $this->type = self::CHECKBOX;

        }

        if (empty($this->type) || !in_array($this->type, $this->typesList)) {
            throw new InvalidConfigException("Type not set. Type must be either checkbox or radio.");
        }
    }

    public function run()
    {
        parent::run();

        if($this->type === self::CHECKBOX){
            //build the input control
            $input = $this->getCheckbox($this->type);
        }

        //convert input into iOS switcher
        $this->registerAssets();

        // show switcher
        echo $input;
    }

    /**
     * @param $type
     * @return mixed
     * @throws InvalidParamException
     */
    protected function getCheckbox($type)
    {

        if (empty($this->options['label'])) {
            $this->options['label'] = null;
        }

        $options = \yii\helpers\ArrayHelper::merge(
            $this->options, ['class' => $this->class]
        );

        if ($this->hasModel()) {
            $input = 'active' . ucfirst($type);
            return Html::$input($this->model, $this->attribute, $options);

        } else {
            if ($type == self::CHECKBOX) {
                $input = $type;
                $checked = $this->value==1;
                return Html::$input($this->name, $checked, $options);
            }else{
                throw new InvalidParamException("Field type not supported");
            }
        }
    }

    /**
     * Register assets.
     */
    protected function registerAssets()
    {
        /*
         * Register styles and plugin scripts
         */
        $view = $this->getView();
        IosStyleSwitchAsset::register($view);

        /*
         * Register the script witch replace control view.
         * Change the value of input control
         */
        $js = <<<JS

        $(".{$this->class}").mSwitch({
            onRendered: function(){},
            onRender: function(elem){},
            onTurnOn: function(elem){
//              console.log(elem);
                elem.val({$this->turnOnValue});
                {$this->onTurnOn}
            },
            onTurnOff: function(elem){
                elem.val({$this->turnOffValue});
                {$this->onTurnOff}
            }
        });
JS;

        $view->registerJs($js, \yii\web\View::POS_READY);
    }
}