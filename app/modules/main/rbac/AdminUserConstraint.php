<?php
namespace app\modules\main\rbac;

use common\rbac\IConstraint;
use Yii;
use yii\base\Object;
use app\modules\main\models\User;

/**
 * Class AdminUserConstraint
 * Ограничение админской роли на доступ к пользователям
 * @package app\modules\realty\rbac
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class AdminUserConstraint extends Object implements IConstraint
{

    /**
     * Возвращает список ролей доступных для управления
     * @return array
     */
    public function getPermittedRoles()
    {
        return array_keys(User::getRolesNames());
    }

    /**
     * Устанавливает ограничение на критерий запроса
     * @param \common\db\ActiveQuery $query запрос
     * @return mixed
     */
    public function applyConstraint($query)
    {
        $cls = $query->modelClass;
        $table = $cls::tableName();
        $query->andWhere(["{{%$table}}.{{%role}}"=>$this->getPermittedRoles()]);
    }

    /**
     * Проверка возможности создания модели
     * @param \common\db\ActiveRecord $model
     * @return boolean
     */
    public function create($model)
    {
        return $this->testModel($model);
    }


    /**
     * Проверка возможности чтения модели
     * @param \common\db\ActiveRecord $model
     * @return boolean
     */
    public function read($model)
    {
        return $this->testModel($model);
    }

    /**
     * Проверяет модель на соответствие условию
     * @param \common\db\ActiveQuery $model
     * @return bool
     */

    public function testModel($model)
    {

        return in_array($model->role, $this->getPermittedRoles());

    }

    /**
     * Проверка возможности изменения модели
     * @param \common\db\ActiveRecord $model
     * @return boolean
     */
    public function update($model)
    {
        return $this->testModel($model);
    }

    /**
     * Проверка возможности удаления модели
     * @param \common\db\ActiveRecord $model
     * @return boolean
     */
    public function delete($model)
    {
        return $this->testModel($model);
    }

}