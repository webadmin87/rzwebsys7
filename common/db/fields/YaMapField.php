<?php

namespace common\db\fields;

/**
 * Class YaMapField
 * Поле выбора координат на яндекс карте
 * @package common\db\fields
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class YaMapField extends TextField
{

    /**
     * @inheritdoc
     */

    public $inputClass = "\\common\\inputs\\YaMapInput";

}