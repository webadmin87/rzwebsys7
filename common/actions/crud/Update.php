<?php
namespace common\actions\crud;

use Yii;
use yii\web\ForbiddenHttpException;

/**
 * Class Update
 * Класс действия обновления модели
 * @package common\actions\crud
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class Update extends Base {

    /**
     * @var string сценарий валидации
     */

    public $modelScenario = 'update';

    /**
     * @var string имя параметра запроса содержащего признак "применить"
     */

    public $applyParam = "apply";

    /**
     * @var string имя параметра запроса содержащего url для редиректа в случае успешного обновления
     */

    public $redirectParam = "returnUrl";

    /**
     * @var string url для редиректа по умолчанию, используется в отсутствие $redirectParam в запросе
     */

    public $defaultRedirectUrl = "/admin";

    /**
     * @var string путь к шаблону для отображения
     */

    public $view = "update";

    /**
     * Запуск действия
     * @param integer $id идентификатор модели
     * @return string
     * @throws \yii\web\ForbiddenHttpException
     */

    public function run($id) {

        $model = $this->findModel($id);

        if(!Yii::$app->user->can('updateModel', array("model"=>$model)))
            throw new ForbiddenHttpException('Forbidden');

        $model->setScenario($this->modelScenario);

        $request = Yii::$app->request;

        $load = $model->load(Yii::$app->request->post());

        if ($load && $request->post($this->validateParam)) {
            return $this->performAjaxValidation($model);
        }

        if ($load && $model->save() && !$request->post($this->applyParam)) {

            $returnUrl = $request->post($this->redirectParam);

            if(empty($returnUrl))
                $returnUrl = $this->defaultRedirectUrl;

            return $this->controller->redirect($returnUrl);

        } else {
            return $this->render($this->view, [
                'model' => $model,
            ]);
        }

    }










}