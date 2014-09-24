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

			"text" => [
				"definition" => [
					"class" => \common\db\fields\TextField::className(),
					"title" => Yii::t('shop/app', 'Text'),
				],
				"params" => [$this->owner, "text"]
			],

			"tpl" => [
				"definition" => [
					"class" => \common\db\fields\TextField::className(),
					"title" => Yii::t('shop/app', 'Letter tpl'),
				],
				"params" => [$this->owner, "text"]
			],

        ];
    }

}