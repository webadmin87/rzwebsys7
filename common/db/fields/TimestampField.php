<?php
namespace common\db\fields;

/**
 * Class TimestampField
 * Поле метки времени
 * @package common\db\fields
 * @author Churkin Anton <webadmin87@gmail.com>
 */

class TimestampField extends TextField
{

    /**
     * @inheritdoc
     */
    public $showInForm = false;

    /**
     * @inheritdoc
     */

    public $showInTableInput = false;

    /**
     * @inheritdoc
     */
    public $showInGrid = false;

    /**
     * @inheritdoc
     */
    public $showInExtendedFilter = true;

    /**
     * @inheritdoc
     */
    protected function grid()
    {

        $grid = parent::grid();

        $grid["attribute"] = $grid["attribute"];

        $grid["format"] = "datetime";

        return $grid;

    }

    /**
     * @inheritdoc
     */
    protected function view()
    {

        $view = parent::view();

        $view["format"] = "datetime";

        return $view;

    }

}