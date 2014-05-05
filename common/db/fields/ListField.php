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
     * @var array данные для заполнения списка (key=>value)
     */
    public $data = [];

    /**
     * Формирование Html кода поля для вывода в форме
     * @param ActiveForm $form объект форма
     * @param array $options массив html атрибутов поля
     * @return string
     */

    public function form(ActiveForm $form, Array $options = []) {

        return $form->field($this->model, $this->attr)->dropDownList($this->data, $options);

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

        return $this->data;

    }

}