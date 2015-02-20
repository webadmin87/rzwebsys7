<?php
namespace app\modules\main\models;

use common\components\Match;
use common\db\ActiveRecord;
use Yii;

/**
 * Class Template
 * Модель шаблона
 * @package app\modules\main\models
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class Template extends ActiveRecord
{

    /**
     * Возвращает массив условий подклбчений шаблона
     * @return array
     */

    public static function getConds()
    {

        return [

            Match::COND_NO => Yii::t("main/app", "No condition"),
            Match::COND_URL => Yii::t("main/app", "Url condition"),
            Match::COND_PHP => Yii::t("main/app", "Php condition"),
            Match::COND_ROUTE => Yii::t("main/app", "Route condition"),

        ];

    }

    /**
     * @inheritdoc
     */

    public static function tableName()
    {
        return "templates";
    }

    /**
     * @inheritdoc
     */

    public function behaviors()
    {
        $arr = parent::behaviors();

        $arr["matchSuitable"] = \common\behaviors\MatchSuitable::className();

        return $arr;

    }

    /**
     * @inheritdoc
     */

    public function rules()
    {

        $rules = parent::rules();

        $rules[] = ['sort', 'default', 'value' => ActiveRecord::DEFAULT_SORT];

        return $rules;

    }

    /**
     * @inheritdoc
     */
    public function metaClass()
    {
        return meta\TemplatesMeta::className();
    }

}