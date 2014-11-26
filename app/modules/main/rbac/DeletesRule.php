<?php

namespace app\modules\main\rbac;

use yii\rbac\Rule;

/**
 * Class DeletesRule
 * Проверка прав на удаление моделей
 * @package app\modules\main\rbac
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class DeletesRule extends Rule
{

    public $name = 'canDeletes';

    /**
     * @inheritdoc
     */
    public function execute($user, $item, $params)
    {
        $perm = $params['model']->getPermission();

        return $perm AND $perm->deleteModels();
    }

}