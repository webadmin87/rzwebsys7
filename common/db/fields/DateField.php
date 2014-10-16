<?php
namespace common\db\fields;

use Yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/**
 * Class DateField
 * Поле ввода даты
 * @package common\db\fields
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class DateField extends TextField
{

    /**
     * @inheritdoc
     */

    public function rules()
    {

        $rules = parent::rules();

        $rules[] = [$this->attr, 'date', 'format' => 'yyyy-MM-dd'];

        return $rules;

    }

    /**
     * @inheritdoc
     */

    public function getForm(ActiveForm $form, Array $options = [], $index = false)
    {

        $options = ArrayHelper::merge(["class" => "form-control"], $this->options, $options);

        return $form->field($this->model, $this->getFormAttrName($index))->widget(\yii\jui\DatePicker::className(), [
            "options" => $options,
        ]);
    }

}