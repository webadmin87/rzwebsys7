<?php

namespace app\modules\news\models\meta;

use common\db\MetaFields;
use Yii;

/**
 * Class NewsSectionMeta
 * Мета описание модели категорий новостей
 * @package app\modules\news\models\meta
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class NewsSectionMeta extends MetaFields
{

    const SEO_TAB = "seo";

    /**
     * @inheritdoc
     */

    public function tabs()
    {
        $tabs = parent::tabs();
        $tabs[self::SEO_TAB] = Yii::t('news/app', "SEO");
        return $tabs;
    }

    /**
     * @inheritdoc
     */

    protected function config()
    {
        return [

            "parent_id" => [
                "definition" => [
                    "class" => \common\db\fields\ParentListField::className(),
                    "title" => Yii::t('main/app', 'Parent'),
                    "data" => [$this->owner, 'getListTreeData'],
                ],
                "params" => [$this->owner, "parent_id"]
            ],

            "title" => [
                "definition" => [
                    "class" => \common\db\fields\TextField::className(),
                    "title" => Yii::t('news/app', 'Title'),
                    "isRequired" => true,
                    "editInGrid" => true,
                ],
                "params" => [$this->owner, "title"]
            ],

            "code" => [
                "definition" => [
                    "class" => \common\db\fields\CodeField::className(),
                    "title" => Yii::t('news/app', 'Code'),
                    "isRequired" => true,
                    "generateFrom" => "title",
                ],
                "params" => [$this->owner, "code"]
            ],

            "metatitle" => [
                "definition" => [
                    "class" => \common\db\fields\TextField::className(),
                    "title" => Yii::t('news/app', 'Meta title'),
                    "isRequired" => false,
                    "showInGrid" => false,
                    "tab" => self::SEO_TAB,
                ],
                "params" => [$this->owner, "metatitle"]
            ],

            "keywords" => [
                "definition" => [
                    "class" => \common\db\fields\TextField::className(),
                    "title" => Yii::t('news/app', 'Keywords'),
                    "isRequired" => false,
                    "showInGrid" => false,
                    "tab" => self::SEO_TAB,
                ],
                "params" => [$this->owner, "keywords"]
            ],

            "description" => [
                "definition" => [
                    "class" => \common\db\fields\TextField::className(),
                    "title" => Yii::t('news/app', 'Description'),
                    "isRequired" => false,
                    "showInGrid" => false,
                    "tab" => self::SEO_TAB,
                ],
                "params" => [$this->owner, "description"]
            ],

        ];
    }

}