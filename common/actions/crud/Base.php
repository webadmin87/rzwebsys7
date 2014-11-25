<?php
namespace common\actions\crud;

use Yii;
use yii\base\Action;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * Class Base
 * Базовый класс для CRUD действий
 * @package common\actions\crud
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class Base extends Action
{

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
     * @var string url для редиректа по умолчанию, используется в отсутствие $redirectParam в запросе
     */

    public $defaultRedirectUrl = ["/main/admin"];

    /**
     * Ajax валидация модели
     * @param \yii\db\ActiveRecord $model
     * @return array
     */

    protected function performAjaxValidation($model)
    {

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

    protected function render($view, $params = [])
    {

        $params = array_merge($params, $this->viewParams);

        return $this->controller->render($view, $params);

    }

    /**
     * Рендеринг представления без layout
     * @param string $view путь к представлению
     * @param array $params массив параметров передаваемых в представление
     * @return string
     */

    protected function renderPartial($view, $params = [])
    {

        $params = array_merge($params, $this->viewParams);

        return $this->controller->renderAjax($view, $params);

    }

    /**
     * Проверяет попытку изменения запрещенных атрибутов
     * @param \common\db\ActiveRecord $model
     * @throws \yii\web\ForbiddenHttpException
     */

    protected function checkForbiddenAttrs($model)
    {

        $attrs = Yii::$app->request->post($model->formName(), []);

        $perm = $model->getPermission();

        if ($perm AND $perm->hasForbiddenAttrs($attrs))
            throw new ForbiddenHttpException('Forbidden');

    }

    /**
     * Возвращание на предыдущую страницу
     * @return \yii\web\Response
     */
    protected function goBack()
    {

        $returnUrl = Yii::$app->request->referrer;

        if (empty($returnUrl))
            $returnUrl = $this->defaultRedirectUrl;

        return $this->controller->redirect($returnUrl);

    }

}