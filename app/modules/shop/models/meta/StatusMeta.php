<?php
namespace app\modules\shop\models\meta;

use Yii;
use common\db\MetaFields;

/**
 * Class StatusMeta
 * Мета описание модели статусов
 * @package app\modules\shop\models\meta
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class StatusMeta extends MetaFields
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

            "default" => [
                "definition" => [
                    "class" => \common\db\fields\CheckBoxField::className(),
                    "title" => Yii::t('shop/app', 'Default'),
                ],
                "params" => [$this->owner, "default"]
            ],

			"text" => [
				"definition" => [
					"class" => \common\db\fields\TextAreaField::className(),
					"title" => Yii::t('shop/app', 'Text'),
				],
				"params" => [$this->owner, "text"]
			],

			"tpl" => [
				"definition" => [
					"class" => \common\db\fields\TextField::className(),
					"title" => Yii::t('shop/app', 'Tpl name'),
				],
				"params" => [$this->owner, "tpl"]
			],

            "tplHtml" => [
                "definition" => [
                    "class" => \common\db\fields\TextAreaField::className(),
                    "title" => Yii::t('shop/app', 'Letter tpl'),
                    "inputClassOptions" => [
                        "options" => ["rows"=>20]
                    ],

                ],
                "params" => [$this->owner, "tplHtml"]
            ],

        ];
    }

}