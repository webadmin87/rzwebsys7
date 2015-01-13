<?php
namespace common\db;

use creocoder\nestedsets\NestedSetsQueryBehavior;

/**
 * Class TActiveQuery
 * Системный ActiveQuery. Предоставляет системные scopes. Содержит поведения для реализации древовидных структур
 * @package common\db
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class TActiveQuery extends ActiveQuery
{

    /**
     * @inheritdoc
     */

    public function behaviors()
    {
        return [
            [
                'class' => NestedSetsQueryBehavior::className(),
            ],
        ];
    }

}
