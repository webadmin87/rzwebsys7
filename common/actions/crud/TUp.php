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
     * @inheritdoc
     */

    public function run($id)
    {

        $model = $this->findModel($id);

        if (!Yii::$app->user->can('updateModel', array("model" => $model)))
            throw new ForbiddenHttpException('Forbidden');

        $prevModel = $model->prev()->one();

        if ($prevModel)
            $model->insertBefore($prevModel);

        if (!Yii::$app->request->isAjax)
            return $this->goBack();

    }

}