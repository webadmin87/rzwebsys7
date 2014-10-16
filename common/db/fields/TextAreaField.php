<?php
namespace common\db\fields;

use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/**
 * Class TextAreaField
 * Поле текстовой области модели
 * @package common\db\fields
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class TextAreaField extends TextField
{

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

    public function getForm(ActiveForm $form, Array $options = [], $index = false)
    {

		$options = ArrayHelper::merge($this->options, $options);

        return $form->field($this->model, $this->getFormAttrName($index))->textarea($options);

    }

    /**
     * @inheritdoc
     */
    protected function view()
    {

        $view = parent::view();

        $view['format'] = 'html';

        return $view;

    }

}