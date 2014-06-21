<?php
namespace common\components;

use yii\web\View AS YiiView;

class View extends YiiView {

    /**
     * Регистрирует мета-теги
     * @param \common\db\ActiveRecord $model
     */

    public function registerMetaTags($model) {

        if($model->hasAttribute("metatitle"))
            $this->title = $model->metatitle;

        if($model->hasAttribute("keywords"))
            $this->registerMetaTag(["name"=>"keywords", "content"=>$model->keywords]);

        if($model->hasAttribute("description"))
            $this->registerMetaTag(["name"=>"keywords", "content"=>$model->description]);

    }



}