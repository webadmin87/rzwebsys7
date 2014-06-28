<?php

namespace common\db\fields;
use Yii;
use yii\widgets\ActiveForm;
use common\widgets\markitup\MarkItUp;

/**
 * Class MarkItUpField
 * Поле редактора MarkItUp
 * @package common\db\fields
 * @author Churkin Anton <webadmin87@gmail.com>
 */

class MarkItUpField extends TextAreaField {

    /**
     * @var array настройки редактора
     */

    public $editorOptions = [];


    public function form(ActiveForm $form, Array $options = []) {

        return $form->field($this->model, $this->attr)->widget(MarkItUp::className(),$this->editorOptions);

    }

    /**
     * @inheritdoc
     */
    public function view() {

        $view = parent::view();

        $view['value'] = Yii::$app->bbParser->parse($this->model->{$this->attr});

        return $view;

    }
}