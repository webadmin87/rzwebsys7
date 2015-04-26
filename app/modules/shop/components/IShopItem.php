<?php
namespace app\modules\shop\components;

/**
 * Interface IShopItem
 * Интерфейс который необхимо реализовать модели каталога, чтобы использоваться в модуле магазина
 * @package app\modules\shop\components
 * @author Churkin Anton <webadmin87@gmail.com
 */
interface IShopItem
{

	/**
	 * @return int идентификатор товара
	 */
	public function getId();

	/**
	 * @return int цена товара
	 */
	public function getPrice();

	/**
	 * @return int скидка на товар
	 */
	public function getDiscount();

	/**
	 * @return string наименование товара
	 */
	public function getShopTitle();

	/**
	 * @return string возвращает ссылку на страницу с товаром
	 */
	public function getLink();

	/**
	 * @return array массив атрибутов моделей, которые необходимо сохранять при заказе
	 *
	 * Должен иметь следующий вид:
	 *
	 * [
	 * 		'app\modules\catalog\models\Catalog' => [
	 *
	 * 			"articul"=>"articul",
	 * 			"producer"=>"producer.title",
	 * 		]
	 * ]
	 */
	public function getShopModelAttributes();

	/**
	 * @return array массив названий атрибутов, которые могут быть переданы клиентом при заказе
	 *
	 * Должен иметь следующий вид:
	 *
	 * [
	 * 		'app\modules\catalog\models\Catalog' => [
	 * 			"color",
	 * 			"size",
	 * 		]
	 * ]
	 */
	public function getShopClientAttributes();

}