<?php

namespace app\modules\main\rbac;

use yii\rbac\Rule;

/**
 * Class ReadRule
 * Проверка прав на просмотр модели
 * @package app\modules\main\rbac
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class ReadRule extends Rule
{

    public $name = 'canRead';

    /**
     * @inheritdoc
     */
    public function execute(/*$user, */$item, $params)
    {
        $perm = $params['model']->getPermission();

        return $perm AND $perm->readModel($params['model']);
    }

}