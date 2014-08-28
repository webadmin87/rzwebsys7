<?php
namespace app\modules\banners\models;

use Yii;
use common\db\ActiveRecord;

/**
 * Class Banner
 * Модель баннера
 * @package app\modules\banners\models
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class Banner extends ActiveRecord
{

    use \app\modules\main\components\PermissionTrait;

	const DEFAULT_SORT = 500;

	/**
	 * Возвращает массив хначений для атрибута target ссылки с баннера
	 * @return array
	 */
	public static function getTargets() {

		return [
			"_blank"=>Yii::t("banners/app", "Blank"),
			"_self"=>Yii::t("banners/app", "Self")
		];

	}

	/**
     * @inheritdoc
     */

    public static function tableName()
    {
        return "banners_banners";
    }

    /**
     * @inheritdoc
     */
    public function metaClass()
    {
        return meta\BannerMeta::className();
    }

	/**
	 * Связь с баннерами
	 * @return \yii\db\ActiveQuery
	 */
	public function getPlace()
	{

		return $this->hasOne(Place::className(), ["id"=>"place_id"]);

	}

	/**
	 * @inheritdoc
	 */
	public function beforeSave($insert)
	{
		if(parent::beforeSave($insert)) {

			$this->sort = self::DEFAULT_SORT;

			return true;

		}

		return false;

	}


}