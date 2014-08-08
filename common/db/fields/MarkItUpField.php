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
     * @var array настройки редактора
     */

    public $editorOptions = [];

    /**
     * @inheritdoc
     */

    public function form(ActiveForm $form, Array $options = [], $index = false)
    {

		$options = ArrayHelper::merge($this->options, $options);

		if(empty($this->editorOptions["options"]))
			$this->editorOptions["options"] = [];

		$editorOptions = ArrayHelper::merge($options, $this->editorOptions);

        return $form->field($this->model, $this->getFormAttrName($index))->widget(MarkItUp::className(), $editorOptions);

    }

    /**
     * @inheritdoc
     */
    public function view()
    {

        $view = parent::view();

        $view['value'] = Yii::$app->bbParser->parse($this->model->{$this->attr});

        return $view;

    }
}