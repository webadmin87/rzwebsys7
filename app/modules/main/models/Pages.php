<?php
namespace app\modules\main\models;

use common\db\TActiveRecord;
use Yii;

/**
 * Class Pages
 * Модель текстовых страниц
 * @package app\modules\main\models
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class Pages extends TActiveRecord
{

    use \app\modules\main\components\PermissionTrait;

    /**
     * @inheritdoc
     */

    public static function tableName()
    {
        return "pages";
    }

    /**
     * @inheritdoc
     */
    public function metaClass()
    {
        return meta\PagesMeta::className();
    }

}