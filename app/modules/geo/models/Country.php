<?php
namespace app\modules\geo\models;

use common\db\ActiveRecord;

/**
 * Class Country
 * Модель страны
 * @package app\modules\geo\models
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class Country extends ActiveRecord
{

	use \app\modules\main\components\PermissionTrait;

	/**
	 * @inheritdoc
	 */

	public static function tableName()
	{
		return "geo_countrys";
	}

	/**
	 * @inheritdoc
	 */
	public function metaClass()
	{
		return meta\CountryMeta::className();
	}

	/**
	 * Связь с регионами
	 * @return \yii\db\ActiveQuery
	 */
	public function getRegions()
	{

		return $this->hasMany(Region::className(), ["country_id" => "id"])->published();

	}

}