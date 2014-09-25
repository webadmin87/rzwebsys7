<?php
namespace app\modules\catalog\models;

use common\db\ActiveRecord;

/**
 * Class Producer
 * Модель производителей
 * @package app\modules\catalog\models
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class Producer extends ActiveRecord
{

    use \app\modules\main\components\PermissionTrait;

	/**
     * @inheritdoc
     */

    public static function tableName()
    {
        return "catalog_producers";
    }

    /**
     * @inheritdoc
     */
    public function metaClass()
    {
        return meta\ProducerMeta::className();
    }


}