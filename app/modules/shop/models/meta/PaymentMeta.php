<?php
namespace app\modules\shop\models\meta;

use Yii;
use common\db\MetaFields;

/**
 * Class PaymentMeta
 * Мета описание модели способов оплаты
 * @package app\modules\shop\models\meta
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class PaymentMeta extends MetaFields
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

			"text" => [
				"definition" => [
					"class" => \common\db\fields\HtmlField::className(),
					"title" => Yii::t('shop/app', 'Text'),
				],
				"params" => [$this->owner, "text"]
			],

			"html" => [
				"definition" => [
					"class" => \common\db\fields\TextAreaField::className(),
					"title" => Yii::t('shop/app', 'Result html'),
				],
				"params" => [$this->owner, "html"]
			],

			"constraint_class" => [
				"definition" => [
					"class" => \common\db\fields\TextField::className(),
					"title" => Yii::t('shop/app', 'Constraint class'),
				],
				"params" => [$this->owner, "constraint_class"]
			],

        ];
    }

}