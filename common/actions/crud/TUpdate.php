<?php
namespace common\actions\crud;

use Yii;
use yii\web\ForbiddenHttpException;

/**
 * Class TUpdate
 * Класс действия обновления древовидных моделей
 * @package common\actions\crud
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class TUpdate extends Update {

    /**
     * @inheritdoc
     */

    public function run($id) {

        $model = $this->findModel($id);

        if(!Yii::$app->user->can('updateModel', array("model"=>$model)))
            throw new ForbiddenHttpException('Forbidden');

        $model->setScenario($this->modelScenario);

        $this->checkForbiddenAttrs($model);

        $request = Yii::$app->request;

        $parentModel = $model->parent()->one();

        $model->parent_id = $parentModel->id;

        $load = $model->load(Yii::$app->request->post());

        if($parentModel->id != $model->parent_id) {
            $parentModel = $this->findModel($model->parent_id);
        } else {
            $parentModel = null;
        }

        if ($load && $request->post($this->validateParam)) {
            return $this->performAjaxValidation($model);
        }

        if($load && $parentModel)
            $res = $model->moveAsFirst($parentModel);
        elseif($load)
            $res = $model->saveNode();


        if (!empty($res) && !$request->post($this->applyParam)) {

            $returnUrl = $request->post($this->redirectParam);

            if(empty($returnUrl))
                $returnUrl = $this->defaultRedirectUrl;

            return $this->controller->redirect($returnUrl);

        } else {
            return $this->render($this->tpl, [
                'model' => $model,
            ]);
        }

    }

}