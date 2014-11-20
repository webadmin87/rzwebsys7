<?php
namespace common\db\fields;

use common\db\ActiveRecord;

/**
 * Class HasOneField
 * Поле для связей Has One. Интерфейс привязки в форме в виде radio button.
 * @package common\db\fields
 * @author Chernyavsky Denis <panopticum87@gmail.com>
 */
class HasOneRadioField extends RadioListField
{
    use HasOneTrait;

    /**
     * Конструктор
     * @param ActiveRecord $model модель
     * @param string $attr атрибут
     * @param string $relation имя Has One связи
     */

    public function __construct(ActiveRecord $model, $attr, $relation, $config = [])
    {

        $this->relation = $relation;

        parent::__construct($model, $attr, $config);

    }

}