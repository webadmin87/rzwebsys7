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

    /**
     * Подключать ли данный шаблон
     * @return bool
     */

    public function isSuitable() {

        if(empty($this->cond_type))
            return true;
        else {

            $match = $this->getMatch();

            if($match)
                return $match->test($this->cond);
            else
                return false;
        }


    }

    /**
     * Возвращает объект для проверки условия подключения шаблона. False в случае ошибки
     * @return bool|\common\components\IMatch
     */

    public function getMatch() {

        if($this->cond_type == self::COND_PHP)
            return Yii::createObject(\common\components\PhpMatch::className());
        elseif($this->cond_type == self::COND_URL)
            return Yii::createObject(\common\components\UrlMatch::className());
        else
            return false;
    }

}