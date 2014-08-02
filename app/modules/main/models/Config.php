<?php
namespace app\modules\main\models;

use common\db\ActiveRecord;
use Yii;

/**
 * Class Config
 * Модель конфига
 * @package app\modules\main\models
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class Config extends ActiveRecord
{

    /**
     * @inheritdoc
     */

    public static function tableName()
    {
        return "config";
    }

    /**
     * @inheritdoc
     */
    public function metaClass()
    {
        return meta\ConfigMeta::className();
    }

}