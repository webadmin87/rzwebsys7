<?php
namespace app\modules\main\models;

use Yii;
use common\db\TActiveRecord;
use common\components\Match;

/**
 * Class Comments
 * Модель комментариев
 * @package app\modules\main\models
 * @author Churkin Anton <webadmin87@gmail.com>
 */

class Comments extends TActiveRecord {

     /**
     * @inheritdoc
     */

    public static function tableName() {
        return "comments";
    }

    /**
     * @inheritdoc
     */
    public function metaClass() {
        return meta\CommentsMeta::className();
    }

}