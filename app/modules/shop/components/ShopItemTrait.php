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
     * @param array $attrs дополнительные аттрибуты для формирования ключа
     * @return string ключ (идентификатор) товара в корзине
     */
    public function getShopKey($attrs = [])
    {
        $shopKey = $attrs;
        $shopKey['id'] = $this->getId();
        $shopKey['class'] = get_class($this);
        $shopKey = json_encode($shopKey);

        return md5($shopKey);
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



}