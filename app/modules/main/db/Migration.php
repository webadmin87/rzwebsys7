<?php

namespace app\modules\main\db;

use yii\db\Migration AS Base;
use app\modules\main\models\User;

/**
 * Class Migration
 * Миграция. Добавлен функционал записи прав доступа на сущность по умолчанию для роли admin
 * @package common\db
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class Migration extends Base
{

    /**
     * @var string таблица прав доступа
     */
    public $permissionTable = "permission";

    /**
     * Добавление права доступа
     * @param string $modelClass класс модели
     * @param null|string $constraint класс ограничения реализующий интерфейс \common\rbac\IConstraint
     * @param string $role
     */
    public function insertPermission($modelClass, $constraint = null, $role = User::ROLE_ADMIN)
    {

        $this->insert($this->permissionTable,[

            "role"=>$role,
            "model"=>$modelClass,
            "constraint"=>$constraint,
            "read" => true,
            "create"=>true,
            "update"=>true,
            "delete"=>true,


        ]);

    }

    /**
     * Удаление права доступа
     * @param string $modelClass класс модели
     * @param string $role
     */
    public function deletePermission($modelClass, $role = User::ROLE_ADMIN) {

        $this->delete($this->permissionTable, [
            "role"=>$role,
            "model"=>$modelClass,
        ]);

    }

}