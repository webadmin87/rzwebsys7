<?php
namespace app\modules\banners\models\meta;

use Yii;
use common\db\MetaFields;

/**
 * Class PlaceMeta
 * Мета описание модели баннерных мест
 * @package app\modules\banners\models\meta
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class PlaceMeta extends MetaFields
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
                    "title" => Yii::t('banners/app', 'Title'),
                    "isRequired" => true,
                    "editInGrid" => true,
                ],
                "params" => [$this->owner, "title"]
            ],

			"code" => [
				"definition" => [
					"class" => \common\db\fields\CodeField::className(),
					"title" => Yii::t('banners/app', 'Code'),
					"isRequired" => true,
					"editInGrid" => true,
				],
				"params" => [$this->owner, "code"]
			],

        ];
    }

}