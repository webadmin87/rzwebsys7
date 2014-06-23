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


}