<?php

namespace common\db\fields;

use yii\helpers\ArrayHelper;
use common\widgets\markitup\MarkItUp;
use Yii;
use yii\widgets\ActiveForm;

/**
 * Class MarkItUpField
 * Поле редактора MarkItUp
 * @package common\db\fields
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class MarkItUpField extends TextAreaField
{

    /**
     * @inheritdoc
     */
    public $inputClass = "\\common\\inputs\\MarkItUpInput";

    /**
     * @inheritdoc
     */
    protected function view()
    {

        $view = parent::view();

        $view['value'] = Yii::$app->bbParser->parse($this->model->{$this->attr});

        return $view;

    }
}