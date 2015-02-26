<?php
namespace common\db\fields;

use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\db\ActiveRecord;

/**
 * Class ListField
 * Списочное поле модели. Поддерживает возможность создания зависимых списков.
 * @package common\db\fields
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class ListField extends Field
{

	/**
	 * @var bool значения выпадающего списка - числовые
	 */
	public $numeric = false;

    /**
     * @inheritdoc
     */
    public $inputClass = "\\common\\inputs\\DropDownInput";

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

		if($this->numeric AND $this->defaultValue === null) {

			$rules[] = [$this->attr, 'default', 'value'=>0, 'except'=>[ActiveRecord::SCENARIO_SEARCH]];

		}

		return $rules;

	}

	/**
	 * @inheritdoc
	 */
	protected function grid()
	{

		$grid = $this->defaultGrid();

		$grid["value"] = function ($model, $index, $widget) {

			$value = $model->{$this->attr};

			if(is_string($value) OR is_int($value))
				return ArrayHelper::getValue($this->getDataValue(), $value, $value);
			else
				return $value;

		};

		return $grid;

	}

	/**
	 * @inheritdoc
	 */
	protected function view()
	{

		$view = $this->defaultView();

		$value = $this->model->{$this->attr};

		if(is_string($value) OR is_int($value))
			$view["value"] = ArrayHelper::getValue($this->getDataValue(), $value, $value);

		return $view;

	}


}