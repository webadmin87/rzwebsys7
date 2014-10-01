<?php

namespace app\modules\main\rbac;

use yii\rbac\Rule;

/**
 * Class CreatesRule
 * Проверка прав на создание моделей
 * @package app\modules\main\rbac
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class CreatesRule extends Rule
{

    public $name = 'canCreates';

    /**
     * @inheritdoc
     */
    public function execute($user, $item, $params)
    {
        $perm = $params['model']->getPermission();

        return $perm AND $perm->createModels($params['model']);
    }

}