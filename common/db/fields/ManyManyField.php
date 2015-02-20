<?php
namespace common\db\fields;

use common\db\ActiveQuery;
use common\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/**
 * Class ManyManyField
 * Поле для связей Many Many
 * @package common\db\fields
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class ManyManyField extends HasOneField
{

    use ManyManyTrait;

    /**
     * @inheritdoc
     */
    public function getForm(ActiveForm $form, Array $options = [], $index = false)
    {

        $data = $this->getDataValue();

        if (empty($data))
            return false;

		$options = ArrayHelper::merge($this->options, $options, ["multiple"=>true]);

        return $form->field($this->model, $this->getFormAttrName($index))->widget(\dosamigos\multiselect\MultiSelect::className(),
            [
                "data" => $data,
                "options" => $options,
            ]
        );

    }


}