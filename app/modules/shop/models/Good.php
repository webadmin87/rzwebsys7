<?php
namespace app\modules\shop\models;

use common\db\ActiveRecord;
use yii\helpers\ArrayHelper;

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
 * @property array attrs дополнительные атрибуты для сохранения из БД
 * @property array client_attrs дополнительные аттрибуты для сохранения, передаваемые клиентом

 * @package app\modules\shop\models
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class Good extends ActiveRecord
{

    use \app\modules\main\components\PermissionTrait;

	protected $_item;

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

		$parent['clientAttrsSerializer'] = [
			'class'=>\common\behaviors\ArraySerializer::className(),
			'attribute'=>'client_attrs',
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
	 * Формирует ключ
	 * @return string ключ (идентификатор) товара в корзине
	 */
	public function generateKey()
	{

		$shopKey = [
			'item_id' => $this->item_id,
			'item_class' => $this->item_class,
			'attrs' => $this->attrs,
			'client_attrs' => $this->client_attrs,
		];

		$shopKey = json_encode($shopKey);

		return md5($shopKey);
	}

	/**
	 * Возвращает модель заказанного товара
	 * @return mixed
	 */
	public function getItem()
	{
		if ( !$this->_item ) {
			$class = $this->item_class;
			$this->_item = $class::findOne($this->item_id);
		}

		return $this->_item;
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

	/**
	 * Сохраняет аттрибуты связанной модели товара
	 * @return bool
	 */
	public function setModelAttributes()
	{
		$model = $this->getItem();

		if ( !$model ) {
			return false;
		}

		$modelAttrs = [];

		$modelAttrsNames = $model->getShopModelAttributes();

		if(!empty($modelAttrsNames)) {
			foreach($modelAttrsNames AS $k=>$v) {
				$modelAttrs[$k]= ArrayHelper::getValue($model, $v);
			}
		}

		$this->attrs = $modelAttrs;

		return true;

	}

	/**
	 * Сохраняет аттрибуты переданные клиентом
	 * @param $attrs
	 * @return bool
	 */
	public function setClientAttributes($attrs = null)
	{
		if ( is_null($attrs) ) {
			$attrs = $this->client_attrs;
		}

		$model = $this->getItem();

		if ( !$model ) {
			return false;
		}

		$clientAttrs = [];

		$clientAttrsNames = $model->getShopClientAttributes();

		if ( !empty($clientAttrsNames) ) {
			foreach ($clientAttrsNames as $name) {
				$clientAttrs[$name] = isset($attrs[$name]) ? $attrs[$name] : null;
			}
		}

		$this->client_attrs = $clientAttrs;

		return true;
	}

	/**
	 * @inheritdoc
	 */
	public function beforeSave($insert){

		if ( $insert ) {
			$this->setClientAttributes();
			$this->setModelAttributes();
		}

		if (parent::beforeSave($insert)) {

			$this->item_key = $this->generateKey();

			return true;
		}
		else {
			return false;
		}

	}

}