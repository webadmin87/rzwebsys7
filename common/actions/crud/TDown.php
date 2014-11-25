<?php
namespace common\actions\crud;

use Yii;
use yii\web\ForbiddenHttpException;

/**
 * Class TDown
 * Класс действия для перемещения вниз древовидной модели
 * @package common\actions\crud
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class TDown extends Base
{

    /**
     * @inheritdoc
     */

    public function run($id)
    {

        $model = $this->findModel($id);

        if (!Yii::$app->user->can('updateModel', array("model" => $model)))
            throw new ForbiddenHttpException('Forbidden');

        $nextModel = $model->next()->one();

        if ($nextModel)
            $model->moveAfter($nextModel);

        if (!Yii::$app->request->isAjax)
            return $this->goBack();

    }

}