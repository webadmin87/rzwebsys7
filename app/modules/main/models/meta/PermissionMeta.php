<?php

namespace app\modules\main\models\meta;

use Yii;
use common\db\MetaFields;

/**
 * Class PermissionMeta
 * Мета описание модели прав доступа
 * @package app\modules\main\models
 * @author Churkin Anton <webadmin87@gmail.com>
 */

class PermissionMeta extends MetaFields {

    /**
     * @inheritdoc
     */

    protected function config()
    {
        return [


            "model" => [
                "definition" => [
                    "class" => \common\db\fields\TextField::className(),
                    "title" => Yii::t('main/app', 'Model class'),
                    "isRequired" => true,
                    "editInGrid"=>true,
                ],
                "params" => [$this->owner, "model"]
            ],

            "role" => [
                "definition" => [
                    "class" => \common\db\fields\ListField::className(),
                    "title" => Yii::t('main/app', 'Role'),
                    "isRequired" => true,
                    "data" => function() { return \app\modules\main\models\User::getRolesNames(); },
                    "editInGrid"=>true,
                ],
                "params" => [$this->owner, "role"]
            ],

            "create" => [
                "definition" => [
                    "class" => \common\db\fields\CheckBoxField::className(),
                    "title" => Yii::t('main/app', 'Create'),
                    "editInGrid"=>true,
                ],
                "params" => [$this->owner, "create"]
            ],

            "read" => [
                "definition" => [
                    "class" => \common\db\fields\CheckBoxField::className(),
                    "title" => Yii::t('main/app', 'Read'),
                    "editInGrid"=>true,
                ],
                "params" => [$this->owner, "read"]
            ],

            "update" => [
                "definition" => [
                    "class" => \common\db\fields\CheckBoxField::className(),
                    "title" => Yii::t('main/app', 'Update'),
                    "editInGrid"=>true,
                ],
                "params" => [$this->owner, "update"]
            ],

            "delete" => [
                "definition" => [
                    "class" => \common\db\fields\CheckBoxField::className(),
                    "title" => Yii::t('main/app', 'Delete'),
                    "editInGrid"=>true,
                ],
                "params" => [$this->owner, "delete"]
            ],

            "constraint" => [
                "definition" => [
                    "class" => \common\db\fields\TextField::className(),
                    "title" => Yii::t('main/app', 'Constraint class'),
                    "editInGrid"=>true,
                ],
                "params" => [$this->owner, "constraint"]
            ],

            "forbidden_attrs" => [
                "definition" => [
                    "class" => \common\db\fields\TextAreaField::className(),
                    "title" => Yii::t('main/app', 'Forbidden attributes'),
                    "editInGrid"=>true,
                ],
                "params" => [$this->owner, "forbidden_attrs"]
            ],




        ];
    }


}