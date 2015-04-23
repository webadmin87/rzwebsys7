<?php
namespace app\modules\main\models;

use common\db\ActiveRecord;
use common\db\TActiveRecord;
use Yii;
use yii\db\Query;
use yii\helpers\ArrayHelper;

/**
 * Class Comments
 * Модель комментариев
 * @package app\modules\main\models
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class Comments extends TActiveRecord
{

    const VERIFY_CODE = "fcfd5a664144ae35c6eafca228de66e3";

    /**
     * @var string значение капчи
     */

    public $verifyCode;

    /**
     * @inheritdoc
     */

    public static function tableName()
    {
        return "comments";
    }

    /**
     * @inheritdoc
     */

    public function rules()
    {

        $rules = parent::rules();

        $rules[] = ['verifyCode', 'compare', 'skipOnEmpty' => false, 'compareValue' => self::VERIFY_CODE,
            'when' => function ($model, $attribute) {
                return Yii::$app->user->isGuest;
            }];

        return $rules;

    }

    /**
     * @inheritdoc
     */

    public function init()
    {

        parent::init();

        if ($this->isNewRecord AND $this->scenario == ActiveRecord::SCENARIO_INSERT AND !Yii::$app->user->isGuest) {

            $this->username = Yii::$app->user->identity->username;
            $this->email = Yii::$app->user->identity->email;

        }

    }

    /**
     * @inheritdoc
     */
    public function metaClass()
    {
        return meta\CommentsMeta::className();
    }

    /**
     * Возвращает количество вложенных комментариев
     * @return int
     */
    public function getChildrenCount() {

        return $this->children()->orderBy(false)->count();

    }

    /**
     * Возвращает массив классов моделей для которых существую комментарии
     * @return array
     */
    public function getClasses()
    {

        $res = (new Query())->select("model")->from(static::tableName())->where([">", "level", TActiveRecord::ROOT_ID])->groupBy("model")->all();

        return ArrayHelper::map($res, "model", function($data){

            $cls = $data["model"];

            if(class_exists($cls))
                return $cls::getEntityName();
            else
                return false;

        });

    }

}