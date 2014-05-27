<?php
namespace app\modules\main\models\meta;

use \Yii;
use common\db\MetaFields;

/**
 * Class UserMeta
 * Описание полей модеди User
 * @package app\modules\main\models\meta
 * @author Churkin Anton <webadmin87@gmail.com>
 */

class UserMeta extends MetaFields
{

    /**
     * @inheritdoc
     */

    public function config()
    {

        return [


            "role" => [
                "definition" => [
                    "class" => \common\db\fields\ListField::className(),
                    "title" => Yii::t('core', 'Role'),
                    "isRequired" => true,
                    "data" => function() { return $this->owner->getRolesNames(); },
                ],
                "params" => [$this->owner, "role"]
            ],

            "username" => [
                "definition" => [
                    "class" => \common\db\fields\TextField::className(),
                    "title" => Yii::t('core', 'Username'),
                    "isRequired" => true,
                ],
                "params" => [$this->owner, "username"]
            ],

            "password" => [
                "definition" => [
                    "class" => \common\db\fields\PasswordField::className(),
                    "title" => Yii::t('core', 'Password'),
                    "isRequired" => false,
                    "showInGrid" => false,
                    "showInView" => false,
                ],
                "params" => [$this->owner, "password"]
            ],

            "confirm_password" => [
                "definition" => [
                    "class" => \common\db\fields\PasswordField::className(),
                    "title" => Yii::t('core', 'Confirm password'),
                    "isRequired" => false,
                    "showInGrid" => false,
                    "showInView" => false,
                ],
                "params" => [$this->owner, "confirm_password"]
            ],


            "email" => [
                "definition" => [
                    "class" => \common\db\fields\EmailField::className(),
                    "title" => Yii::t('core', 'Email'),
                    "isRequired" => true,
                ],
                "params" => [$this->owner, "email"]
            ],

            "image" => [
                "definition" => [
                    "class" => \common\db\fields\Html5ImageField::className(),
                    "title" => Yii::t('core', 'Image'),
                    "isRequired" => false,
                ],
                "params" => [$this->owner, "image"]
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