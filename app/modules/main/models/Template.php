<?php
namespace app\modules\main\models;

use Yii;
use common\db\ActiveRecord;

/**
 * Class Template
 * Модель шаблона
 * @package app\modules\main\models
 * @author Churkin Anton <webadmin87@gmail.com>
 */

class Template extends ActiveRecord {

    /**
     * Константы условий подключения шаблонов
     */

    const COND_NO = 0;

    const COND_URL = 1;

    const COND_PHP = 2;


    /**
     * Возвращает массив условий подклбчений шаблона
     * @return array
     */

    public static function getConds() {

        return [

            self::COND_NO => Yii::t("main/app", "No condition"),
            self::COND_URL => Yii::t("main/app", "Url condition"),
            self::COND_PHP => Yii::t("main/app", "Php condition"),

        ];

    }


    /**
     * @inheritdoc
     */

    public static function tableName() {
        return "templates";
    }

    /**
     * @inheritdoc
     */
    public function metaClass() {
        return meta\TemplatesMeta::className();
    }

}