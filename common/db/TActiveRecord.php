<?php
namespace common\db;

use Yii;
use \creocoder\behaviors\NestedSet;


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

            $arr[$m->id] = str_repeat("-", $m->level) . $model->$attr;

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

}