<?php
namespace common\actions\crud;

use Yii;
use yii\web\ForbiddenHttpException;
use yii\web\BadRequestHttpException;

/**
 * Class TCreate
 * Класс действия создания элемента древовидной модели
 * @package common\actions\crud
 * @author Churkin Anton <webadmin87@gmail.com>
 */

class TCreate extends Create {

    /**
     * Запуск действия
     * @param int $parent_id идентификатор родительской модели
     * @return string
     * @throws ForbiddenHttpException
     * @throws BadRequestHttpException
     */

    public function run($parent_id) {

        $class = $this->modelClass;

        $parentModel = $class::find()->where(["id"=>$parent_id])->one();

        if(!$parentModel)
            throw new BadRequestHttpException('Bad Request');

        $model = Yii::createObject(["class"=>$this->modelClass, 'scenario'=>$this->modelScenario]);

        $model->parent_id = $parent_id;

        if(!Yii::$app->user->can('createModel', array("model"=>$model)))
            throw new ForbiddenHttpException('Forbidden');

        $request = Yii::$app->request;

        $load = $model->load($request->post());

        $model->attributes = array_merge($this->defaultAttrs, $model->attributes);

        if ($load && $request->post($this->validateParam)) {
            return $this->performAjaxValidation($model);
        }

        if ($load && $model->appendTo($parentModel)) {


            if($request->post($this->applyParam))
                return $this->controller->redirect([$this->updateUrl, 'id' => $model->id]);
            else {


                $returnUrl = $request->post($this->redirectParam);

                if(empty($returnUrl))
                    $returnUrl = $this->defaultRedirectUrl;

                return $this->controller->redirect($returnUrl);

            }

        } else {

            return $this->render($this->tpl, [
                'model' => $model,
            ]);

        }

    }


}