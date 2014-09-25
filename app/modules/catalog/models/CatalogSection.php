<?php
namespace app\modules\catalog\models;

use common\db\TActiveRecord;
use Yii;

/**
 * Class CatalogSection
 * Модель категорий каталога
 * @package app\modules\catalog\models
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class CatalogSection extends TActiveRecord
{

    use \app\modules\main\components\PermissionTrait;

    /**
     * @inheritdoc
     */

    public static function tableName()
    {
        return "catalog_sections";
    }

    /**
     * @inheritdoc
     */
    public function metaClass()
    {
        return meta\CatalogSectionMeta::className();
    }

}