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

}