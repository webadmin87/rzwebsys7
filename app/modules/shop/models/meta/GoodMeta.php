<?php
namespace app\modules\shop\models\meta;

use Yii;
use common\db\MetaFields;

/**
 * Class GoodMeta
 * Мета описание модели заказанного товара
 * @package app\modules\shop\models\meta
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class GoodMeta extends MetaFields
{
    /**
     * @inheritdoc
     */

    protected function config()
    {
        return [

			"order_id" => [
				"definition" => [
					"class" => \common\db\fields\NumberField::className(),
					"title" => Yii::t('shop/app', 'Order ID'),
					"isRequired" => true,
				],
				"params" => [$this->owner, "order_id"]
			],

            "title" => [
                "definition" => [
                    "class" => \common\db\fields\TextField::className(),
                    "title" => Yii::t('shop/app', 'Title'),
                ],
                "params" => [$this->owner, "title"]
            ],

			"price" => [
				"definition" => [
					"class" => \common\db\fields\NumberField::className(),
					"title" => Yii::t('shop/app', 'Price'),
					"isRequired" => true,
				],
				"params" => [$this->owner, "price"]
			],

			"qty" => [
				"definition" => [
					"class" => \common\db\fields\NumberField::className(),
					"title" => Yii::t('shop/app', 'Quantity'),
					"isRequired" => true,
				],
				"params" => [$this->owner, "qty"]
			],

			"item_id" => [
				"definition" => [
					"class" => \common\db\fields\NumberField::className(),
					"title" => Yii::t('shop/app', 'Item ID'),
					"isRequired" => true,
				],
				"params" => [$this->owner, "item_id"]
			],

			"item_class" => [
				"definition" => [
					"class" => \common\db\fields\TextField::className(),
					"title" => Yii::t('shop/app', 'Item class'),
					"isRequired" => true,
				],
				"params" => [$this->owner, "item_class"]
			],

			"attrs" => [
				"definition" => [
					"class" => \common\db\fields\HiddenField::className(),
					"title" => Yii::t('shop/app', 'Attributes'),
					"showInGrid"=>false,
				],
				"params" => [$this->owner, "attrs"]
			],


		];
    }

}