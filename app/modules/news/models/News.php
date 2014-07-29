<?php
namespace app\modules\news\models;

use Yii;
use common\db\ActiveRecord;
use common\components\Match;

/**
 * Class News
 * Модель новостей
 * @package app\modules\news\models
 * @author Churkin Anton <webadmin87@gmail.com>
 */

class News extends ActiveRecord {

    /**
     * @var array массив идентификаторов связанных категорий
     */

    protected  $_sectionsIds;

    /**
     * Получение идентификаторов связанных категорий
     * @return array
     */
    public function getSectionsIds()
    {

        if($this->_sectionsIds === null) {

            $this->_sectionsIds = $this->getManyManyIds("sections");
        }

        return $this->_sectionsIds;
    }

    /**
     * Установка идентификаторов связанных категорий
     * @param array $sectionsIds
     */
    public function setSectionsIds($sectionsIds)
    {
        $this->_sectionsIds = $sectionsIds;
    }


    /**
     * @inheritdoc
     */

    public function behaviors()
    {
        $arr =  parent::behaviors();

        $arr["manyManySaver"] = [
            'class'=>\common\behaviors\ManyManySaver::className(),
            'names'=>['sections'],
        ];
        return $arr;
    }


    /**
     * @inheritdoc
     */

    public static function tableName() {
        return "news";
    }

    /**
     * @inheritdoc
     */
    public function metaClass() {
        return meta\NewsMeta::className();
    }

    /**
     * Связь с категориями
     * @return \yii\db\ActiveQueryInterface
     */

    public function getSections() {

        return $this->hasMany(NewsSection::className(), ['id'=>'section_id'])->viaTable('news_to_sections', ['news_id'=>'id']);

    }


}