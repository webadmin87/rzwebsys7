<?php

namespace app\modules\main\db;

use app\modules\main\models\User;
use yii\db\Migration as Base;
use yii\helpers\ArrayHelper;

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
     * @var array правила по умолчанию
     */
    protected $_rules = [
        'read' => true,
        'create' => true,
        'update' => true,
        'delete' => true,
    ];

    /**
     * Добавление права доступа
     * @param string $modelClass класс модели
     * @param null|string $constraint класс ограничения реализующий интерфейс \common\rbac\IConstraint
     * @param string $role роль пользователя
     * @param null|array $only список разрешенных операции
     * @param null|array $except списсок запрещенных операций
     */
    public function insertPermission($modelClass, $constraint = null, $role = User::ROLE_ADMIN, $only = null, $except = null)
    {

        $this->insert($this->permissionTable, ArrayHelper::merge([
            "role" => $role,
            "model" => $modelClass,
            "constraint" => $constraint,
        ], $this->rules($only, $except)));

    }

    /**
     * Возвращает список правил
     * @param null|array $only список разрешенных операции
     * @param null|array $except списсок запрещенных операций
     * @return array
     */
    public function rules($only = null, $except=null)
    {

        $rules = $this->_rules;

        if ( !empty($only) and is_array($only) ) {
            foreach ($rules as $key => $value) {
                $rules[$key] = in_array($key, $only);
            }
        }
        elseif ( !empty($except) and is_array($except) ) {
            foreach ($rules as $key => $value) {
                $rules[$key] = !in_array($key, $except);
            }
        }

        return $rules;
    }

    /**
     * Удаление права доступа
     * @param string $modelClass класс модели
     * @param string $role
     */
    public function deletePermission($modelClass, $role = User::ROLE_ADMIN)
    {

        $this->delete($this->permissionTable, [
            "role" => $role,
            "model" => $modelClass,
        ]);

    }

}