<?php

namespace app\modules\main\models\meta;

use app\modules\main\models\Includes;
use common\db\ActiveQuery;
use Yii;
use common\db\MetaFields;
use yii\helpers\ArrayHelper;
use common\db\ActiveRecord;

/**
 * Class IncludeGroupMeta
 * Мета описание группы включаемых областей
 * @package app\modules\main\models\meta
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class IncludeGroupMeta extends MetaFields
{
    /**
     * @inheritdoc
     */

    protected function config()
    {
        return [

            "title" => [
                "definition" => [
                    "class" => \common\db\fields\TextField::className(),
                    "title" => Yii::t('main/app', 'Title'),
                    "isRequired" => true,
                    "editInGrid" => true,
                ],
                "params" => [$this->owner, "title"]
            ],

            "code" => [
                "definition" => [
                    "class" => \common\db\fields\TextField::className(),
                    "title" => Yii::t('main/app', 'Code'),
                    "isRequired" => true,
                    "editInGrid" => true,
                ],
                "params" => [$this->owner, "code"]
            ],

            "cond_type" => [
                "definition" => [
                    "class" => \common\db\fields\ListField::className(),
                    "title" => Yii::t('main/app', 'Condition type'),
                    "isRequired" => true,
                    "showInGrid" => false,
                    "data" =>["\\app\\modules\\main\\models\\Template", "getConds"],
                ],
                "params" => [$this->owner, "cond_type"]
            ],

            "cond" => [
                "definition" => [
                    "class" => \common\db\fields\TextField::className(),
                    "title" => Yii::t('main/app', 'Condition'),
                    "isRequired" => false,
                    "showInGrid" => false,
                ],
                "params" => [$this->owner, "cond"]
            ],

            "sort" => [
                "definition" => [
                    "class" => \common\db\fields\TextField::className(),
                    "title" => Yii::t('main/app', 'Sort'),
                    "defaultValue" => ActiveRecord::DEFAULT_SORT,
                    "isRequired" => false,
                    "editInGrid" => true,
                ],
                "params" => [$this->owner, "sort"]
            ],

            "includesIdsStr" => [
                "definition" => [
                    "class" => \common\db\fields\ManyManySortField::className(),
                    "title" => Yii::t('main/app', 'Includes'),
                    "data" => [$this, "getIncludesList"],
                ],
                "params" => [$this->owner, "includesIdsStr", "includes"]
            ],

        ];
    }

    /**
     * Список включаемых областей
     * @return array
     */
    public function getIncludesList()
    {

        $models = Includes::find()->orderBy(["title"=>SORT_ASC])->all();

        return ArrayHelper::map($models, "id", "title");

    }

}