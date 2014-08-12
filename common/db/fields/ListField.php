<?php
namespace common\db\fields;

use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/**
 * Class ListField
 * Списочное поле модели. Поддерживает возможность создания зависимых списков.
 * @package common\db\fields
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class ListField extends Field
{

    /**
     * @var callable функция возвращающая данные для заполнения списка
     */
    public $data;

	/**
	 * @var bool значения выпадающего списка - числовые
	 */
	public $numeric = false;

	/**
	 * @var array настройки виджета \common\widgets\DependDropDown
	 */
	public $widgetOptions = [];

    /**
     * @var array данные для заполнения списка (key=>value)
     */
    protected $dataValue;

    /**
     * @inheritdoc
     */

    public function form(ActiveForm $form, Array $options = [], $index = false)
    {

		$options = ArrayHelper::merge(["class" => "form-control", "prompt"=>""], $this->options, $options);

		$widgetOptions = ArrayHelper::merge(["data"=>$this->getDataValue(), "options"=>$options], $this->widgetOptions);

		return $form->field($this->model, $this->getFormAttrName($index))->widget(\common\widgets\DependDropDown::className(), $widgetOptions);

    }

    /**
     * Возвращает массив данных для заполнения списка
     * @return array
     */

    public function getDataValue()
    {

        if ($this->dataValue === null) {

            $func = $this->data;

            $this->dataValue = is_callable($func) ? call_user_func($func) : [];

        }

        return $this->dataValue;
    }

    /**
     * @inheritdoc
     */

    public function xEditable()
    {

        return [

            'class' => \mcms\xeditable\XEditableColumn::className(),
            'url' => $this->getEditableUrl(),
            'dataType' => 'select',
            'format' => 'raw',
            'editable' => ['source' => $this->defaultGridFilter()],
        ];

    }

    /**
     * @inheritdoc
     */

    protected function defaultGridFilter()
    {

        return $this->getDataValue();

    }

	/**
	 * @inheritdoc
	 */

	public function rules()
	{
		$rules = parent::rules();

		if($this->numeric) {

			$rules[] = [$this->attr, 'default', 'value'=>0];

		}

		return $rules;

	}


}