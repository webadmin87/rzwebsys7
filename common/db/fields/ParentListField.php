<?php
namespace common\db\fields;

/**
 * Class ParentListField
 * Поле для привязки древовидных моделей к родителю
 * @package common\db\fields
 * @author Churkin Anton <webadmin87@gmail.com>
 */

class ParentListField extends ListField
{

    /**
     * @inheritdoc
     */
    public $isRequired = true;

    /**
     * @inheritdoc
     */
    public $showInGrid = false;

    /**
     * @inheritdoc
     */
    public $showInExtendedFilter = false;

    /**
     * @inheritdoc
     */
    public $search = false;

}