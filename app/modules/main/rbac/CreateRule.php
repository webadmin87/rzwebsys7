<?php

namespace app\modules\main\rbac;

use yii\rbac\Rule;

/**
 * Class CreateRule
 * Проверка прав на создание модели
 * @package app\modules\main\rbac
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class CreateRule extends Rule {

    public $name = 'canCreate';

    /**
     * @inheritdoc
     */
    public function execute($user, $item, $params)
    {
        $perm = $params['model']->getPermission();

        return $perm AND $perm->createModel();
    }


}