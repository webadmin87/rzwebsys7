<?php

namespace app\modules\geo\models\meta;

use Yii;
use common\db\MetaFields;

/**
 * Class CountryMeta
 * Мета описание модели страны
 * @package app\modules\geo\models\meta
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class CountryMeta extends MetaFields
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
					"title" => Yii::t('geo/app', 'Title'),
					"isRequired" => true,
					"editInGrid" => true,
				],
				"params" => [$this->owner, "title"]
			],

		];
	}

}