<?php
namespace app\modules\shop\components;

/**
 * Class ShopItemTrait
 * Трейт предназначенный для реализации интерфейса IShopItem для \common\db\ActiveRecord
 * Модель должна содержать атрибуты id, price и title
 * @package app\modules\shop\components
 * @author Churkin Anton <webadmin87@gmail.com>
 */
trait ShopItemTrait
{

    /**
     * @return int идентификатор товара
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int цена товара
     */
    public function getPrice() {
        return $this->price;
    }

    /**
     * @return int скидка на товар
     */
    public function getDiscount()
    {
        return 0;
    }

    /**
     * @return string наименование товара
     */
    public function getShopTitle()
    {
        return $this->title;
    }

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
    public function getShopModelAttributes()
    {
        return [
            "producer"=>"producer.title",
        ];
    }

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
    public function getShopClientAttributes()
    {
        return ['color'];
    }



}