<?php
namespace common\db\fields;

use yii\widgets\ActiveForm;

/**
 * Class ListField
 * Списочное поле модели
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
     * @var array данные для заполнения списка (key=>value)
     */
    protected $dataValue;

    /**
     * @inheritdoc
     */

    public function form(ActiveForm $form, Array $options = [], $index = false)
    {

        if (!isset($options['prompt']))
            $options['prompt'] = '';

        return $form->field($this->model, $this->getFormAttrName($index))->dropDownList($this->getDataValue(), $options);

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

    public function extendedFilterForm(ActiveForm $form, Array $options = [])
    {

        if (!isset($options['prompt']))
            $options['prompt'] = '';

        return parent::extendedFilterForm($form, $options);

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

}