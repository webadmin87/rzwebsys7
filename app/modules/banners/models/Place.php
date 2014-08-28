<?php
namespace app\modules\banners\models;

use common\db\ActiveRecord;

/**
 * Class Place
 * Модель баннерного места
 * @package app\modules\banners\models
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class Place extends ActiveRecord
{

    use \app\modules\main\components\PermissionTrait;

	/**
     * @inheritdoc
     */

    public static function tableName()
    {
        return "banners_places";
    }

    /**
     * @inheritdoc
     */
    public function metaClass()
    {
        return meta\PlaceMeta::className();
    }

	/**
	 * Связь с баннерами
	 * @return \yii\db\ActiveQuery
	 */
	public function getBanners()
	{
		return $this->hasMany(Banner::className(), ["place_id"=>"id"]);
	}


}