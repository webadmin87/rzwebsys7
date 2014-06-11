<?php
namespace app\modules\main\models\meta;

use \Yii;
use common\db\MetaFields;

/**
 * Class PagesMeta
 * Описание полей модели Pages
 * @package app\modules\main\models\meta
 * @author Churkin Anton <webadmin87@gmail.com>
 */

class PagesMeta extends MetaFields
{

    /**
     * @inheritdoc
     */

    public function config()
    {

        return [

            "parent_id" => [
                "definition" => [
                    "class" => \common\db\fields\ListField::className(),
                    "title" => Yii::t('core', 'Parent'),
                    "isRequired" => true,
                    "showInGrid"=>false,
                    "showInExtendedFilter"=>false,
                    "search"=>false,
                    "data" => function(){ return $this->owner->getListTreeData(); },
                ],
                "params" => [$this->owner, "parent_id"]
            ],

            "title" => [
                "definition" => [
                    "class" => \common\db\fields\TextField::className(),
                    "title" => Yii::t('core', 'Title'),
                    "isRequired" => true,
                ],
                "params" => [$this->owner, "title"]
            ],

            "code" => [
                "definition" => [
                    "class" => \common\db\fields\CodeField::className(),
                    "title" => Yii::t('core', 'Code'),
                    "isRequired" => true,
                ],
                "params" => [$this->owner, "code"]
            ],

            "text" => [
                "definition" => [
                    "class" => \common\db\fields\HtmlField::className(),
                    "title" => Yii::t('core', 'Text'),
                    "isRequired" => false,
                ],
                "params" => [$this->owner, "text"]
            ],


        ];

    }

}