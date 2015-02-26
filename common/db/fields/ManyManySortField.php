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
class ManyManySortField extends ManyManyField
{

   public $inputClass = "\\common\\inputs\\SortedTagsInput";

} 