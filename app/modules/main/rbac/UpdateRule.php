<?php

namespace app\modules\main\rbac;

use yii\rbac\Rule;

/**
 * Class UpdateRule
 * Проверка прав на изменение модели
 * @package app\modules\main\rbac
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class UpdateRule extends Rule
{

    public $name = 'canUpdate';

    /**
     * @inheritdoc
     */
    public function execute(/*$user, */$item, $params)
    {
        $perm = $params['model']->getPermission();

        return $perm AND $perm->updateModel($params['model']);
    }

}