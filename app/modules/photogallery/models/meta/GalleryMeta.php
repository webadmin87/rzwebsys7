<?php

namespace app\modules\photogallery\models\meta;

use Yii;
use common\db\MetaFields;

/**
 * Class GalleryMeta
 * Мета - описание фотогалереи
 * @package app\modules\photogallery\models\meta
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class GalleryMeta extends MetaFields
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
                    "title" => Yii::t('photogallery/app', 'Title'),
                    "isRequired" => true,
                    "editInGrid" => true,
                ],
                "params" => [$this->owner, "title"]
            ],

            "code" => [
                "definition" => [
                    "class" => \common\db\fields\CodeField::className(),
                    "title" => Yii::t('photogallery/app', 'Code'),
                    "isRequired" => true,
                    "showInGrid" => false,
                ],
                "params" => [$this->owner, "code"]
            ],

            "image" => [
                "definition" => [
                    "class" => \common\db\fields\Html5ImageField::className(),
                    "title" => Yii::t('photogallery/app', 'Image'),
                    "isRequired" => false,
                ],
                "params" => [$this->owner, "image"]
            ],

            "text" => [
                "definition" => [
                    "class" => \common\db\fields\HtmlField::className(),
                    "title" => Yii::t('photogallery/app', 'Text'),
                    "isRequired" => false,
                ],
                "params" => [$this->owner, "text"]
            ],

            "sort" => [
                "definition" => [
                    "class" => \common\db\fields\NumberField::className(),
                    "title" => Yii::t('photogallery/app', 'Sort'),
                    "isRequired" => false,
                    "editInGrid" => true,
                    "defaultValue" => 500,
                ],
                "params" => [$this->owner, "sort"]
            ],

        ];
    }

}