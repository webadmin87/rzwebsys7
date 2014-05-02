<?php
namespace common\actions\crud;

use Yii;
use yii\web\ForbiddenHttpException;

/**
 * Class Delete
 * Класс действия для удаления модели
 * @package common\actions\crud
 * @author Churkin Anton <webadmin87@gmail.com>
 */

class Delete extends Base {

    /**
     * @var string url для редиректа по умолчанию, используется в отсутствие $redirectParam в запросе
     */

    public $defaultRedirectUrl = "admin";

    /**
     * Запуск действия удаления модели
     * @param integer $id идентификатор модели
     * @throws \yii\web\ForbiddenHttpException
     */

    public function run($id) {

        $model = $this->findModel($id);

        if(!Yii::$app->user->can('deleteModel', array("model"=>$model)))
            throw new ForbiddenHttpException('Forbidden');

        $model->delete();

        if(!Yii::$app->request->isAjax) {

            $returnUrl = Yii::$app->request->referrer;

            if(empty($returnUrl))
                $returnUrl = $this->defaultRedirectUrl;

            return $this->controller->redirect($returnUrl);

        }

    }



}