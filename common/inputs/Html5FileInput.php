<?php

namespace common\inputs;

use common\widgets\html5uploader\Widget as Html5Widget;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/**
 * Class Html5FileInput
 * Поле загрузки файлов HTML5
 * @package common\inputs
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class Html5FileInput extends BaseInput {

    /**
     * @var string маршрут для загрузки файлов используемый по умолчанию
     */
    public $defaultRoute = "/main/admin/upload";

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if(!$this->modelField->model->hasProperty("maxFileSize"))
            throw new InvalidConfigException("Model must have 'maxFileSize' property");

    }

    /**
     * Формирование Html кода поля для вывода в форме
     * @param ActiveForm $form объект форма
     * @param array $options массив html атрибутов поля
     * @param bool|int $index инднкс модели при табличном вводе
     * @return string
     */
    public function renderInput(ActiveForm $form, Array $options = [], $index = false)
    {
        $options = ArrayHelper::merge($this->options, $options);

        $attr = $this->modelField->attr;

        $defaults = [
            "maxFileSize" => $this->modelField->model->maxFileSize,
            "uploadRoute" => $this->defaultRoute,
        ];

        $widgetOptions = ArrayHelper::merge($defaults, $this->widgetOptions, ["options"=>$options]);

        $attr = $this->getFormAttrName($index, $attr);

        return $form->field($this->modelField->model, $attr)->widget(Html5Widget::className(), $widgetOptions);
    }


} 