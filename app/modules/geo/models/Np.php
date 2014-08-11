<?php

namespace app\modules\geo\models;

use common\db\ActiveRecord;

/**
 * Class Np
 * Модель населенного пункта
 * @package app\modules\geo\models
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class Np extends ActiveRecord
{

    use \app\modules\main\components\PermissionTrait;

	/**
     * @inheritdoc
     */

    public static function tableName()
    {
        return "geo_np";
    }

    /**
     * @inheritdoc
     */
    public function metaClass()
    {
        return meta\NpMeta::className();
    }

	/**
	 * Связь с районом
	 * @return \yii\db\ActiveQuery
	 */
	public function getRajon() {

		return $this->hasOne(Rajon::className(), ["id"=>"rajon_id"]);

	}


}