<?php
namespace common\actions\crud;

use common\db\TActiveRecord;
use Yii;
use yii\helpers\Html;
use yii\web\BadRequestHttpException;
use yii\web\ForbiddenHttpException;

/**
 * Class TReplace
 * Класс действия для перемещения древовидных моделей в иерархии
 * @package common\actions\crud
 * @author Churkin Anton <webadmin87@gmail.com>
 */
class TReplace extends Base
{

    /**
     * @var string имя параметра в запросе в котором передаются идентификаторы материалов при групповых операциях
     */

    public $groupIdsAttr = "selection";

    /**
     * @var string имя параметра POST запроса в котором передается идентификатор категории в которую необходимо перенести модели
     */

    public $parentIdAttr = "replace_parent_id";

    /**
     * @inheritdoc
     */

    public function run()
    {

        $class = $this->modelClass;

        if (Yii::$app->request->isGet) {

            $ids = Yii::$app->request->get($this->groupIdsAttr, array());

            $model = Yii::createObject($class);

            $arr = $model->getListTreeData(TActiveRecord::ROOT_ID, $ids);

            foreach ($arr as $k => $v)
                echo Html::tag('option', $v, ["value" => $k]);

            Yii::$app->end();

        }

        if (Yii::$app->request->isPost) {

            $parent_id = Yii::$app->request->post($this->parentIdAttr);

            $parentModel = $this->findModel($parent_id);

            if (!$parentModel)
                throw new BadRequestHttpException("Bad request");

            $ids = Yii::$app->request->post($this->groupIdsAttr, array());

            if (!empty($ids)) {

                $query = $class::find()->where(['id' => $ids]);

                foreach ($query->each() as $model) {

                    if (!Yii::$app->user->can('updateModel', array("model" => $model)))
                        throw new ForbiddenHttpException('Forbidden');

                    $model->prependTo($parentModel);

                }

            }

        }

        if (!Yii::$app->request->isAjax)
            return $this->goBack();

    }

}