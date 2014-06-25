<?php

namespace app\modules\main\models\meta;

use Yii;
use common\db\MetaFields;

/**
 * Class CommentsMeta
 * Мета описание модели комментариев
 * @package app\modules\main\models
 * @author Churkin Anton <webadmin87@gmail.com>
 */

class CommentsMeta extends MetaFields {

    /**
     * @inheritdoc
     */

    protected function config()
    {
        return [


            "username" => [
                "definition" => [
                    "class" => \common\db\fields\TextField::className(),
                    "title" => Yii::t('main/app', 'Username'),
                    "isRequired" => true,
                ],
                "params" => [$this->owner, "username"]
            ],

            "email" => [
                "definition" => [
                    "class" => \common\db\fields\EmailField::className(),
                    "title" => Yii::t('main/app', 'Email'),
                    "isRequired" => false,
                ],
                "params" => [$this->owner, "email"]
            ],

            "text" => [
                "definition" => [
                    "class" => \common\db\fields\MarkItUpField::className(),
                    "title" => Yii::t('main/app', 'Comment'),
                    "isRequired" => true,
                ],
                "params" => [$this->owner, "text"]
            ],

            "model" => [
                "definition" => [
                    "class" => \common\db\fields\TextField::className(),
                    "title" => Yii::t('main/app', 'Model class'),
                    "isRequired" => true,
                ],
                "params" => [$this->owner, "model"]
            ],

            "item_id" => [
                "definition" => [
                    "class" => \common\db\fields\NumberField::className(),
                    "title" => Yii::t('main/app', 'Item id'),
                    "isRequired" => true,
                ],
                "params" => [$this->owner, "item_id"]
            ],

        ];
    }


}