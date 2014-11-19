<?php

namespace app\modules\geo\models;

use common\db\ActiveRecord;

/**
 * Class Street
 * Модель улицы
 * @package app\modules\geo\models
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class Street extends ActiveRecord
{

	use \app\modules\main\components\PermissionTrait;

	/**
	 * @inheritdoc
	 */

	public static function tableName()
	{
		return "geo_street";
	}

	/**
	 * @inheritdoc
	 */
	public function metaClass()
	{
		return meta\StreetMeta::className();
	}

	/**
	 * Связь с районом
	 * @return \yii\db\ActiveQuery
	 */
	public function getRajon()
	{

		return $this->hasOne(Rajon::className(), ["id" => "rajon_id"]);

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