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

			"discount" => [
				"definition" => [
					"class" => \common\db\fields\NumberField::className(),
					"title" => Yii::t('shop/app', 'Discount'),
				],
				"params" => [$this->owner, "discount"]
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
					"class" => \common\db\fields\ListField::className(),
					"title" => Yii::t('shop/app', 'Item class'),
					"isRequired" => true,
					'data'=>[Yii::$app->getModule('shop'), 'getModelNames'],
				],
				"params" => [$this->owner, "item_class"]
			],

			"link" => [
				"definition" => [
					"class" => \common\db\fields\TextField::className(),
					"title" => Yii::t('shop/app', 'Link'),
					"showInGrid"=>false,
				],
				"params" => [$this->owner, "link"]
			],

			"attrs" => [
				"definition" => [
					"class" => \app\modules\shop\db\fields\GoodAttrsField::className(),
					"title" => Yii::t('shop/app', 'Attributes'),
				],
				"params" => [$this->owner, "attrs"]
			],

	        "client_attrs" => [
		        "definition" => [
			        "class" => \app\modules\shop\db\fields\GoodAttrsField::className(),
			        "title" => Yii::t('shop/app', 'Client Attributes'),
		        ],
		        "params" => [$this->owner, "client_attrs"]
	        ],

		];
    }

}