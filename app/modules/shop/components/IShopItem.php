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
	 * @param array $attrs - дополнительные аттрибуты для формирования уникального идентификатора заказанного товара в корзине
	 * @return string  ключ (идентификатор) товара для работы в корзине
	 */
	public function getShopKey($attrs = []);

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

}