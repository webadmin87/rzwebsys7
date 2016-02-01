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
    public $isRequired = false;

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

    /**
     * @var string атрибут родительской модели отображаемый при детальном просмотре
     */
    public $viewAttr = "title";

    /**
     * @inheritdoc
     */
    protected function view()
    {
        $parent = parent::view();

        $parentModel = $this->model->parents(1)->one();

        if($parentModel)
            $parent['value']=$parentModel->{$this->viewAttr};

        return $parent;
    }


}