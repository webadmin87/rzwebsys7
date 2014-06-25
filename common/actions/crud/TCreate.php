<?php
namespace common\actions\crud;

use Yii;
use yii\web\ForbiddenHttpException;
use yii\web\BadRequestHttpException;
use common\db\TActiveRecord;

/**
 * Class TCreate
 * Класс действия создания элемента древовидной модели
 * @package common\actions\crud
 * @author Churkin Anton <webadmin87@gmail.com>
 */

class TCreate extends Create {

    /**
     * @var array массив атрибутов значения которых должны наследоваться от родительской модели
     */

    public $extendedAttrs = [];

    /**
     * Запуск действия
     * @param int $parent_id идентификатор родительской модели
     * @return string
     * @throws ForbiddenHttpException
     * @throws BadRequestHttpException
     */

    public function run($parent_id) {

        $class = $this->modelClass;

        $model = Yii::createObject(["class"=>$this->modelClass, 'scenario'=>$this->modelScenario]);

        $model->parent_id = $parent_id;

        if(!Yii::$app->user->can('createModel', array("model"=>$model)))
            throw new ForbiddenHttpException('Forbidden');

        $request = Yii::$app->request;

        $parentModel = $class::find()->where(["id"=>$model->parent_id])->one();

        if(!$parentModel)
            throw new BadRequestHttpException('Bad Request');

        if($parentModel->id != TActiveRecord::ROOT_ID AND !empty($this->extendedAttrs)) {

            foreach($this->extendedAttrs AS $attr)
                $model->$attr = $parentModel->$attr;

        }

        $model->attributes = $this->defaultAttrs;

        $load = $model->load($request->post());

        if ($load && $request->post($this->validateParam)) {
            return $this->performAjaxValidation($model);
        }

        if ($load && $model->appendTo($parentModel)) {

            $returnUrl = $request->post($this->redirectParam);

            if(empty($returnUrl))
                $returnUrl = $this->defaultRedirectUrl;

            if($request->post($this->applyParam))
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