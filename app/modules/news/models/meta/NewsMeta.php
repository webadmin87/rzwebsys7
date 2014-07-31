<?php

namespace app\modules\news\models\meta;

use app\modules\news\models\NewsSection;
use Yii;
use common\db\MetaFields;

/**
 * Class NewsMeta
 * Мета описание модели новостей
 * @package app\modules\news\models\meta
 * @author Churkin Anton <webadmin87@gmail.com>
 */

class NewsMeta extends MetaFields {

    const SEO_TAB = "seo";

    /**
     * @inheritdoc
     */

    protected function config()
    {
        return [

            "sections" => [
                "definition" => [
                    "class" => \common\db\fields\ManyManyField::className(),
                    "title" => Yii::t('news/app', 'News sections'),
                    "isRequired" => true,
                    "data" => function(){
                        $model = \Yii::createObject(NewsSection::className());
                        return $model->getDataByParent();
                    },
                ],
                "params" => [$this->owner, "sectionsIds", "sections"]
            ],


            "title" => [
                "definition" => [
                    "class" => \common\db\fields\TextField::className(),
                    "title" => Yii::t('news/app', 'Title'),
                    "isRequired" => true,
                    "editInGrid"=>true,
                ],
                "params" => [$this->owner, "title"]
            ],

            "code" => [
                "definition" => [
                    "class" => \common\db\fields\CodeField::className(),
                    "title" => Yii::t('news/app', 'Code'),
                    "isRequired" => true,
                    "showInGrid"=>false,
                ],
                "params" => [$this->owner, "code"]
            ],

            "comments" => [
                "definition" => [
                    "class" => \common\db\fields\CheckBoxField::className(),
                    "title" => Yii::t('news/app', 'Comments'),
                    "isRequired" => false,
                ],
                "params" => [$this->owner, "comments"]
            ],

            "date" => [
                "definition" => [
                    "class" => \common\db\fields\DateField::className(),
                    "title" => Yii::t('news/app', 'Date'),
                    "isRequired" => false,
                    "editInGrid"=>true,
                ],
                "params" => [$this->owner, "date"]
            ],

            "image" => [
                "definition" => [
                    "class" => \common\db\fields\Html5ImageField::className(),
                    "title" => Yii::t('news/app', 'Image'),
                    "isRequired" => false,
                ],
                "params" => [$this->owner, "image"]
            ],

            "annotation" => [
                "definition" => [
                    "class" => \common\db\fields\TextAreaField::className(),
                    "title" => Yii::t('news/app', 'Annotation'),
                    "isRequired" => false,
                ],
                "params" => [$this->owner, "annotation"]
            ],

            "text" => [
                "definition" => [
                    "class" => \common\db\fields\HtmlField::className(),
                    "title" => Yii::t('news/app', 'Text'),
                    "isRequired" => false,
                ],
                "params" => [$this->owner, "text"]
            ],

            "metatitle" => [
                "definition" => [
                    "class" => \common\db\fields\TextField::className(),
                    "title" => Yii::t('news/app', 'Meta title'),
                    "isRequired" => false,
                    "showInGrid"=>false,
                    "tab"=>self::SEO_TAB,
                ],
                "params" => [$this->owner, "metatitle"]
            ],

            "keywords" => [
                "definition" => [
                    "class" => \common\db\fields\TextField::className(),
                    "title" => Yii::t('news/app', 'Keywords'),
                    "isRequired" => false,
                    "showInGrid"=>false,
                    "tab"=>self::SEO_TAB,
                ],
                "params" => [$this->owner, "keywords"]
            ],

            "description" => [
                "definition" => [
                    "class" => \common\db\fields\TextField::className(),
                    "title" => Yii::t('news/app', 'Description'),
                    "isRequired" => false,
                    "showInGrid"=>false,
                    "tab"=>self::SEO_TAB,
                ],
                "params" => [$this->owner, "description"]
            ],



        ];
    }

    /**
     * @inheritdoc
     */

    public function tabs()
    {
        $tabs = parent::tabs();
        $tabs[self::SEO_TAB]=Yii::t('news/app', "SEO");
        return $tabs;
    }


}