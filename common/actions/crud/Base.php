<?php
namespace common\actions\crud;

use Yii;
use yii\base\Action;
use yii\widgets\ActiveForm;
use yii\web\NotFoundHttpException;
use yii\web\Response;


/**
 * Class Base
 * Базовый класс для CRUD действий
 * @package common\actions\crud
 * @author Churkin Anton <webadmin87@gmail.com>
 */

class Base extends Action {


    /**
     * @var string имя класса модели
     */

    public $modelClass;

    /**
     * @var string путь к шаблону для отображения
     */

    public $view;

    /**
     * @var string название параметра запроса, который служит признаком ajax валидации
     */

    public $validateParam = "ajax";

    /**
     * @var array массив дополнительных параметров передаваемых в представление
     */

    public $viewParams = [];

    /**
     * Ajax валидация модели
     * @param \yii\db\ActiveRecord $model
     * @return array
     */

    protected function performAjaxValidation($model) {

        Yii::$app->response->format = Response::FORMAT_JSON;
        return ActiveForm::validate($model);

    }

    protected function findModel($id)
    {

        $class = $this->modelClass;

        if (($model = $class::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Рендеринг представления
     * @param string $view путь к представлению
     * @param array $params массив параметров передаваемых в представление
     * @return string
     */

    protected function render($view, $params = []) {

        $params = array_merge($params, $this->viewParams);

        return $this->controller->render($view, $params);

    }

    /**
     * Рендеринг представления без layout
     * @param string $view путь к представлению
     * @param array $params массив параметров передаваемых в представление
     * @return string
     */

    protected function renderPartial($view, $params = []) {

        $params = array_merge($params, $this->viewParams);

        return $this->controller->renderPartial($view, $params);

    }

}