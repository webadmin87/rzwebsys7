<?php
namespace app\modules\shop\models;

use common\db\ActiveRecord;

/**
 * Class Good
 * Модель заказанного товара
 * @property int item_id идентификатор заказанного товара
 * @property string item_class класс заказанного товара
 * @property string item_key ключ (идентификатор) товара - формируется из идентификатора, имени класса и дополнительных аттрибутов товара
 * @property int qty количество заказанных изделий
 * @property string title название
 * @property int price стоимость
 * @property int discount скидка
 * @property string link ссылка на карточку товара
 * @property array attrs дополнительные атрибуты для сохранения

 * @package app\modules\shop\models
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class Good extends ActiveRecord
{

    use \app\modules\main\components\PermissionTrait;

	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		$parent = parent::behaviors();

		$parent['attrsSerializer'] = [
			'class'=>\common\behaviors\ArraySerializer::className(),
			'attribute'=>'attrs',
		];

		return $parent;
	}


	/**
     * @inheritdoc
     */

    public static function tableName()
    {
        return "shop_goods";
    }

    /**
     * @inheritdoc
     */
    public function metaClass()
    {
        return meta\GoodMeta::className();
    }

	/**
	 * Связь с заказом
	 * @return \yii\db\ActiveQuery
	 */
	public function getOrder()
	{
		return $this->hasOne(Order::className(), ["id"=>"order_id"]);
	}


	/**
	 * Возвращает окончательную цену товара с учетом скидок
	 * @return float
	 */
	public function getFinalPrice()
	{

		$price = (double) $this->price - ( (double) $this->price * (double) $this->discount )/100;

		return $price;
	}

	/**
	 * @inheritdoc
	 */
	public function fields()
	{
		$arr = parent::fields();

		$arr = array_merge($arr, ["finalPrice"]);

		return $arr;

	}

}