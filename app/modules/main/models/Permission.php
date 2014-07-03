<?php
namespace app\modules\main\models;

use Yii;
use common\db\ActiveRecord;
use common\rbac\IPermission;
/**
 * Class Permission
 * Модель прав доступа
 * @package app\modules\main\models
 * @author Churkin Anton <webadmin87@gmail.com>
 */

class Permission extends ActiveRecord implements IPermission {

    /**
     * @var \common\rbac\IConstraint объект ограничения доступа
     */

    protected $_constraintObject;

    /**
     * @var array массив атрибутов запрещенных к редактированию
     */

    protected $_forbiddenAttrs;

    /**
     * @var Permission[]
     */

    protected static $_permissions = array();

    /**
     * Возвращает объект ограничения доступа
     * @return \common\rbac\IConstraint
     * @throws \yii\base\InvalidConfigException
     */

    public function getConstraintObject() {

        if($this->_constraintObject === null AND !empty($this->constraint)) {

            $this->_constraintObject = Yii::createObject($this->constraint);

        }

        return $this->_constraintObject;

    }

    /**
     * Возвращает объект прав доступа для модели с заданным классом
     * @param string $class класс модели
     * @return Permission
     */

    public static function findPermission($class) {

        if(!isset(self::$_permissions[$class])) {
            self::$_permissions[$class] = static::find()->published()->where(["model"=>$class, "role"=>Yii::$app->user->identity->role])->one();
        }

        return self::$_permissions[$class];

    }

    /**
     * @inheritdoc
     */

    public static function tableName() {
        return "permission";
    }

    /**
     * @inheritdoc
     */
    public function metaClass() {
        return meta\PermissionMeta::className();
    }

    /**
     * Создание модели
     * @return bool
     */

    public function createModel() {

        return (boolean) $this->create;

    }


    /**
     * Просмотр списка моделей
     * @return bool
     */

    public function listModels() {

        return (boolean) $this->read;

    }

    /**
     * Возможность удаления моделей
     * @return bool
     */

    public function deleteModels() {

        return (boolean) $this->delete;

    }

    /**
     * Возможность изменения моделей
     * @return bool
     */

    public function updateModels() {

        return (boolean) $this->update;

    }

    /**
     * Чтение
     * @param \common\db\ActiveRecord $model модель
     * @return bool
     */

    public function readModel($model) {

        if(empty($this->read))
            return false;

        $constraint = $this->getConstraintObject();

        return $constraint === null OR $constraint->read($model);

    }

    /**
     * Обновление
     * @param \common\db\ActiveRecord $model модель
     * @return bool
     */

    public function updateModel($model) {

        if(empty($this->update))
            return false;

        $constraint = $this->getConstraintObject();

        return $constraint === null OR $constraint->update($model);


    }


    /**
     * Удаление
     * @param \common\db\ActiveRecord $model модель
     * @return bool
     */

    public function deleteModel($model) {

        if(empty($this->delete))
            return false;

        $constraint = $this->getConstraintObject();

        return $constraint === null OR $constraint->delete($model);


    }

    /**
     * Применяет ограничение к запрос
     * @param \common\db\ActiveQuery $query запрос
     */

    public function applyConstraint($query) {


        $constraint = $this->getConstraintObject();

        if($constraint)
            $constraint->applyConstraint($query);

    }


    /**
     * Возвращает массив имен атрибутов запрещенных к редактировнаию
     * @return array
     */

    public function getForbiddenAttrs() {

        if($this->_forbiddenAttrs === null) {

            $arr = [];

            $strs = explode("\n", $this->forbidden_attrs);

            foreach($strs AS $str) {

                $str = trim($str);

                if(!empty($str))
                    $arr[] = $str;

            }

            $this->_forbiddenAttrs = $arr;

        }

        return $this->_forbiddenAttrs;

    }

    /**
     * Является ди атрибут запрещенным к редактированию
     * @param string $attr атрибут
     * @return bool
     */

    public function isAttributeForbidden($attr) {

        $arr = $this->getForbiddenAttrs();

        return in_array($attr, $arr);
    }

    /**
     * Присутствуют ли в массиве атрибутов запрещенные к изменению
     * @param array $attrs массив атрибутов key=>value
     * @return bool
     */

    public function hasForbiddenAttrs($attrs) {

        $arr = $this->getForbiddenAttrs();

        $keys = array_keys($attrs);

        $inter = array_intersect($keys, $arr);

        return count($inter)>0;
    }

}