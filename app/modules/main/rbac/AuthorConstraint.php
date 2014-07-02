<?php
namespace app\modules\main\rbac;

use Yii;
use yii\base\Object;
use common\rbac\IConstraint;

/**
 * Class AuthorConstraint
 * Ограничение по автору модели
 * @package app\modules\main\rbac
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class AuthorConstraint extends Object implements IConstraint {

    /**
     * Проверяет моднль на соответствие условию
     * @param \common\db\ActiveQuery $model
     * @return bool
     */

    public function testModel($model) {

        $userId = Yii::$app->user->id;

        return $model->author_id == $userId;

    }


    /**
     * Устанавливает ограничение на критерий запроса
     * @param \common\db\ActiveQuery $query запрос
     * @return mixed
     */
    public function applyConstraint($query)
    {
        $userId = Yii::$app->user->id;

        $query->andWhere(['author_id'=>$userId]);
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