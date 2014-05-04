<?php
namespace common\actions\crud;

use Yii;
use yii\web\ForbiddenHttpException;
/**
 * Class GroupDelete
 * Класс для группового удаления моделей
 * @package common\actions\crud
 * @author Churkin Anton <webadmin87@gmail.com>
 */

class GroupDelete extends Base {

    /**
     * @var string имя параметра в запросе в котором передаются идентификаторы материалов при групповых операциях
     */

    public $groupIdsAttr = "selection";

    /**
     * @var string сценарий для валидации
     */

    public $modelScenario = 'search';

    /**
     * @var string url для редиректа по умолчанию, используется в отсутствие $redirectParam в запросе
     */

    public $defaultRedirectUrl = "admin";


    /**
     * Запуск группового удалнеия моделей
     * @throws \yii\web\ForbiddenHttpException
     */

    public function run() {

        $class = $this->modelClass;

        $ids = Yii::$app->request->post($this->groupIdsAttr, array());

        if(!empty($ids)) {

            $query = $class::find()->where(['id'=>$ids]);

            foreach($query->each() as $model) {

                if(!Yii::$app->user->can('deleteModel', array("model"=>$model)))
                    throw new ForbiddenHttpException('Forbidden');

                $model->delete();

            }

        }

        if(!Yii::$app->request->isAjax) {

            $returnUrl = Yii::$app->request->referrer;

            if(empty($returnUrl))
                $returnUrl = $this->defaultRedirectUrl;

            return $this->controller->redirect($returnUrl);

        }

    }

}