<?php
namespace common\db\fields;
use Yii\widgets\ActiveForm;
/**
 * Class ListField
 * Списочное поле модели
 * @package common\db\fields
 * @author Churkin Anton <webadmin87@gmail.com>
 */

class ListField extends TextField {

    /**
     * @var closure анонимная функция возвращающая данны для заполнения списка
     */

    public $data;

    /**
     * @var array данные для заполнения списка (key=>value)
     */
    protected $dataValue;

    /**
     * Формирование Html кода поля для вывода в форме
     * @param ActiveForm $form объект форма
     * @param array $options массив html атрибутов поля
     * @return string
     */

    public function form(ActiveForm $form, Array $options = []) {

        if(!isset($options['prompt']))
            $options['prompt'] = '';

        return $form->field($this->model, $this->attr)->dropDownList($this->getDataValue(), $options);

    }

    /**
     * @inheritdoc
     */

    public function extendedFilterForm(ActiveForm $form , Array $options = []) {

        if(!isset($options['prompt']))
            $options['prompt'] = '';

        return parent::extendedFilterForm($form, $options);

    }

    /**
     * @inheritdoc
     */

    protected function defaultGridFilter() {

        return $this->getDataValue();

    }

    /**
     * Возвращает массив данных для заполнения списка
     * @return array
     */

    public function getDataValue() {

        if($this->dataValue === null) {

            $func = $this->data;

            $this->dataValue = is_callable($func)?$func():[];

        }

        return $this->dataValue;
    }

    /**
     * @inheritdoc
     */

    public function xEditable() {

        return [

            'class' => \mcms\xeditable\XEditableColumn::className(),
            'url' => $this->getEditableUrl(),
            'dataType' => 'select',
            'format' => 'raw',
            'editable' => [ 'source' => $this->defaultGridFilter() ],
        ];

    }

}