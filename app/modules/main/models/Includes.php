<?php
namespace app\modules\main\models;

use Yii;
use common\db\ActiveRecord;
use common\components\Match;

/**
 * Class Includes
 * Модель включаемых областей
 * @package app\modules\main\models
 * @author Churkin Anton <webadmin87@gmail.com>
 */

class Includes extends ActiveRecord {

    use \app\modules\main\components\PermissionTrait;

    /**
     * @var Includes[] массив включаемых областей
     */

    protected static $models;

     /**
     * @inheritdoc
     */

    public static function tableName() {
        return "includes";
    }

    /**
     * @inheritdoc
     */
    public function metaClass() {
        return meta\IncludesMeta::className();
    }

    /**
     * Возвращает выборку всех активных включаемых областей.
     * Кешируются в статическом свойстве
     * @return Includes[]
     */

    public static function findAllModels() {

        if(static::$models === null) {

            static::$models = static::find()->published()->all();

        }

        return static::$models;

    }

    /**
     * Возвращает включаемую область по символьному коду
     * @param string $code символьный код включаемой области
     * @return Includes|null
     */

    public static function findByCode($code) {

        $models = static::findAllModels();

        foreach($models As $model) {

            if($model->code == $code)
                return $model;

        }

        return null;

    }

}