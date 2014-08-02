<?php

namespace app\modules\main\models\meta;

use Yii;
use common\db\MetaFields;

/**
 * Class ConfigMeta
 * Мета описание модели конфига
 * @package app\modules\main\models
 * @author Churkin Anton <webadmin87@gmail.com>
 */

class ConfigMeta extends MetaFields {

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
                    "isRequired" => false,
                ],
                "params" => [$this->owner, "title"]
            ],


            "key" => [
                "definition" => [
                    "class" => \common\db\fields\TextField::className(),
                    "title" => Yii::t('main/app', 'Key'),
                    "isRequired" => false,
                ],
                "params" => [$this->owner, "key"]
            ],

            "value" => [
                "definition" => [
                    "class" => \common\db\fields\TextField::className(),
                    "title" => Yii::t('main/app', 'Value'),
                    "isRequired" => false,
                ],
                "params" => [$this->owner, "value"]
            ],



        ];
    }

    /**
     * @inheritdoc
     */

    protected function defaultConfig()
    {
        $arr =  parent::defaultConfig();

        $arr['active']['definition']['showInTableInput'] = false;

        $arr['author_id']['definition']['showInTableInput'] = false;

        return $arr;
    }


}