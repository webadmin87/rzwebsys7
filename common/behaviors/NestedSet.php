<?php
namespace common\behaviors;

/**
 * Class NestedSet
 * Исправляет баги в оригинальном NestedSet
 * @package common\behaviors
 * @author Churkin Anton <webadmin87@gmail.com>
 */

class NestedSet extends \creocoder\nestedsets\NestedSetsBehavior
{

    /**
     * @inheritdoc
     */

    public function afterFind($event)
    {
    }

}