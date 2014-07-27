<?php
namespace common\db\fields;
use Yii\widgets\ActiveForm;

/**
 * Class DateField
 * Поле ввода даты
 * @package common\db\fields
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class DateField extends TextField {


    /**
     * @inheritdoc
     */

    public function rules() {

        $rules = parent::rules();

        $rules[] = [$this->attr, 'date', 'format'=>'Y-m-d'];

        return $rules;

    }

    /**
     * @inheritdoc
     */

    public function form(ActiveForm $form, Array $options = [])
    {

        $options = array_merge(["class"=>"form-control"], $options);

        return $form->field($this->model, $this->attr)->widget(\yii\jui\DatePicker::className(), [
            "options"=>$options,
        ]);
    }


}