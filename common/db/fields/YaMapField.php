<?php

namespace common\db\fields;

use common\widgets\yamap\YaMapInput;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/**
 * Class YaMapField
 * Поле выбора координат на яндекс карте
 * @package common\db\fields
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class YaMapField extends TextField
{

    /**
     * @var array настройки виджета
     */

    public $widgetOptions = [];


    /**
     * @inheritdoc
     */

    public function form(ActiveForm $form, Array $options = [], $index = false)
    {

		$options = array_merge(["class" => "form-control"], $options);

		$widgetOptions = $this->widgetOptions;

		if(empty($widgetOptions["options"]))
			$widgetOptions["options"] = [];

		$widgetOptions["options"] = ArrayHelper::merge($widgetOptions["options"], $options);

        return $form->field($this->model, $this->getFormAttrName($index))->widget(YaMapInput::className(), $widgetOptions);

    }

}