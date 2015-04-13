<?php
namespace app\modules\photogallery\models;

use common\db\ActiveRecord;
use Yii;
use yii\data\ActiveDataProvider;

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

    /**
     * Возвращает провайдер данных для отображения списка фотогалерей в публичной части
     * @return \yii\data\ActiveDataProvider
     * @throws \yii\base\InvalidConfigException
     */
    public function publicSearch()
    {

        $query = $this->find()->published();

        $dataProvider = Yii::createObject([
            'class' => ActiveDataProvider::className(),
            "query" => $query,
        ]);

        return $dataProvider;

    }

}