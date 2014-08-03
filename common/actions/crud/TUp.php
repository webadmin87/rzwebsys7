<?php
namespace common\actions\crud;

use Yii;
use yii\web\ForbiddenHttpException;

/**
 * Class TUp
 * Класс действия для перемещения вверх древовидной модели
 * @package common\actions\crud
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class TUp extends Base
{

    /**
     * @var string url для редиректа по умолчанию, используется в отсутствие $redirectParam в запросе
     */

    public $defaultRedirectUrl = "/admin/";

    /**
     * @inheritdoc
     */

    public function run($id)
    {

        $model = $this->findModel($id);

        if (!Yii::$app->user->can('updateModel', array("model" => $model)))
            throw new ForbiddenHttpException('Forbidden');

        $prevModel = $model->prev()->one();

        if ($prevModel)
            $model->moveBefore($prevModel);

        if (!Yii::$app->request->isAjax) {

            $returnUrl = Yii::$app->request->referrer;

            if (empty($returnUrl))
                $returnUrl = $this->defaultRedirectUrl;

            return $this->controller->redirect($returnUrl);

        }

    }

}