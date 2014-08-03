<?php

namespace app\modules\main\models\meta;

use common\db\MetaFields;
use Yii;

/**
 * Class TemplatesMeta
 * Мета описание модели шаблонов
 * @package app\modules\main\models
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class TemplatesMeta extends MetaFields
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
                ],
                "params" => [$this->owner, "title"]
            ],

            "code" => [
                "definition" => [
                    "class" => \common\db\fields\TextField::className(),
                    "title" => Yii::t('main/app', 'Code'),
                    "isRequired" => true,
                ],
                "params" => [$this->owner, "code"]
            ],

            "cond_type" => [
                "definition" => [
                    "class" => \common\db\fields\ListField::className(),
                    "title" => Yii::t('main/app', 'Condition type'),
                    "isRequired" => true,
                    "showInGrid" => false,
                    "data" =>[$this->owner, "getConds"],
                ],
                "params" => [$this->owner, "cond_type"]
            ],

            "cond" => [
                "definition" => [
                    "class" => \common\db\fields\CodeField::className(),
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
                    "isRequired" => false,
                    "editInGrid" => true,
                ],
                "params" => [$this->owner, "sort"]
            ],

            "text" => [
                "definition" => [
                    "class" => \common\db\fields\HtmlField::className(),
                    "title" => Yii::t('main/app', 'Text'),
                    "isRequired" => false,
                ],
                "params" => [$this->owner, "text"]
            ],

        ];
    }

}