<?php
/**
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace common\widgets\multiselect;

use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget;
use yii\base\InvalidConfigException;
use Yii;

/**
 * MultiSelect renders a [David Stutz Multiselect widget](http://davidstutz.github.io/bootstrap-multiselect/)
 *
 * @see http://davidstutz.github.io/bootstrap-multiselect/
 *
 *
 * Using a model:
 *
 *    echo MultiSelect::widget([
 *        'id' => 'select1',
 *        'options' => ['multiple'=>'multiple'], // for the actual multiselect
 *        'data' => [ 0 => 'option1', 1 => 'option2'], // data as array
 *        'value' => [ 0, 1], // if preselected
 *        'name' => 'select1', // name for the form
 *        "clientOptions" =>
 *            [
 *                'includeSelectAllOption' => true,
 *                'numberDisplayed' => 5
 *            ],
 *    ]);
 *    Note: You can make use of 'model' and 'attribute' for its configuration too instead of 'name' and 'value'.
 */
class MultiSelect extends InputWidget
{
    /**
     * @var array data for generating the list options (value=>display)
     */
    public $data = [];
    /**
     * @var array the options for the Bootstrap Multiselect JS plugin.
     * Please refer to the Bootstrap Multiselect plugin Web page for possible options.
     * @see http://davidstutz.github.io/bootstrap-multiselect/#options
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

        MultiSelectAsset::register($view);

        $id = $this->options['id'];

        $options = $this->clientOptions !== false && !empty($this->clientOptions)
            ? Json::encode($this->clientOptions)
            : '';

        $js = "jQuery('#$id').multiselect($options);";
        $view->registerJs($js);
    }
}
