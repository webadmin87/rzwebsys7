<?php
namespace app\modules\news\models;

use Yii;
use common\db\ActiveRecord;
use common\components\Match;

/**
 * Class News
 * Модель новостей
 * @package app\modules\news\models
 * @author Churkin Anton <webadmin87@gmail.com>
 */

class News extends ActiveRecord {

     /**
     * @inheritdoc
     */

    public static function tableName() {
        return "news";
    }

    /**
     * @inheritdoc
     */
    public function metaClass() {
        return meta\NewsMeta::className();
    }

}