<?php
namespace common\controllers;

use Yii;
use yii\web\Controller;

/**
 * Class App
 * Базовый контроллер для публичных модулей сайта
 * @package common\controllers
 * @author Churkin Anton <webadmin87@gmail.com>
 */

class App extends Controller {

    /**
     * @var string класс модели шаблонов
     */

    public $templateClass = "\\app\\modules\\main\\models\\Template";

    /**
     * @inheritdoc
     */

    public function init() {

        if(!Yii::$app->request->isAjax) {

            $this->initLayout();

        }

    }

    /**
     * Инициализирует шаблон
     */

    public function initLayout() {

        $class = $this->templateClass;

        $models = $class::find()->published()->orderBy(['sort'=>SORT_ASC])->all();

        foreach($models As $model){

            if($model->isSuitable())
                $this->layout = $model->code;

        }

    }

    /**
     * Рендерит html код, оборачивая в layout
     * @param string $output html код
     * @return string
     */

    public function renderHtml($output)
    {
        $layoutFile = $this->findLayoutFile($this->getView());
        if ($layoutFile !== false) {
            return $this->getView()->renderFile($layoutFile, ['content' => $output], $this);
        } else {
            return $output;
        }
    }

}