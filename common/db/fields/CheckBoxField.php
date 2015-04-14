<?php
namespace common\db\fields;

use common\db\ActiveRecord;
use Yii;
use Yii\widgets\ActiveForm;

/**
 * Class CheckBoxField
 * Поле чекбокса для модели
 * @package common\db\fields
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class CheckBoxField extends Field
{

    /**
     * @inheritdoc
     */
    public $inputClass = "\\common\\inputs\\CheckBoxInput";

    /**
     * Конфигурация поля для грида (GridView)
     * @return array
     */
    protected function grid()
    {

        $grid = parent::grid();

        $grid['value'] = function ($model, $index, $widget) {
            return $model->{$this->attr} ? Yii::t('core', 'Yes') : Yii::t('core', 'No');
        };

        return $grid;

    }

    /**
     * Конфигурация полядля детального просмотра
     * @return array
     */
    protected function view()
    {

        $view = parent::view();

        $view['value'] = ($this->model->{$this->attr}) ? Yii::t('core', 'Yes') : Yii::t('core', 'No');

        return $view;

    }

    /**
     * @inheritdoc
     */

    public function extendedFilterForm(ActiveForm $form, Array $options = [])
    {

        $data = $this->defaultGridFilter();

        if (!isset($options['prompt']))
            $options['prompt'] = '';

        return $form->field($this->model, $this->attr)->dropDownList($data, $options);

    }

    /**
     * @inheritdoc
     */

    protected function defaultGridFilter()
    {

        return [

            1 => Yii::t('core', 'Yes'),
            0 => Yii::t('core', 'No'),

        ];

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

    public function rules()
    {

        $rules = parent::rules();

        $rules[] = [$this->attr, 'default', 'value' => 0, 'except' => ActiveRecord::SCENARIO_SEARCH];

        return $rules;

    }

}