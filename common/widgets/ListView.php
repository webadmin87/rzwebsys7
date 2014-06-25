<?php
namespace common\widgets;

use yii\widgets\ListView As YiiList;

/**
 * Class ListView
 * Переопределяем рендер пагинации в стандартном ListView
 * @package common\widgets
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class ListView extends YiiList {

    /**
     * @inheritdoc
     */

    public function renderPager()
    {
        if($this->dataProvider->getPagination()->pageSize == 0)
            return '';

        return parent::renderPager();

    }


}