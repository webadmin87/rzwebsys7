<?php
namespace app\modules\main\models;

use Yii;
use common\db\TActiveRecord;

/**
 * Class Menu
 * Модель меню
 * @package app\modules\main\models
 * @author Churkin Anton <webadmin87@gmail.com>
 */

class Menu extends TActiveRecord {

    use \app\modules\main\components\PermissionTrait;

    const TARGET_SELF = "_self";

    const TARGET_BLANK = "_blank";

    /**
     * Возвращает список значений для атрибута target
     * @return array
     */

    public static function targetsList() {

        return [

            self::TARGET_SELF => Yii::t('main/app', 'Self window'),
            self::TARGET_BLANK => Yii::t('main/app', 'Blank window')

        ];

    }

    /**
     * @inheritdoc
     */

    public static function tableName() {
        return "menu";
    }

    /**
     * @inheritdoc
     */
    public function metaClass() {
        return meta\MenuMeta::className();
    }

    /**
     * Определяет является ли пункт меню активным
     * @return bool
     */

    public function isAct() {

        if(empty($this->link))
            return false;

        $request = Yii::$app->request;

        // Главная

        if($this->link == "/") {

            if(empty($request->pathinfo))
                return true;

        } else {

            $pathinfo = "/".$request->pathinfo."/";

            if(strpos($pathinfo, $this->link) === 0)
                return true;

        }

        return false;

    }

}