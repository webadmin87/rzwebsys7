<?php

namespace app\modules\geo\models\meta;

use Yii;
use common\db\MetaFields;

/**
 * Class RajonMeta
 * Мета описание модели района
 * @package app\modules\geo\models\meta
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class RajonMeta extends MetaFields
{
    /**
     * @inheritdoc
     */

    protected function config()
    {
        return [

			"region_id" => [
				"definition" => [
					"class" => \common\db\fields\NumberField::className(),
					"title" => Yii::t('geo/app', 'Region id'),
					"isRequired" => true,
				],
				"params" => [$this->owner, "region_id"]
			],

			"clean_title" => [
				"definition" => [
					"class" => \common\db\fields\TextField::className(),
					"title" => Yii::t('geo/app', 'Clean title'),
					"isRequired" => false,
				],
				"params" => [$this->owner, "clean_title"]
			],

            "title" => [
                "definition" => [
                    "class" => \common\db\fields\TextField::className(),
                    "title" => Yii::t('geo/app', 'Title'),
                    "isRequired" => true,
                    "editInGrid" => true,
                ],
                "params" => [$this->owner, "title"]
            ],

			"title2" => [
				"definition" => [
					"class" => \common\db\fields\TextField::className(),
					"title" => Yii::t('geo/app', 'Title 2'),
					"isRequired" => false,
				],
				"params" => [$this->owner, "title2"]
			],

			"type" => [
				"definition" => [
					"class" => \common\db\fields\TextField::className(),
					"title" => Yii::t('geo/app', 'Type'),
					"isRequired" => false,
				],
				"params" => [$this->owner, "type"]
			],

			"type_ext" => [
				"definition" => [
					"class" => \common\db\fields\TextField::className(),
					"title" => Yii::t('geo/app', 'Type ext'),
					"isRequired" => false,
				],
				"params" => [$this->owner, "type_ext"]
			],

			"code" => [
				"definition" => [
					"class" => \common\db\fields\NumberField::className(),
					"title" => Yii::t('geo/app', 'Code'),
					"isRequired" => false,
				],
				"params" => [$this->owner, "code"]
			],

		];
    }

}