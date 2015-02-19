<?php

namespace common\db\fields;

use Yii;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/**
 * Class ManyManySortField
 * Поле для связи ManyMany с возможностью сортировки привязанных элементов
 * @package common\db\fields
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class ManyManySortField extends HasOneField
{

    use ManyManyTrait;

    /**
     * @var array настройки виджета
     */
    public $widgetOptions = [];

    /**
     * @inheritdoc
     */
    public function getForm(ActiveForm $form, Array $options = [], $index = false)
    {

        $data = $this->getDataValue();

        if (empty($data))
            return false;

        $options = ArrayHelper::merge(["class"=>"form-control"], $this->options, $options, ["multiple"=>true]);

        return  $form->field($this->model, $this->getFormAttrName($index))->widget(\common\widgets\SortedTags::className(),
            ArrayHelper::merge([
                "items" => $data,
                "options" => $options,
                "settings" => [
                    "tokenSeparators" => [',', ' '],
                ],
            ], $this->widgetOptions)
        );

    }

} 