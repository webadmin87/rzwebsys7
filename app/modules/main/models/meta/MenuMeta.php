<?php
namespace app\modules\main\models\meta;

use \Yii;
use common\db\MetaFields;

/**
 * Class MenuMeta
 * Описание полей модели Menu
 * @package app\modules\main\models\meta
 * @author Churkin Anton <webadmin87@gmail.com>
 */

class MenuMeta extends MetaFields
{

    /**
     * @inheritdoc
     */

    public function config()
    {

        return [

            "parent_id" => [
                "definition" => [
                    "class" => \common\db\fields\ParentListField::className(),
                    "title" => Yii::t('main/app', 'Parent'),
                    "data" => function(){ return $this->owner->getListTreeData(); },
                ],
                "params" => [$this->owner, "parent_id"]
            ],

            "title" => [
                "definition" => [
                    "class" => \common\db\fields\TextField::className(),
                    "title" => Yii::t('main/app', 'Title'),
                    "isRequired" => true,
                    "editInGrid"=>true,
                ],
                "params" => [$this->owner, "title"]
            ],

            "code" => [
                "definition" => [
                    "class" => \common\db\fields\CodeField::className(),
                    "title" => Yii::t('main/app', 'Code'),
                    "isRequired" => false,
                    "editInGrid"=>true,
                ],
                "params" => [$this->owner, "code"]
            ],

            "link" => [
                "definition" => [
                    "class" => \common\db\fields\TextField::className(),
                    "title" => Yii::t('main/app', 'Link'),
                    "isRequired" => false,
                    "editInGrid"=>true,
                ],
                "params" => [$this->owner, "link"]
            ],

            "class" => [
                "definition" => [
                    "class" => \common\db\fields\TextField::className(),
                    "title" => Yii::t('main/app', 'Css class'),
                    "isRequired" => false,
                    "showInGrid"=>false,
                ],
                "params" => [$this->owner, "class"]
            ],

            "target" => [
                "definition" => [
                    "class" => \common\db\fields\ListField::className(),
                    "title" => Yii::t('main/app', 'Target'),
                    "isRequired" => false,
                    "showInGrid"=>false,
                    "data"=>function(){ return $this->owner->targetsList(); },
                ],
                "params" => [$this->owner, "target"]
            ],



        ];

    }

}