<?php

namespace app\modules\main\models\meta;

use Yii;
use common\db\MetaFields;

/**
 * Class IncludesMeta
 * Мета описание модели включаемой области
 * @package app\modules\main\models
 * @author Churkin Anton <webadmin87@gmail.com>
 */

class IncludesMeta extends MetaFields {

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
                    "class" => \common\db\fields\CodeField::className(),
                    "title" => Yii::t('main/app', 'Code'),
                    "isRequired" => true,
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

        ];
    }


}