<?php
namespace app\modules\shop\models;

use Yii;
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

    /**
     * @inheritdoc
     * @return \app\modules\shop\db\StatusQuery
     */
    public static  function find()
    {
        return Yii::createObject(\app\modules\shop\db\StatusQuery::className(), [get_called_class()]);
    }

}