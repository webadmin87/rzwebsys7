<?php

namespace app\modules\main\rbac;

use yii\rbac\Rule;

/**
 * Class ListRule
 * Проверка прав на просмотр списка моделей
 * @package app\modules\main\rbac
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class ListRule extends Rule
{

    public $name = 'canList';

    /**
     * @inheritdoc
     */
    public function execute($user, $item, $params)
    {
        $perm = $params['model']->getPermission();

        return $perm AND $perm->listModels();
    }

}