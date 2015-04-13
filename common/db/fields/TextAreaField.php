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
    public $inputClass = "\\common\\inputs\\TextAreaInput";

    /**
     * @inheritdoc
     */
    public $formTemplate = '<div class="row"><div class="co-xs-12 col-lg-8">{input}</div></div>';

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