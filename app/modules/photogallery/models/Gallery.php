<?php
namespace app\modules\photogallery\models;

use common\db\ActiveRecord;

/**
 * Class Gallery
 * Фотогалерея
 * @package app\modules\photogallery\models
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class Gallery extends ActiveRecord
{

    use \app\modules\main\components\PermissionTrait;

	/**
     * @inheritdoc
     */

    public static function tableName()
    {
        return "photogallery_galleries";
    }

    /**
     * @inheritdoc
     */
    public function metaClass()
    {
        return meta\GalleryMeta::className();
    }


}