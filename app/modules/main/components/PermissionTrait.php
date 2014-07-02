<?php
namespace app\modules\main\components;
use \app\modules\main\models\Permission;
/**
 * Class PermissionTrait
 * Предоставляет функциональность по проверке прав доступа
 * @package app\modules\main\components
 * @author Churkin Anton <webadmin87@gmail.com>
 */

trait PermissionTrait {

    /**
     * Возвращает модель правил доступа
     * @return Permission
     */

    public function getPermission() {

        return Permission::findPermission(get_class($this));

    }

    /**
     * Проверяет есль ли в массиве модели, которые можно удалять
     * @param \common\db\ActiveRecord[] $models массив моделей
     * @return bool
     */

    public function hasCanDelete($models) {

        foreach($models AS $model) {

            if(Yii::$app->user->can('deleteModel', array("model"=>$model)))
                return true;
        }

        return false;

    }

    /**
     * Проверяет есль ли в массиве модели, которые можно изменять
     * @param \common\db\ActiveRecord[] $models массив моделей
     * @return bool
     */

    public function hasCanUpdate($models) {

        foreach($models AS $model) {

            if(Yii::$app->user->can('updateModel', array("model"=>$model)))
                return true;
        }

        return false;

    }


}