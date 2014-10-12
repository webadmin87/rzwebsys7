<?php
namespace app\modules\shop\models\meta;

use Yii;
use common\db\MetaFields;

/**
 * Class DeliveryMeta
 * Мета описание модели способов доставки
 * @package app\modules\shop\models\meta
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class DeliveryMeta extends MetaFields
{
    /**
     * @inheritdoc
     */

    protected function config()
    {
        return [

            "title" => [
                "definition" => [
                    "class" => \common\db\fields\TextField::className(),
                    "title" => Yii::t('shop/app', 'Title'),
                    "isRequired" => true,
                    "editInGrid" => true,
                ],
                "params" => [$this->owner, "title"]
            ],

			"text" => [
				"definition" => [
					"class" => \common\db\fields\HtmlField::className(),
					"title" => Yii::t('shop/app', 'Text'),
				],
				"params" => [$this->owner, "text"]
			],

			"price" => [
				"definition" => [
					"class" => \common\db\fields\NumberField::className(),
					"title" => Yii::t('shop/app', 'Price'),
				],
				"params" => [$this->owner, "price"]
			],

			"free_limit" => [
				"definition" => [
					"class" => \common\db\fields\NumberField::className(),
					"title" => Yii::t('shop/app', 'Free limit'),
				],
				"params" => [$this->owner, "free_limit"]
			],

			"class" => [
				"definition" => [
					"class" => \common\db\fields\TextField::className(),
					"title" => Yii::t('shop/app', 'Class'),
					"showInGrid"=>false,
				],
				"params" => [$this->owner, "class"]
			],

			"sort" => [
				"definition" => [
					"class" => \common\db\fields\NumberField::className(),
					"title" => Yii::t('shop/app', 'Sort'),
					"showInGrid"=>true,
                    "editInGrid"=>true,
				],
				"params" => [$this->owner, "sort"]
			],

        ];
    }

}