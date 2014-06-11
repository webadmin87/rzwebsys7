<?php
namespace common\db;

use Yii;
use common\behaviors\NestedSet;
use yii\bootstrap\ActiveForm;


/**
 * Class TActiveRecord
 * Надстройка над ActiveRecord для реализации древовидных структур.
 * @package common\db
 * @author Churkin Anton <webadmin87@gmail.com>
 */

abstract class TActiveRecord extends ActiveRecord {

    /**
     * Идентификатор корневой записи
     */

    const ROOT_ID = 1;

    /**
     * @var int идентификатор родительской модели
     */

    public $parent_id = self::ROOT_ID;

    /**
     * @inheritdoc
     */

    public function behaviors() {

        $behaviors = parent::behaviors();

        $behaviors["nestedSets"] = [

            "class"=>NestedSet::className(),

        ];

        return $behaviors;

    }

    /**
     * @inheritdoc
     * @return \common\db\TActiveQuery
     */
    public static function find()
    {
        return Yii::createObject(\common\db\TActiveQuery::className(), [get_called_class()]);
    }


    /**
     * Возвращает массив для заполнения списка выбора родителя модели
     * @param int $parent_id
     * @param string $attr
     * @return array
     */

    public function getListTreeData($parent_id = self::ROOT_ID, $attr = "title") {

        $arr = [self::ROOT_ID=>Yii::t('core', 'Root')];

        $model = static::find()->where(["id"=>$parent_id])->one();

        if(!$model) {

            return $arr;

        }

        $models = $model->descendants()->published()->all();

        if(!$this->isNewRecord) {

            // @tofix получить массив потомков и исключить их из списка

            $descendants = $this->descendants()->published()->all();

            $descendants[] = $this;

        } else {

            $descendants = [];

        }

        foreach($models AS $m) {

            if($this->inArray($descendants, $m))
                continue;

            $arr[$m->id] = str_repeat("-", $m->level) . $m->$attr;

        }

        return $arr;

    }

    /**
     * Содердится ли в массиве $models модель $model
     * @param ActiveRecord[] $models
     * @param ActiveRecord $model
     * @return bool
     */

    public function inArray($models, $model) {

        foreach($models AS $m) {

            if($m->id == $model->id)
                return true;
        }

        return false;

    }

    /**
     * Возвращает массив для хлебных крошек
     * @param int $id идентификатор модели до которой строить хлебные крошки
     * @param string $route маршрут для url
     * @param string $attr имя атрибута для label
     * @return array
     */

    public function getBreadCrumbsItems($id, $route, $attr = "title") {

        $model = static::find()->where(["id"=>$id])->one();

        $models = $model->ancestors()->all();

        $models[] = $model;

        $arr = [];

        foreach($models AS $model) {

            if(empty($model->$attr))
                continue;

            $arr[] = [

                "url"=>[$route, "parent_id"=>$model->id],
                "label"=>$model->$attr,

            ];

        }


        return $arr;

    }

}