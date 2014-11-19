<?php
namespace common\db\fields;

use yii\helpers\ArrayHelper;
use Yii\widgets\ActiveForm;
use \common\widgets\AutoComplete;

/**
 * Class AutoCompleteField
 * Поле с автозаполнением.
 * @package common\db\fields
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class AutoCompleteField extends Field
{
    /**
     * @var array параметры виджета \common\widgets\AutoComplete
     */
    public $widgetOptions = [];

    /**
     * @inheritdoc
     */
    public function getForm(ActiveForm $form, Array $options = [], $index = false)
    {

        $options = ArrayHelper::merge($this->options, $options);

        $widgetOptions = ArrayHelper::merge(["visibleOptions"=>["class"=>"form-control"]], $this->widgetOptions, ["options"=>$options]);

        return $form->field($this->model, $this->attr)->widget(AutoComplete::className(), $widgetOptions);

    }


}