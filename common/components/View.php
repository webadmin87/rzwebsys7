<?php
namespace common\components;

use yii\web\View as YiiView;

/**
 * Class View
 * Расширяем функционал стандартного представления
 * @package common\components
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class View extends YiiView
{

    /**
     * @var array массив хлебных крошек для виджета yii\widgets\Breadcrumbs
     * @link http://www.yiiframework.com/doc-2.0/yii-widgets-breadcrumbs.html
     */

    public $breadCrumbs = [];

    /**
     * Добавляет элемент к хлебным крошкам
     * @param array $item
     * @link http://www.yiiframework.com/doc-2.0/yii-widgets-breadcrumbs.html
     */

    public function addBreadCrumb($item)
    {

        $this->breadCrumbs = array_merge($this->breadCrumbs, $item);

    }

    /**
     * Регистрирует мета-теги
     * @param \common\db\ActiveRecord $model
     */

    public function registerMetaTags($model)
    {

        if ($model->hasAttribute("metatitle"))
            $this->title = $model->metatitle;
        elseif ($model->hasAttribute("title"))
            $this->title = $model->title;

        if ($model->hasAttribute("keywords"))
            $this->registerMetaTag(["name" => "keywords", "content" => $model->keywords]);

        if ($model->hasAttribute("description"))
            $this->registerMetaTag(["name" => "description", "content" => $model->description]);

    }

}