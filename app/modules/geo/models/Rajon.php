<?php

namespace app\modules\geo\models;

use common\db\ActiveRecord;

/**
 * Class Rajon
 * Модель района
 * @package app\modules\geo\models
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class Rajon extends ActiveRecord
{

	use \app\modules\main\components\PermissionTrait;

	/**
	 * @inheritdoc
	 */

	public static function tableName()
	{
		return "geo_rajon";
	}

	/**
	 * @inheritdoc
	 */
	public function metaClass()
	{
		return meta\RajonMeta::className();
	}


	/**
	 * Связь с населенными пунктами
	 * @return \yii\db\ActiveQuery
	 */
	public function getNps()
	{

		return $this->hasMany(Np::className(), ["rajon_id" => "id"])->published();

	}

	/**
	 * Связь с регионом
	 * @return \yii\db\ActiveQuery
	 */
	public function getRegion()
	{

		return $this->hasOne(Region::className(), ["id" => "region_id"]);

	}

}