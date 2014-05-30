<?php
namespace app\modules\main\models;

use Yii;
use common\db\TActiveRecord;

/**
 * Class Pages
 * Модель текстовых страниц
 * @package app\modules\main\models
 * @author Churkin Anton <webadmin87@gmail.com>
 */

class Pages extends TActiveRecord {

    /**
     * @inheritdoc
     */

    public static function tableName() {
        return "pages";
    }

    /**
     * @inheritdoc
     */
    public function metaClass() {
        return meta\PagesMeta::className();
    }

}