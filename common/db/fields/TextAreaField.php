<?php
namespace common\db\fields;
use yii\widgets\ActiveForm;
/**
 * Class TextAreaField
 * Поле текстовой области модели
 * @package common\db\fields
 * @author Churkin Anton <webadmin87@gmail.com>
 */

class TextAreaField extends TextField {

    /**
     * @var bool отображать в гриде
     */
    public $showInGrid = false;

    /**
     * @var bool отображать в фильтре грида
     */
    public $showInFilter = false;

    /**
     * @var bool отображать в расширенном фильре
     */
    public $showInExtendedFilter = false;

    /**
     * @inheritdoc
     */

    public function form(ActiveForm $form, Array $options = [], $index = false) {

        return $form->field($this->model, $this->getFormAttrName($index))->textarea($options);

    }

    /**
     * @inheritdoc
     */
    public function view() {

        $view = parent::view();

        $view['format'] = 'html';

        return $view;

    }

}