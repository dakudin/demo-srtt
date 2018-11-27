<?php
/**
 * Created by Kudin Dmitry.
 * Date: 17.11.2017
 * Time: 12:00
 */

namespace common\widgets\sumoselect;

use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget;
use yii\base\InvalidConfigException;
use Yii;

/**
 * SumoSelect renders a [Hemant Negi widget](http://hemantnegi.github.io/jquery.sumoselect/)
 *
 * @see http://hemantnegi.github.io/jquery.sumoselect/
 *
 *
 * Using a model:
 *
 *    echo SumoSelect::widget([
 *        'id' => 'select1',
 *        'options' => ['multiple'=>'multiple'], // for the actual multiselect
 *        'data' => [ 0 => 'option1', 1 => 'option2'], // data as array
 *        'value' => [ 0, 1], // if preselected
 *        'name' => 'select1', // name for the form
 *        "clientOptions" =>
 *            [
 *                'placeholder' => 'This is a placeholder',
 *                'csvDispCount' => 3
 *            ],
 *    ]);
 *    Note: You can make use of 'model' and 'attribute' for its configuration too instead of 'name' and 'value'.
 */
class SumoSelect extends InputWidget
{
    /**
     * @var array data for generating the list options (value=>display)
     */
    public $data = [];
    /**
     * @var array the options for the Sumo Select JS plugin.
     * Please refer to the Sumo Select plugin Web page for possible options.
     * @see https://hemantnegi.github.io/jquery.sumoselect/#usage
     */
    public $clientOptions = [];

    /**
     * Initializes the widget.
     */
    public function init()
    {
        if (empty($this->data)) {
            throw new InvalidConfigException('"Multiselect::$data" attribute cannot be blank or an empty array.');
        }
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        if ($this->hasModel()) {
            echo Html::activeDropDownList($this->model, $this->attribute, $this->data, $this->options);
        } else {
            echo Html::dropDownList($this->name, $this->value, $this->data, $this->options);
        }
        $this->registerPlugin();
    }

    /**
     * Registers MultiSelect Bootstrap plugin and the related events
     */
    protected function registerPlugin()
    {
        $view = $this->getView();

        SumoSelectAsset::register($view);

        $id = $this->options['id'];

        $options = $this->clientOptions !== false && !empty($this->clientOptions)
            ? Json::encode($this->clientOptions)
            : '';

        $js = "jQuery('#$id').SumoSelect($options);";
        $view->registerJs($js);
    }
}
