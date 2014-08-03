<?php
namespace common\actions\crud;

use common\db\TActiveRecord;
use Yii;
use yii\web\ForbiddenHttpException;

/**
 * Class XEditable
 * Класс действия обновления модели через расширение XEditable
 * @package common\actions\crud
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class XEditable extends Base
{

    /**
     * @var string сценарий валидации
     */

    public $modelScenario = 'update';

    /**
     * Запуск действия
     * @return boolean
     * @throws \yii\web\ForbiddenHttpException
     */

    public function run()
    {

        $request = Yii::$app->request;

        if ($request->isPost) {

            $model = $this->findModel($request->post('pk'));

            if (!Yii::$app->user->can('updateModel', array("model" => $model)))
                throw new ForbiddenHttpException('Forbidden');

            $model->setScenario($this->modelScenario);

            $model->{$request->post('name')} = $request->post('value');

            if ($model instanceof TActiveRecord) {
                return $model->saveNode();
            } else {
                return $model->save();
            }
        }

        return false;

    }

}