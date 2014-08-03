<?php
namespace app\modules\news\models;

use common\db\TActiveRecord;
use Yii;

/**
 * Class NewsSection
 * Модель категорий новостей
 * @package app\modules\news\models
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class NewsSection extends TActiveRecord
{

    use \app\modules\main\components\PermissionTrait;

    /**
     * @inheritdoc
     */

    public static function tableName()
    {
        return "news_sections";
    }

    /**
     * @inheritdoc
     */
    public function metaClass()
    {
        return meta\NewsSectionMeta::className();
    }

}