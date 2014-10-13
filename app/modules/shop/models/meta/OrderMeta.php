<?php
namespace app\modules\shop\models\meta;

use Yii;
use common\db\MetaFields;
use yii\helpers\ArrayHelper;
use app\modules\shop\models\Delivery;
use app\modules\shop\models\Payment;
use app\modules\shop\models\Status;

/**
 * Class OrderMeta
 * Мета описание модели заказа
 * @package app\modules\shop\models\meta
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class OrderMeta extends MetaFields
{
    /**
     * @inheritdoc
     */

    protected function config()
    {
        return [

			"status_id" => [
				"definition" => [
					"class" => \common\db\fields\HasOneField::className(),
					"title" => Yii::t('shop/app', 'Status'),
					"isRequired" => true,
					"showInGrid" => true,
					"editInGrid" => true,
					"data"=>[$this, "getStatusList"],
				],
				"params" => [$this->owner, "status_id", "status"]
			],

            "name" => [
                "definition" => [
                    "class" => \common\db\fields\TextField::className(),
                    "title" => Yii::t('shop/app', 'Name'),
                    "isRequired" => true,
                    "editInGrid" => true,
                ],
                "params" => [$this->owner, "name"]
            ],

			"email" => [
				"definition" => [
					"class" => \common\db\fields\EmailField::className(),
					"title" => Yii::t('shop/app', 'Email'),
					"isRequired" => true,
					"editInGrid" => true,
				],
				"params" => [$this->owner, "email"]
			],

			"phone" => [
				"definition" => [
					"class" => \common\db\fields\TextField::className(),
					"title" => Yii::t('shop/app', 'Phone'),
					"editInGrid" => true,
				],
				"params" => [$this->owner, "phone"]
			],

			"city" => [
				"definition" => [
					"class" => \common\db\fields\TextField::className(),
					"title" => Yii::t('shop/app', 'City'),
					"isRequired" => true,
					"showInGrid" => false,
				],
				"params" => [$this->owner, "city"]
			],

			"index" => [
				"definition" => [
					"class" => \common\db\fields\TextField::className(),
					"title" => Yii::t('shop/app', 'Index'),
					"showInGrid" => false,
				],
				"params" => [$this->owner, "index"]
			],

			"address" => [
				"definition" => [
					"class" => \common\db\fields\TextField::className(),
					"title" => Yii::t('shop/app', 'Address'),
					"isRequired" => true,
					"showInGrid" => false,
				],
				"params" => [$this->owner, "address"]
			],

			"comment" => [
				"definition" => [
					"class" => \common\db\fields\TextAreaField::className(),
					"title" => Yii::t('shop/app', 'Comment'),
					"showInGrid" => false,
				],
				"params" => [$this->owner, "comment"]
			],

			"delivery_id" => [
				"definition" => [
					"class" => \common\db\fields\HasOneField::className(),
					"title" => Yii::t('shop/app', 'Delivery'),
					"isRequired" => true,
					"showInGrid" => false,
					"data"=>[$this, "getDeliveryList"],
				],
				"params" => [$this->owner, "delivery_id", "delivery"]
			],

			"payment_id" => [
				"definition" => [
					"class" => \common\db\fields\HasOneField::className(),
					"title" => Yii::t('shop/app', 'Payment'),
					"isRequired" => true,
					"showInGrid" => false,
					"data"=>[$this, "getPaymentList"],
				],
				"params" => [$this->owner, "payment_id", "payment"]
			],

			"delivery_price" => [
				"definition" => [
					"class" => \common\db\fields\NumberField::className(),
					"title" => Yii::t('shop/app', 'Delivery price'),
					"showInGrid" => false,
				],
				"params" => [$this->owner, "delivery_price"]
			],

        ];
    }

	/**
	 * Возвращает список способов доставки для выпадающего списка
	 * @return array
	 */
	public function getDeliveryList()
	{

		$models = Delivery::find()->published()->orderBy(["sort"=>SORT_ASC])->all();

		return ArrayHelper::map($models, "id", "title");

	}


	/**
	 * Возвращает список способов оплатвы для выпадающего списка
	 * @return array
	 */
	public function getPaymentList()
	{

		$models = Payment::find()->published()->orderBy(["sort"=>SORT_ASC])->all();

		return ArrayHelper::map($models, "id", "title");

	}

	/**
	 * Возвращает список статусов для выпадающего списка
	 * @return array
	 */
	public function getStatusList()
	{

		$models = Status::find()->published()->orderBy(["title"=>SORT_ASC])->all();

		return ArrayHelper::map($models, "id", "title");

	}

}