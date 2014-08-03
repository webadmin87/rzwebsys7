<?php
namespace app\modules\main\rbac;

use common\rbac\IConstraint;
use Yii;
use yii\base\Object;

/**
 * Class ProfileConstraint
 * Ограничение на редактирование свонго профиля
 * @package app\modules\main\rbac
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class ProfileConstraint extends Object implements IConstraint
{

    /**
     * Устанавливает ограничение на критерий запроса
     * @param \common\db\ActiveQuery $query запрос
     * @return mixed
     */
    public function applyConstraint($query)
    {
        $userId = Yii::$app->user->id;

        $query->andWhere(['id' => $userId]);
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
     * Проверяет моднль на соответствие условию
     * @param \common\db\ActiveQuery $model
     * @return bool
     */

    public function testModel($model)
    {

        $userId = Yii::$app->user->id;

        return $model->id == $userId;

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