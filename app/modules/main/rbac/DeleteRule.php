<?php

namespace app\modules\main\rbac;

use yii\rbac\Rule;

/**
 * Class DeleteRule
 * Проверка прав на удаление модели
 * @package app\modules\main\rbac
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class DeleteRule extends Rule {

    public $name = 'canDelete';

    /**
     * @inheritdoc
     */
    public function execute($user, $item, $params)
    {
        return true;
    }


}