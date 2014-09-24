<?php
namespace app\modules\shop\models;

use common\db\ActiveRecord;

/**
 * Class Status
 * Модель статуса заказа
 * @package app\modules\shop\models
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class Status extends ActiveRecord
{

    use \app\modules\main\components\PermissionTrait;

	/**
     * @inheritdoc
     */

    public static function tableName()
    {
        return "shop_status";
    }

    /**
     * @inheritdoc
     */
    public function metaClass()
    {
        return meta\StatusMeta::className();
    }


}