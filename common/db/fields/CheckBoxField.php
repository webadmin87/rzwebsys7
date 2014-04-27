<?php
namespace common\db\fields;

use Yii;

/**
 * Class CheckBoxField
 * Поле чекбокса для модели
 * @package common\db\fields
 * @author Churkin Anton <webadmin87@gmail.com>
 */

class CheckBoxField extends TextField {

    /**
     * Формирование Html кода поля для вывода в форме
     * @param ActiveForm $form объект форма
     * @param array $options массив html атрибутов поля
     * @return string
     */

    public function form(ActiveForm $form, Array $options = []) {

        return $form->field($this->$model, $this->attr)->checkbox($options);

    }

    /**
     * Конфигурация поля для грида (GridView)
     * @return array
     */
    public function grid() {

        $grid = parent::grid();

        $grid['value']=($this->model->{$this->attr})?Yii::t('core', 'Yes'):Yii::t('core', 'No');

        return $grid;

    }

    /**
     * Конфигурация полядля детального просмотра
     * @return array
     */
    public function view() {

        $view = parent::view();

        $view['value']=($this->model->{$this->attr})?Yii::t('core', 'Yes'):Yii::t('core', 'No');

        return $view;

    }

}