<?php
namespace common\widgets\launcher;

use yii\base\Widget;

/**
 * Class Launcher
 * Класс виджета для запуска действий через ajax с отображением процесса выполнения на прогресс баре.
 * Ответ действия должен быть в формате JSON: {"page": 1, "pagesNum": 10}
 * В случае ошибок ответ должен выглядеть:  {"page": 1, "pagesNum": 10, "errors": ["error1", "error2"]}
 * @package common\widgets\launcher
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class Launcher extends Widget {

    /**
     * @var string текст ссылки
     */

    public $label = "Start action";

    /**
     * @var string url адреса для запросов
     */

    public $url = '';

    /**
     * @var string шаблон
     */

    public $tpl = "index";

    /**
     * @inheritdoc
     */

    public function init() {

        AssetBundle::register($this->view);

        $this->view->registerJs("$('#{$this->getId()}').ajaxLauncher('{$this->url}')");

    }

    /**
     * @inheritdoc
     */

    public function run() {

        return $this->render($this->tpl, ["id"=>$this->getId(), "label"=>$this->label]);

    }



}