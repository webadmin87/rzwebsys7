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

    public function init() {

        parent::init();

        if($this->isNewRecord AND !Yii::$app->user->isGuest) {

            $this->username = Yii::$app->user->identity->username;
            $this->email = Yii::$app->user->identity->email;

        }

    }

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