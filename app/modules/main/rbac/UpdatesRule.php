<?php

namespace app\modules\main\rbac;

use yii\rbac\Rule;

/**
 * Class UpdatesRule
 * Проверка прав на изменение моделей
 * @package app\modules\main\rbac
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class UpdatesRule extends Rule
{

    public $name = 'canUpdates';

    /**
     * @inheritdoc
     */
    public function execute($user, $item, $params)
    {
        $perm = $params['model']->getPermission();

        return $perm AND $perm->updateModels();
    }

}