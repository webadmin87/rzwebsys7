<?php
namespace common\db\fields;

use common\db\ActiveRecord;

/**
 * Class HasOneField
 * Поле для связей Has One. Интерфейс привязки в форме в виде выпадающего списка.
 * @package common\db\fields
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class HasOneField extends ListField
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