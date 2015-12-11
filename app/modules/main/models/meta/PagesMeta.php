<?php
namespace app\modules\main\models\meta;

use common\db\MetaFields;
use Yii;

/**
 * Class PagesMeta
 * Описание полей модели Pages
 * @package app\modules\main\models\meta
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class PagesMeta extends MetaFields
{

    const SEO_TAB = "seo";

    const IMAGE_TAB = "image";

    /**
     * @inheritdoc
     */

    public function config()
    {

        return [

            "comments" => [
                "definition" => [
                    "class" => \common\db\fields\CheckBoxField::className(),
                    "title" => Yii::t('main/app', 'Comments'),
                    "isRequired" => false,
                ],
                "params" => [$this->owner, "comments"]
            ],

            "parent_id" => [
                "definition" => [
                    "class" => \common\db\fields\ParentListField::className(),
                    "title" => Yii::t('main/app', 'Parent'),
                    "data" =>[$this->owner, "getListTreeData"],
                ],
                "params" => [$this->owner, "parent_id"]
            ],

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
                    "class" => \common\db\fields\CodeField::className(),
                    "title" => Yii::t('main/app', 'Code'),
                    "isRequired" => true,
                    "generateFrom" => "title",
                    "uniqueValidatorClassName"=>TreeUniqueValidator::className(),
                ],
                "params" => [$this->owner, "code"]
            ],

            "text" => [
                "definition" => [
                    "class" => \common\db\fields\HtmlField::className(),
                    "title" => Yii::t('main/app', 'Text'),
                    "isRequired" => false,
                ],
                "params" => [$this->owner, "text"]
            ],

            "metatitle" => [
                "definition" => [
                    "class" => \common\db\fields\TextField::className(),
                    "title" => Yii::t('main/app', 'Meta title'),
                    "isRequired" => false,
                    "showInGrid" => false,
                    "tab" => self::SEO_TAB,
                ],
                "params" => [$this->owner, "metatitle"]
            ],

            "keywords" => [
                "definition" => [
                    "class" => \common\db\fields\TextField::className(),
                    "title" => Yii::t('main/app', 'Keywords'),
                    "isRequired" => false,
                    "showInGrid" => false,
                    "tab" => self::SEO_TAB,
                ],
                "params" => [$this->owner, "keywords"]
            ],

            "description" => [
                "definition" => [
                    "class" => \common\db\fields\TextField::className(),
                    "title" => Yii::t('main/app', 'Description'),
                    "isRequired" => false,
                    "showInGrid" => false,
                    "tab" => self::SEO_TAB,
                ],
                "params" => [$this->owner, "description"]
            ],

            "image" => [
                "definition" => [
                    "class" => \common\db\fields\Html5ImageField::className(),
                    "title" => Yii::t('main/app', 'Image'),
                    "isRequired" => false,
                    "tab" => self::IMAGE_TAB,
                ],
                "params" => [$this->owner, "image"]
            ],

        ];

    }

    /**
     * @inheritdoc
     */

    public function tabs()
    {
        $tabs = parent::tabs();
        $tabs[self::SEO_TAB] = Yii::t('main/app', "SEO");
        $tabs[self::IMAGE_TAB] = Yii::t('main/app', "Image");
        return $tabs;
    }

}