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
                    "title" => Yii::t('main/app', 'Role'),
                    "isRequired" => true,
                    "data" => function() { return $this->owner->getRolesNames(); },
                ],
                "params" => [$this->owner, "role"]
            ],

            "username" => [
                "definition" => [
                    "class" => \common\db\fields\TextField::className(),
                    "title" => Yii::t('main/app', 'Username'),
                    "isRequired" => true,
                ],
                "params" => [$this->owner, "username"]
            ],

            "password" => [
                "definition" => [
                    "class" => \common\db\fields\PasswordField::className(),
                    "title" => Yii::t('main/app', 'Password'),
                    "isRequired" => false,
                    "showInGrid" => false,
                    "showInView" => false,
                ],
                "params" => [$this->owner, "password"]
            ],

            "confirm_password" => [
                "definition" => [
                    "class" => \common\db\fields\PasswordField::className(),
                    "title" => Yii::t('main/app', 'Confirm password'),
                    "isRequired" => false,
                    "showInGrid" => false,
                    "showInView" => false,
                ],
                "params" => [$this->owner, "confirm_password"]
            ],


            "email" => [
                "definition" => [
                    "class" => \common\db\fields\EmailField::className(),
                    "title" => Yii::t('main/app', 'Email'),
                    "isRequired" => true,
                ],
                "params" => [$this->owner, "email"]
            ],

            "name" => [
                "definition" => [
                    "class" => \common\db\fields\TextField::className(),
                    "title" => Yii::t('main/app', 'Name'),
                    "isRequired" => false,
                ],
                "params" => [$this->owner, "name"]
            ],

            "image" => [
                "definition" => [
                    "class" => \common\db\fields\Html5ImageField::className(),
                    "title" => Yii::t('main/app', 'Image'),
                    "isRequired" => false,
                ],
                "params" => [$this->owner, "image"]
            ],

            "text" => [
                "definition" => [
                    "class" => \common\db\fields\TextAreaField::className(),
                    "title" => Yii::t('main/app', 'Text'),
                    "isRequired" => false,
                ],
                "params" => [$this->owner, "text"]
            ],


        ];

    }

}