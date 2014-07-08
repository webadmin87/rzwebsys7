<?php
namespace common\components;

use yii\web\AssetBundle AS YiiBundle;

/**
 * Class AssetBundle
 * Добавлена возможность подключения минифицированного кода в зависимости от окружения
 * @package common\components
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class AssetBundle extends YiiBundle {

    /**
     * @var array минифицированный js
     */

    public $jsMin = [];

    /**
     * @var array минифицированный css
     */

    public $cssMin = [];

    /**
     * Заменяем ассеты на минифицированные
     * @inheritdoc
     */

    public function init() {

        if(!YII_DEBUG AND !empty($this->jsMin))
            $this->js = $this->jsMin;

        if(!YII_DEBUG AND !empty($this->cssMin))
            $this->css = $this->cssMin;

        parent::init();

    }

}