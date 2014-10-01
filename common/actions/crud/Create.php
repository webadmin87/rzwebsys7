<?php
namespace common\actions\crud;

use Yii;
use yii\web\ForbiddenHttpException;

/**
 * Class Create
 * Класс действия создания элемента модели
 * @package common\actions\crud
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class Create extends Base
{

    /**
     * @var array атрибуты по умолчанию
     */

    public $defaultAttrs = [];

    /**
     * @var string сценарий для валидации
     */

    public $modelScenario = 'insert';

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

    public $defaultRedirectUrl = "/admin/";

    /**
     * @var string адрес для редиректа в случае нажатия кнопки применить
     */

    public $updateUrl = "update";

    /**
     * @var string путь к шаблону для отображения
     */

    public $tpl = "create";

    /**
     * Запуск действия
     * @return mixed
     * @throws ForbiddenHttpException
     */

    public function run()
    {

        $model = Yii::createObject(["class" => $this->modelClass, 'scenario' => $this->modelScenario]);

        if (!Yii::$app->user->can('createModel', array("model" => $model)))
            throw new ForbiddenHttpException('Forbidden');

        $this->checkForbiddenAttrs($model);

        $request = Yii::$app->request;

        $model->attributes = $this->defaultAttrs;

        $load = $model->load($request->post());

        if ($load && $request->post($this->validateParam)) {
            return $this->performAjaxValidation($model);
        }

        if (!Yii::$app->user->can('createModel', array("model" => $model)))
            throw new ForbiddenHttpException('Forbidden');

        if ($load && $model->save()) {

            $returnUrl = $request->post($this->redirectParam);

            if (empty($returnUrl))
                $returnUrl = $this->defaultRedirectUrl;

            if ($request->post($this->applyParam))
                return $this->controller->redirect([$this->updateUrl, 'id' => $model->id, $this->redirectParam => $returnUrl]);
            else {
                return $this->controller->redirect($returnUrl);
            }

        } else {

            return $this->render($this->tpl, [
                'model' => $model,
            ]);

        }

    }

}