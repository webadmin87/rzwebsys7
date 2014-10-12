<?php
namespace app\modules\shop\models;

use common\db\ActiveRecord;

/**
 * Class Payment
 * Модель вариантов оплаты
 * @package app\modules\shop\models
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class Payment extends ActiveRecord
{

    use \app\modules\main\components\PermissionTrait;

	/**
     * @inheritdoc
     */

    public static function tableName()
    {
        return "shop_payment";
    }

    /**
     * @inheritdoc
     */
    public function metaClass()
    {
        return meta\PaymentMeta::className();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $parent = parent::rules();

        $parent[] = ['sort', 'default', 'value'=>500];

        return $parent;
    }

}