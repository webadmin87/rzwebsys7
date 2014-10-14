<?php
namespace app\modules\shop\models;

use Yii;
use common\db\ActiveRecord;

/**
 * Class Status
 * Модель статуса заказа
 * @package app\modules\shop\models
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class Status extends ActiveRecord
{

    use \app\modules\main\components\PermissionTrait;

    /**
     * @var string шаблон письма
     */
    public $tplHtml;

	/**
     * @inheritdoc
     */

    public static function tableName()
    {
        return "shop_status";
    }

    /**
     * @return string возвращает имя файла шаблона
     */
    public function getTplName()
    {
        return "status-{$this->tpl}.php";
    }

    /**
     * @inheritdoc
     */
    public function metaClass()
    {
        return meta\StatusMeta::className();
    }

    /**
     * @inheritdoc
     * @return \app\modules\shop\db\StatusQuery
     */
    public static  function find()
    {
        return Yii::createObject(\app\modules\shop\db\StatusQuery::className(), [get_called_class()]);
    }

    /**
     * @inheritdoc
     * сохраняем шаблон письма
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        Yii::$app->getModule('shop')->orderLetters->saveStatusTpl($this);

    }

    /**
     * @inheritdoc
     * загружаем шаблон письма
     */
    public function afterFind()
    {
        parent::afterFind();

        Yii::$app->getModule('shop')->orderLetters->loadStatusTpl($this);

    }


}