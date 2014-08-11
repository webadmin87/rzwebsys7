<?php

namespace app\modules\geo\models;

use common\db\ActiveRecord;

/**
 * Class Region
 * Модель региона
 * @package app\modules\geo\models
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class Region extends ActiveRecord
{

    use \app\modules\main\components\PermissionTrait;

	/**
     * @inheritdoc
     */

    public static function tableName()
    {
        return "geo_region";
    }

    /**
     * @inheritdoc
     */
    public function metaClass()
    {
        return meta\RegionMeta::className();
    }

	/**
	 * Связь с районами
	 * @return \yii\db\ActiveQuery
	 */
	public function getRajons() {

		return $this->hasMany(Rajon::className(), ["region_id"=>"id"])->published();

	}

	/**
	 * Связь со страной
	 * @return \yii\db\ActiveQuery
	 */
	public function getCountry() {

		return $this->hasOne(Country::className(), ["id"=>"country_id"]);

	}


}