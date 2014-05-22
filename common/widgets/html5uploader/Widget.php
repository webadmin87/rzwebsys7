<?php

namespace common\widgets\html5uploader;

use yii\widgets\InputWidget;
use yii\helpers\Html;

/**
 * Class Widget
 * Виджет загрузки файлов основанный на html5
 * @package common\widgets\html5uploader
 * @author Churkin Anton <webadmin87@gmail.com>
 */

class Widget extends InputWidget {


    /**
     * @var \yii\web\AssetBundle класса бандла ресурсов
     */

    protected $assetClass;

    /**
     * @var string шаблон
     */

    public $tpl = "uploader";

    /**
     * @var string алиас DOCUMENT ROOT
     */

    public $webroot = "@webroot";

    /**
     * @var string url для загрузки файлов
     */

    public $uploadUrl;

    /**
     * @var int максимальный размер загружаемого файла
     */

    public $maxFileSize;

    /**
     * @inheritdoc
     */

    public function init() {

        $assetClass = $this->getAssetClass();

        $assetClass::register($this->view);

        $this->name = Html::getInputName($this->model, $this->attribute);

        $this->options = array_merge(["multiple"=>true, "id"=>$this->id], $this->options);

        $this->registerScripts();

    }

    /**
     * Решистрирует javascript инициализации виджета
     */

    protected function registerScripts() {

        $this->view->registerJs("

            $('#{$this->id}').html5Uploader({uploadUrl: '{$this->uploadUrl}', maxFileSize: '{$this->maxFileSize}'});

            $('.uploader-widget-files-list').sortable({
                update: function( event, ui ) {

                    ui.item.parents('ul').find('li').each(function(){

                        var li = $(this);

                        var i = li.index();


                        li.find('input').each(function(){

                            var name = $(this).attr('name');

                            name = name.replace(/\\[\\d+\\]/, '['+i+']');

                            $(this).attr('name', name);

                        });

                    });

                }
            });

        ");

    }

    /**
     * @inheritdoc
     */

    public function run() {

        $files = $this->model->{$this->attribute};

        return $this->render($this->tpl,[

            "name" => $this->name,
            "options" => $this->options,
            "maxFileSize" => 0,
            "files" =>$files,
            "webroot"=>$this->webroot,
        ]);

    }

    /**
     * Возвращает класс модуля ресурсов
     * @return string
     */

    public function getAssetClass() {

        if($this->assetClass === null) {

            $this->assetClass = AssetBundle::className();

        }

        return $this->assetClass;

    }

    /**
     * Устанавливает класс модуля ресурсов
     * @param string $class имя класса
     */

    public function setAssetClass($class) {

        $this->assetClass = $class;

    }

}
